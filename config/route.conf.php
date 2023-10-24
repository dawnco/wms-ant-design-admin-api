<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

return [
    // 'url 可用正则' => ['c' => [Control, method], 'm' => '方法'];
    '/login' => ['c' => [LoginControl::class, 'login']],
    '/logout' => ['c' => [LoginControl::class, 'logout']],
];
