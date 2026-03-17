# maarheeze/uuid-symfony

Symfony integration for [maarheeze/uuid](https://github.com/maarheeze/uuid). Provides a serializer normalizer for using UUIDs with the Symfony Serializer component.

## Requirements

- PHP 8.2+
- Symfony 8+

## Installation

```bash
composer require maarheeze/uuid-symfony
```

## Usage

### Registering the normalizer

Register `UuidNormalizer` as a service in your Symfony application. When using autoconfiguration it will be picked up automatically.

```yaml
services:
    Maarheeze\Uuid\Symfony\Component\Serializer\Normalizer\UuidNormalizer: ~
```

### Normalizing a UUID

```php
use Maarheeze\Uuid\Uuid;

$uuid = Uuid::generate();

$serializer->normalize($uuid); // '018e4c7a-3b2f-7000-8000-000000000000'
```

### Denormalizing a UUID

```php
use Maarheeze\Uuid\UuidInterface;

$uuid = $serializer->denormalize('018e4c7a-3b2f-7000-8000-000000000000', UuidInterface::class);
```

## License

MIT
