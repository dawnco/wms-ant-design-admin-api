<?php

declare(strict_types=1);

/**
 * @author Dawnc
 * @date   2022-05-29
 */

namespace App\Lib;


use Wms\Lib\WRedis;

/**
 */
class IdGenerator
{

    private const START_TIMESTAMP = 1577808000000; // 2020-01-01 毫秒

    public static function id()
    {
        $interval = intval(microtime(true) * 1000) - self::START_TIMESTAMP;  // 42位
        $dataCenterId = 1; // 数据中心或者国家 最大值 31
        $workerId = 1; // 服务器id 最大值  31
        // $sequence = rand(0, 4095);   // 顺序ID  最大值 4095
        $sequence = self::incr("{$dataCenterId}-{$workerId}-ID");   // 顺序ID  最大值 4095
        $id = ($interval << 22) | ($dataCenterId << 17) | ($workerId << 12) | $sequence;
        return $id;
    }

    public static function incr($key)
    {
        $redis = WRedis::connection();
        $incr = $redis->incr($key);
        return $incr;
    }

    public static function meta($id)
    {
        $bin = base_convert((string)$id, 10, 2);
        $bin = str_pad($bin, 64, '0', STR_PAD_LEFT);

        $interval = substr($bin, 0, 42);
        $dataCenterId = substr($bin, 42, 5);
        $workerId = substr($bin, 47, 5);
        $sequence = substr($bin, 52);

        return [
            'interval' => bindec($interval) + self::START_TIMESTAMP,
            'dataCenterId' => bindec($dataCenterId),
            'workerId' => bindec($workerId),
            'sequence' => bindec($sequence),
        ];
    }
}
