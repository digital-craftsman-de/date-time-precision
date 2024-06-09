<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Serializer;

use DigitalCraftsman\DateTimePrecision\Weekdays;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class WeekdaysNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof Weekdays;
    }

    /** @param class-string $type */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === Weekdays::class;
    }

    /** @param Weekdays|null $object */
    public function normalize($object, $format = null, array $context = []): ?array
    {
        return $object?->normalize();
    }

    /** @param ?array $data */
    public function denormalize($data, $type, $format = null, array $context = []): ?Weekdays
    {
        return $data === null
            ? null
            : Weekdays::denormalize($data);
    }

    /**
     * @return array<class-string, bool>
     *
     * @codeCoverageIgnore
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Weekdays::class => true,
        ];
    }
}
