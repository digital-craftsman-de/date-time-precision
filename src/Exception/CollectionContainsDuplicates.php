<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision\Exception;

/**
 * @psalm-immutable
 */
final class CollectionContainsDuplicates extends \InvalidArgumentException
{
    /**
     * @param class-string $collectionClass
     */
    public function __construct(string $collectionClass)
    {
        parent::__construct(sprintf(
            'The collection %s must not contain duplicates.',
            $collectionClass,
        ));
    }
}
