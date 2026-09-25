# API-клиент для АТОЛ.Онлайн

PHP-клиент для API сервиса онлайн-фискализации платежей АТОЛ.Онлайн (ФФД 1.05)

Текущая версия документа: 5.24

- Документация АТОЛ: https://atol.online/library/?tab=devs
- Поддерживаемая версия PHP: `8.2+`

## Установка

```bash
composer require wrdev/atol-v4-client
```

## Пример использования

Подробный пример (включая настройку токена) вынесен в `docs/usage.md`:

- [Как использовать пакет](docs/usage.md)

## Поддерживаемые операции

- `sell(RegisterRequest): RegisterResponse`
- `sellRefund(RegisterRequest): RegisterResponse`
- `sellCorrection(CorrectionRequest): CorrectionResponse`
- `sellCorrectionRefund(CorrectionRequest): CorrectionResponse`
- `report(string $uuid): ReportResponse`
- `checkStatus(string $uuid): ReportResponse` (alias `report`)

## Обработка ошибок

Пакет выбрасывает типизированные исключения:

- `WrDev\AtolV4Client\Common\BadRequestException` - валидация данных клиента или DTO.
- `WrDev\AtolV4Client\Common\AuthenticationException` - ошибка получения токена.
- `WrDev\AtolV4Client\Common\TransportException` - сетевые/транспортные проблемы.
- `WrDev\AtolV4Client\Common\ApiException` - API-ошибка АТОЛ (включая детали ответа).