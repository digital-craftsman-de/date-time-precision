<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Serializer;

use DigitalCraftsman\DateTimePrecision\Year;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class YearNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        return $data instanceof Year;
    }

    /** @param class-string $type */
    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        return $type === Year::class;
    }

    /** @param Year|null $object */
    public function normalize($object, $format = null, array $context = []): ?int
    {
        return $object === null
            ? null
            : $object->year;
    }

    /** @param int|null $data */
    public function denormalize($data, $type, $format = null, array $context = []): ?Year
    {
        return $data === null
            ? null
            : new Year($data);
    }

    /**
     * @return array<class-string, bool>
     *
     * @codeCoverageIgnore
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            Year::class => true,
        ];
    }
}
