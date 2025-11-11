# Amazon FBA Shipping Service

Сервис для отправки заказов через Amazon FBA (Fulfillment by Amazon).

## Требования

- PHP 8.0 или выше
- Composer

## Установка

1. Установите зависимости через Composer:

```bash
composer install
```

## Запуск проекта

Запустите встроенный PHP сервер:

```bash
php -S localhost:8000 -t public
```

Сервис будет доступен по адресу: `http://localhost:8000`

### Пример использования

Отправка POST запроса на `/ship`:

```bash
curl -X POST http://localhost:8000/ship \
  -H "Content-Type: application/json" \
  -d '{"order_id": 16400, "buyer_id": 29664}'
```

## Запуск тестов

Запустите все тесты:

```bash
vendor/bin/phpunit
```
