<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\Serializer;

use DigitalCraftsman\DateTimeUtils\ValueObject\Date;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class DateNormalizer implements NormalizerInterface, DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof Date;
    }

    /** @param class-string $type */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === Date::class;
    }

    /** @param Date|null $object */
    public function normalize($object, $format = null, array $context = []): ?string
    {
        if ($object === null) {
            return null;
        }

        return (string) $object;
    }

    /** @param ?string $data */
    public function denormalize($data, $type, $format = null, array $context = []): ?Date
    {
        if ($data === null) {
            return null;
        }

        return Date::fromString($data);
    }

    /** @codeCoverageIgnore */
    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
