<?php

namespace Caravy\Support;

class Arr
{
    /**
     * Get the first element of an array.
     * 
     * @param array $array
     * @return mixed
     */
    public static function first($array)
    {
        if (static::assoc($array)) {
            $firstPair = [];
            $lastPair[array_key_first($array)] = $array[array_key_first($array)];
            return $lastPair;
        }
        return $array[0];
    }

    /**
     * Get the last element of an array.
     * 
     * @param array $array
     * @return mixed
     */
    public static function last($array)
    {
        if (static::assoc($array)) {
            $lastPair = [];
            $lastPair[array_key_last($array)] = $array[array_key_last($array)];
            return $lastPair;
        }
        return $array[count($array) - 1];
    }

    /**
     * Check wether the array is associative.
     * 
     * @param array $array
     * @return bool
     */
    public static function assoc($array)
    {
        if (array() === $array) {
            return false;
        }
        return array_keys($array) !== range(0, count($array) - 1);
    }

    /**
     * Add an element to an array.
     * 
     * @param array $array
     * @param mixed $key
     * @param mixed $value
     * @return array
     */
    public static function add($array, $key, $value = null)
    {
        if (static::assoc($array)) {
            if (is_null($value) === false) {
                $array[$key] = $value;
            }
        } else {
            array_push($array, $key);
        }
        return $array;
    }

    /**
     * Remove an element from the array.
     * 
     * @param array $array
     * @param mixed $key
     * @return array
     */
    public static function remove($array, $key)
    {
        if (static::has($array, $key)) {
            if (static::assoc($array)) {
                unset($array[$key]);
            } else {
                for ($i = 0; $i < count($array); $i++) {
                    if ($key === $array[$i]) {
                        unset($array[$i]);
                    }
                }
            }
        }
        return $array;
    }

    /**
     * Check wether the key exists in an array.
     * 
     * @param array $array
     * @param mixed $key
     * @return bool
     */
    public static function has($array, $key)
    {
        if (static::assoc($array)) {
            return array_key_exists($key, $array);
        }
        foreach ($array as $entry) {
            if ($key === $entry) {
                return true;
            }
        }
        return false;
    }

    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @param array $array
     * @return array
     */
    public static function divide($array)
    {
        return [array_keys($array), array_values($array)];
    }

    /**
     * Get the position of an element in an array.
     * 
     * @param array $array
     * @param mixed $key
     * @return int|null
     */
    public static function position($array, $key)
    {
        $index = 0;
        if (static::assoc($array)) {
            $arrayKeys = array_keys($array);
            foreach ($arrayKeys as $arrayKey) {
                if ($key === $arrayKey) {
                    return $index;
                } else {
                    $index++;
                    continue;
                }
            }
        } else {
            foreach ($array as $element) {
                if ($key === $element) {
                    return $index;
                } else {
                    $index++;
                    continue;
                }
            }
        }
        return null;
    }
}
