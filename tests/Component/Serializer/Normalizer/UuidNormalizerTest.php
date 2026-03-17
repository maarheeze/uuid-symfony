<?php

declare(strict_types=1);

namespace Tests\Component\Serializer\Normalizer;

use Maarheeze\Uuid\Symfony\Component\Serializer\Normalizer\UuidNormalizer;
use Maarheeze\Uuid\Uuid;
use Maarheeze\Uuid\UuidException;
use Maarheeze\Uuid\UuidInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class UuidNormalizerTest extends TestCase
{
    public function testNormalizeReturnsUuidString(): void
    {
        $uuid = Uuid::fromString('550e8400-e29b-41d4-a716-446655440000');
        $result = (new UuidNormalizer())->normalize($uuid);

        $this->assertSame('550e8400-e29b-41d4-a716-446655440000', $result);
    }

    public function testNormalizeThrowsExceptionForNonUuid(): void
    {
        $this->expectException(UuidException::class);

        (new UuidNormalizer())->normalize('not-a-uuid-object');
    }

    public function testSupportsNormalizationReturnsTrueForUuid(): void
    {
        $uuid = Uuid::fromString('550e8400-e29b-41d4-a716-446655440000');

        $this->assertTrue((new UuidNormalizer())->supportsNormalization($uuid));
    }

    #[DataProvider('nonUuidValuesProvider')]
    public function testSupportsNormalizationReturnsFalseForNonUuid(mixed $value): void
    {
        $this->assertFalse((new UuidNormalizer())->supportsNormalization($value));
    }

    /**
     * @return array<string, list<string|int|null>>
     */
    public static function nonUuidValuesProvider(): array
    {
        return [
            'string' => ['a-string'],
            'integer' => [42],
            'null' => [null],
        ];
    }

    public function testDenormalizeReturnsUuidInterface(): void
    {
        $result = (new UuidNormalizer())->denormalize('550e8400-e29b-41d4-a716-446655440000', UuidInterface::class);

        $this->assertSame('550e8400-e29b-41d4-a716-446655440000', $result->toString());
    }

    public function testDenormalizeThrowsExceptionForNonString(): void
    {
        $this->expectException(UuidException::class);

        (new UuidNormalizer())->denormalize(42, UuidInterface::class);
    }

    public function testSupportsDenormalizationReturnsTrueForUuidInterface(): void
    {
        $this->assertTrue((new UuidNormalizer())->supportsDenormalization('any', UuidInterface::class));
    }

    #[DataProvider('nonUuidTypesProvider')]
    public function testSupportsDenormalizationReturnsFalseForOtherTypes(string $type): void
    {
        $this->assertFalse((new UuidNormalizer())->supportsDenormalization('any', $type));
    }

    /**
     * @return array<object, list<string>>
     */
    public static function nonUuidTypesProvider(): array
    {
        return [
            'stdClass' => [stdClass::class],
            'string type' => ['string'],
        ];
    }

    #[DataProvider('formatsProvider')]
    public function testGetSupportedTypesReturnsExpectedArray(?string $format): void
    {
        $this->assertSame([UuidInterface::class => false], (new UuidNormalizer())->getSupportedTypes($format));
    }

    /**
     * @return array<string, list<?string>>
     */
    public static function formatsProvider(): array
    {
        return [
            'null format' => [null],
            'json format' => ['json'],
        ];
    }
}
