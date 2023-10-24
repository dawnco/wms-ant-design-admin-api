<?php
/**
 * @author Dawnc
 * @date   2020-05-28
 */

namespace App\Lib\Util;


class Session
{
    /**
     * @var SID
     */
    private static SID $sid;

    public static function start(string $sessionId)
    {
        self::$sid = new SID($sessionId);
    }

    public static function new(array $info): string
    {
        return self::$sid->red($info);
    }

    public static function set($key, $val)
    {
        return self::$sid->set($key, $val);
    }

    public static function get($key)
    {
        return self::$sid->get($key);
    }
}
