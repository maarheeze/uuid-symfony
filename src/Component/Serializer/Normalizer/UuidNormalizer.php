<?php

declare(strict_types=1);

namespace Maarheeze\Uuid\Symfony\Component\Serializer\Normalizer;

use Maarheeze\Uuid\Uuid;
use Maarheeze\Uuid\UuidException;
use Maarheeze\Uuid\UuidInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use function is_a;
use function is_string;

class UuidNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function normalize(mixed $data, ?string $format = null, array $context = []): string
    {
        if (! $data instanceof UuidInterface) {
            throw new UuidException('Cannot normalize an value that is not a uuid-object');
        }

        return $data->toString();
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof UuidInterface;
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): UuidInterface
    {
        if (! is_string($data)) {
            throw new UuidException('Cannot denormalize an value that is not a string');
        }

        return Uuid::fromString($data);
    }

    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        return is_a($type, UuidInterface::class, true);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [UuidInterface::class => false];
    }
}
