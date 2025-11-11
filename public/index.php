<?php

declare(strict_types=1);

/**
 * Entry point for the Amazon FBA Shipping Service application.
 *
 * Implements lightweight routing, dependency injection, and error handling.
 */

require_once __DIR__.'/../vendor/autoload.php';

use App\Application\Services\ShipOrderService;
use App\Http\Controller\ShippingController;
use App\Infrastructure\Amazon\Clients\FBAClient;
use App\Infrastructure\Amazon\Factory\FBAFulfillmentOrderDTOFactory;
use App\Infrastructure\Amazon\Repositories\BuyerRepository;
use App\Infrastructure\Amazon\Repositories\OrderRepository;
use App\Infrastructure\Amazon\Services\AmazonFBAShippingService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * -------------------------------------------------------------
 *  Simple Dependency Container
 * -------------------------------------------------------------
 */
$container = [
    'fbaClient' => fn () => new FBAClient,
    'fbaOrderDTOFactory' => fn () => new FBAFulfillmentOrderDTOFactory,
    'shippingService' => fn ($c) => new AmazonFBAShippingService(
        fbaClient: $c['fbaClient'](),
        fbaOrderDTOFactory: $c['fbaOrderDTOFactory'](),
        marketplaceId: $_ENV['AMAZON_FBA_MARKETPLACE_ID'] ?? 'ATVPDKIKX0DER'
    ),
    'orderRepository' => fn () => new OrderRepository,
    'buyerRepository' => fn () => new BuyerRepository,
    'shipOrderService' => fn ($c) => new ShipOrderService(
        shippingService: $c['shippingService']($c),
        orderRepository: $c['orderRepository'](),
        buyerRepository: $c['buyerRepository']()
    ),
    'shippingController' => fn ($c) => new ShippingController(
        shipOrderService: $c['shipOrderService']($c)
    ),
];

/**
 * -------------------------------------------------------------
 *  Basic Router
 * -------------------------------------------------------------
 */
$routes = [
    'POST' => [
        '/ship' => ['controller' => 'shippingController', 'action' => 'shipOrder'],
    ],
];

// Create HTTP request
$request = Request::createFromGlobals();

try {
    $method = $request->getMethod();
    $path = parse_url($request->getPathInfo(), PHP_URL_PATH);

    // Match route
    if (! isset($routes[$method][$path])) {
        throw new \RuntimeException('Endpoint not found', Response::HTTP_NOT_FOUND);
    }

    $route = $routes[$method][$path];
    $controller = $container[$route['controller']]($container);

    // Execute controller action
    $response = $controller->{$route['action']}($request);

    if (! $response instanceof Response) {
        $response = new JsonResponse($response);
    }

} catch (\InvalidArgumentException $e) {
    $response = new JsonResponse([
        'success' => false,
        'error' => $e->getMessage(),
    ], Response::HTTP_BAD_REQUEST);
} catch (\RuntimeException $e) {
    $response = new JsonResponse([
        'success' => false,
        'error' => $e->getMessage(),
    ], $e->getCode() ?: Response::HTTP_NOT_FOUND);
} catch (\Throwable $e) {
    // Generic fallback with safe output
    $response = new JsonResponse([
        'success' => false,
        'error' => 'Internal server error',
    ], Response::HTTP_INTERNAL_SERVER_ERROR);

    // Optional: log full details (e.g. Monolog)
    error_log(sprintf(
        "[%s] %s in %s:%d\nTrace:\n%s\n",
        date('Y-m-d H:i:s'),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    ));
}

$response->send();
