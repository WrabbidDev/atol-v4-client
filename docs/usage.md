# Как использовать пакет

## Базовый пример

```php
<?php

use WrDev\AtolV4Client\Client\ClientBuilder;
use WrDev\AtolV4Client\DTO\Register\Client as Customer;
use WrDev\AtolV4Client\DTO\Register\Company;
use WrDev\AtolV4Client\DTO\Register\Item;
use WrDev\AtolV4Client\DTO\Register\Payment;
use WrDev\AtolV4Client\DTO\Register\PaymentMethod;
use WrDev\AtolV4Client\DTO\Register\PaymentObject;
use WrDev\AtolV4Client\DTO\Register\PaymentType;
use WrDev\AtolV4Client\DTO\Register\Receipt;
use WrDev\AtolV4Client\DTO\Register\RegisterRequest;
use WrDev\AtolV4Client\DTO\Register\Service;
use WrDev\AtolV4Client\DTO\Register\Sno;
use WrDev\AtolV4Client\DTO\Register\Vat;
use WrDev\AtolV4Client\DTO\Register\VatType;

$client = (new ClientBuilder())
    ->setAuth('atol-login', 'atol-password')
    ->setGroupCode('your-group-code')
    ->useTestEnvironment() // убрать для production
    ->build();

$customer = new Client('customer@example.com', '+79990000000');
$company = (new Company('shop@example.com', '7701234567', 'https://shop.example.com'))
    ->setSno(Sno::USN_INCOME);

$item = (new Item(
    'Тестовый товар',
    100.00,
    1.0,
    100.00,
    PaymentMethod::FULL_PAYMENT,
    new Vat(VatType::NONE, 0.0),
))->setPaymentObject(PaymentObject::COMMODITY);

$payment = new Payment(PaymentType::ELECTRONIC, 100.00);
$receipt = new Receipt($customer, $company, [$item], [$payment], 100.00);
$service = new Service('https://shop.example.com/atol-callback');

$request = new RegisterRequest(
    externalId: 'order-10001',
    receipt: $receipt,
    timestamp: new DateTime('now', new DateTimeZone('Europe/Moscow'))
);
$request->setService($service);

$registerResponse = $client->sell($request);
$uuid = $registerResponse->getUuid();

if ($uuid !== null) {
    $reportResponse = $client->report($uuid);
    // $reportResponse->getStatus(): done|wait|fail
}
```

## Токен: header или query

По умолчанию токен передается в HTTP-заголовке `Token`.

```php
$client = (new ClientBuilder())
    ->setAuth('atol-login', 'atol-password')
    ->setGroupCode('your-group-code')
    ->useTokenInHeader() // default behavior
    ->build();
```

При необходимости можно переключить передачу токена в query string (`?token=...`):

```php
$client = (new ClientBuilder())
    ->setAuth('atol-login', 'atol-password')
    ->setGroupCode('your-group-code')
    ->useTokenInQuery()
    ->build();
```

## Обработка callback payload

Для callback payload используйте `ResponseFactory::createCallbackResponse()`.
Тип бизнес-операции (`sell`, `sell_refund`, `sell_correction` и т.д.) определяйте по своим данным,
сохраненным при отправке чека (например, по `uuid` или `external_id`), а не по форме callback payload.

```php
use WrDev\AtolV4Client\Client;
use WrDev\AtolV4Client\Factory\ResponseFactory;

$validator = Client::createDefaultValidator();
$serializer = Client::createDefaultSerializer();
$responseFactory = new ResponseFactory($serializer, $validator);

/** @var array<string, mixed> $payload */
$callbackResponse = $responseFactory->createCallbackResponse($payload);
```
