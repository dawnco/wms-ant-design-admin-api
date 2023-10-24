<?php

declare(strict_types=1);

/**
 * @author Dawnc
 * @date   2022-05-25
 */

namespace App\Lib;

class ArrUtil
{
    public static function toTree(array $items, string $id = 'id', string $pid = 'pid', string $children = 'children')
    {
        foreach ($items as $item) {
            $items[$item[$pid]][$children][$item[$id]] = &$items[$item[$id]];
        }
        return isset($items[0][$children]) ? $items : array();
    }

    public static function toTreeArr(
        $array,
        $keyName = 'id',
        $parentKeyName = 'pid',
        $childrenKeyName = 'children'
    ) {
        $ret = [
            [$keyName => 0, 'name' => 'root', $childrenKeyName => []]
        ];
        foreach ($array as &$item) {
            $item[$childrenKeyName] = [];
            $ret[$item[$keyName]] = &$item;
        }
        unset($item);

        foreach ($array as &$item) {
            $ret[$item[$parentKeyName]][$childrenKeyName][] = &$item;
        }
        unset($item);

        return $ret[0][$childrenKeyName];
    }
}
