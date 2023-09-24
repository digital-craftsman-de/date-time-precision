<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Serializer;

use DigitalCraftsman\DateTimePrecision\Time;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class TimeNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof Time;
    }

    /** @param class-string $type */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === Time::class;
    }

    /** @param Time|null $object */
    public function normalize($object, $format = null, array $context = []): ?string
    {
        return $object === null
            ? null
            : (string) $object;
    }

    /** @param ?string $data */
    public function denormalize($data, $type, $format = null, array $context = []): ?Time
    {
        return $data === null
            ? null
            : Time::fromString($data);
    }

    /**
     * @return array<class-string, bool>
     *
     * @codeCoverageIgnore
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Time::class => true,
        ];
    }
}
