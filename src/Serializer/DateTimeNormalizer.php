<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Serializer;

use DigitalCraftsman\DateTimePrecision\DateTime;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class DateTimeNormalizer implements NormalizerInterface, DenormalizerInterface
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
        return $object === null
            ? null
            : (string) $object;
    }

    /** @param string|null $data */
    public function denormalize($data, $type, $format = null, array $context = []): ?DateTime
    {
        return $data === null
            ? null
            : DateTime::fromString($data);
    }

    /**
     * @return array<class-string, bool>
     *
     * @codeCoverageIgnore
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            DateTime::class => true,
        ];
    }
}
