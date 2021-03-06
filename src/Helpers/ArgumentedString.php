<?php
/*
 * Copyright 2020 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Core\Helpers;

class ArgumentedString
{
    public const DELIMITER = ':';

    /**
     * Extracts an argumented string.
     *
     * @param string $stringWithArguments
     * @return Argumented
     */
    public static function extract(string $stringWithArguments): Argumented
    {
        return self::fromArray(explode(self::DELIMITER, $stringWithArguments));
    }

    /**
     * Checks if the given string is an argumented string.
     *
     * @param string $stringToTest
     * @param int $minimumArguments
     * @return bool
     */
    public static function is(string $stringToTest, int $minimumArguments = 1): bool
    {
        return count(self::extract($stringToTest)->getArguments()) >= $minimumArguments;
    }

    /**
     * Creates an Argumented instance from an array.
     *
     * @param array $array
     * @return Argumented
     */
    public static function fromArray(array $array): Argumented
    {
        return new Argumented($array[0], count($array) > 1 ? array_slice($array, 1) : []);
    }
}
