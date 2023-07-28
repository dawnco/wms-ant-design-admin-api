<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

return [
    // 'url 可用正则' => ['c' => [Control, method], 'm' => '方法'];
    "/demo" => ['c' => [\App\Control\DemoControl::class, "index"], 'meta' => ["demoMeta"]],
];
