<?php

namespace Caravy\Support;

class Str
{
    /**
     * Prepend chars to a string.
     * 
     * @param string $string
     * @param string $chars
     * @return string
     */
    public static function prepend($string, $prepend)
    {
        return $prepend . $string;
    }

    /**
     * Append chars to a string.
     * 
     * @param string $string
     * @param string $chars
     * @return string
     */
    public static function append($string, $append)
    {
        return $string . $append;
    }

    /**
     * Append and prepend different chars to a string.
     * 
     * @param string $string
     * @param string $prepend
     * @param string $append
     * @return string
     */
    public static function asymetric($string, $prepend, $append)
    {
        return $prepend . $string . $append;
    }

    /**
     * Append and prepend the same chars to a string.
     * 
     * @param string $string
     * @param string $value
     * @return string
     */
    public static function symetric($string, $chars)
    {
        return static::asymetric($string, $chars, $chars);
    }

    /**
     * Combine multiple strings to a single string.
     * 
     * @param array $strings
     * @return string
     */
    public static function combine($strings, $seperator = null)
    {
        $string = '';
        if (Arr::isArr($strings)) {
            for ($i = 0; $i < count($strings); $i++) {
                if (is_null($seperator)) {
                    $string = $string . $strings[$i];
                } else {
                    $string = $string . (empty($string) ? '' : $seperator) . $strings[$i];
                }
            }
            return $string;
        }
        return $strings;
    }

    /**
     * Check wether the haystack contains a needle/needles.
     * 
     * @param string $haystack
     * @param string|string[] $needles
     * @return bool
     */
    public static function contains($haystack, $needles)
    {
        if (Arr::isArr($needles)) {
            foreach ($needles as $needle) {
                if (strpos($haystack, $needle) === false) {
                    return false;
                }
            }
        } else {
            return strpos($haystack, $needles);
        }
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|string[]  $needles
     * @return bool
     */
    public static function startsWith($haystack, $needles)
    {
        if (Arr::isArr($needles)) {
            foreach ($needles as $needle) {
                if ($needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
                    return true;
                }
            }
        } else {
            if ($needles !== '' && strncmp($haystack, $needles, strlen($needles)) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the length of a string.
     * 
     * @param string $string
     * @return int
     */
    public static function length($string)
    {
        return strlen($string);
    }
}
