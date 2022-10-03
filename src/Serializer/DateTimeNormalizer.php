<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeUtils\Serializer;

use DigitalCraftsman\DateTimeUtils\ValueObject\DateTime;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class DateTimeNormalizer implements NormalizerInterface, DenormalizerInterface, CacheableSupportsMethodInterface
{
    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof DateTime;
    }

    /** @param class-string $type */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === DateTime::class;
    }

    /** @param DateTime|null $object */
    public function normalize($object, $format = null, array $context = []): ?string
    {
        if ($object === null) {
            return null;
        }

        return $object->format(\DateTimeInterface::ATOM);
    }

    /** @param string|null $data */
    public function denormalize($data, $type, $format = null, array $context = []): ?DateTime
    {
        if ($data === null) {
            return null;
        }

        return DateTime::fromString($data);
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}
