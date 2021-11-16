<?php


namespace App\Utilities;
/**
 * Copyright © Checkout Team, Inc. All rights reserved.
 */

class Random
{
    /**#@+
     * Frequently used character classes
     */
    const CHARS_LOWERS = 'abcdefghijklmnopqrstuvwxyz';

    const CHARS_UPPERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    const CHARS_DIGITS = '0123456789';

    /**#@-*/

    /**
     * Get random string.
     *
     * @param int $length
     * @param null|string $chars
     *
     * @return string
     */
    public function getRandomString($length, $chars = null)
    {
        $str = '';
        if (null === $chars) {
            $chars = self::CHARS_LOWERS . self::CHARS_UPPERS . self::CHARS_DIGITS;
        }

        $charsMaxKey = mb_strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[self::getRandomNumber(0, $charsMaxKey)];
        }

        return $str;
    }

    /**
     * Return a random number in the specified range
     * @param int $min
     * @param int $max
     * @return int  A random integer value between min (or 0) and max
     */
    public static function getRandomNumber($min = 0, $max = null)
    {
        if (null === $max) {
            $max = mt_getrandmax();
        }

        if ($max < $min) {
            abort('403','Invalid range given.');
        }

        return random_int($min, $max);
    }

    /**
     * Generate a hash from unique ID.
     *
     * @param string $prefix
     * @return string
     */
    public function getUniqueHash($prefix = '')
    {
        return $prefix . $this->getRandomString(32);
    }
}
