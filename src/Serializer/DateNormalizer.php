<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimeParts\Serializer;

use DigitalCraftsman\DateTimeParts\Date;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class DateNormalizer implements NormalizerInterface, DenormalizerInterface
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
        return $object === null
            ? null
            : (string) $object;
    }

    /** @param ?string $data */
    public function denormalize($data, $type, $format = null, array $context = []): ?Date
    {
        return $data === null
            ? null
            : Date::fromString($data);
    }

    /**
     * @return array<class-string, bool>
     *
     * @codeCoverageIgnore
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Date::class => true,
        ];
    }
}
