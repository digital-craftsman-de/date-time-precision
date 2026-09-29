<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

use DigitalCraftsman\SelfAwareNormalizers\Doctrine\StringNormalizableTypeWithMaxLength;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableStringDenormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\NullableStringDenormalizableTrait;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\StringNormalizable;
use DigitalCraftsman\SelfAwareNormalizers\Serializer\StringNormalizableEnumTrait;

enum RecurrenceFrequency: string implements StringNormalizable, StringNormalizableTypeWithMaxLength, NullableStringDenormalizable
{
    use StringNormalizableEnumTrait;
    use NullableStringDenormalizableTrait;

    case DAILY = 'DAILY';
    case WEEKLY = 'WEEKLY';
    case MONTHLY = 'MONTHLY';

    /**
     * @codeCoverageIgnore
     */
    #[\Override]
    public static function maxLength(): int
    {
        return 7;
    }
}
