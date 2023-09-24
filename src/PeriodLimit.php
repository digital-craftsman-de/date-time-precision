<?php

declare(strict_types=1);

namespace DigitalCraftsman\DateTimePrecision;

enum PeriodLimit: string
{
    case INCLUDING_START_AND_END = 'INCLUDING_START_AND_END';
    case INCLUDING_START = 'INCLUDING_START';
    case INCLUDING_END = 'INCLUDING_END';
    case EXCLUDING_START_AND_END = 'EXCLUDING_START_AND_END';
}
