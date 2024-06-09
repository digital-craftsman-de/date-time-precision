<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Serializer;

use DigitalCraftsman\DateTimePrecision\Weekday;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class WeekdayNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof Weekday;
    }

    /** @param class-string $type */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === Weekday::class;
    }

    /** @param Weekday|null $object */
    public function normalize($object, $format = null, array $context = []): ?string
    {
        return $object === null
            ? null
            : $object->value;
    }

    /** @param ?string $data */
    public function denormalize($data, $type, $format = null, array $context = []): ?Weekday
    {
        return $data === null
            ? null
            : Weekday::from($data);
    }

    /**
     * @return array<class-string, bool>
     *
     * @codeCoverageIgnore
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Weekday::class => true,
        ];
    }
}
