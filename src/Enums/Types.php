<?php

namespace DatabaseDrivers\Enums;

enum Types: int
{
    case NULL = 0;

    case INTEGER = 1;

    case STRING = 2;

    case LARGE_OBJECT = 3;

    case BOOLEAN = 5;

    case BINARY = 16;

    case ASCII = 17;


}