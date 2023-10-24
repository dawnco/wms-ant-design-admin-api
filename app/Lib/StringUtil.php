<?php

declare(strict_types=1);

/**
 * @author Hi Developer
 * @date   2022-05-24
 */

namespace App\Lib;

class StringUtil
{
    /**
     * 下划线转驼峰
     * @param $camelize
     * @param $separator
     * @return string
     */
    public static function camelize($camelize, $separator = '_')
    {
        $camelize = $separator . str_replace($separator, " ", strtolower($camelize));
        return ltrim(str_replace(" ", "", ucwords($camelize)), $separator);
    }


    /**
     * 驼峰转下划线
     * @param $camelCaps
     * @param $separator
     * @return string
     */
    public static function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}
