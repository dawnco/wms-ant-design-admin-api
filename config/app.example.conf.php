<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

return [
    "env" => "dev",   // 环境 dev 开发  production 生产,
    "shell_dir" => dirname(__DIR__) . "/app/Shell",
    "base_uri" => "/api",
    "log" => [
        'level' => "info", // 日志登录  debug info  warning error
        'dir' => dirname(__DIR__) . "/log", // 日志目录
    ],
    "response" => [
        "handler" => null,
    ],
    "timezone" => null,
    "db" => [
        "default" => [
            "hostname" => "127.0.0.1",
            "username" => "root",
            "password" => "root",
            "database" => "admin_demo",
            "port" => 3306,
            "charset" => "utf8mb4",
        ],
    ],
    'redis' => [
        'default' => [
            "hostname" => "127.0.0.1",
            "port" => 6379,
            "password" => ""
        ]
    ],
    "aliyun" => [
        'log' => [
            'endpoint' => '',
            'accessId' => '',
            'secretKey' => '',
            'project' => '',
            'store' => '',
        ],
        'mq' => [
            'endpoint' => '',
            'accessId' => '',
            'secretKey' => '',
            'instanceId' => '', //实例ID
        ],

    ],
    "mongo" => [
        "default" => [
            "hostname" => "127.0.0.1",
            "database" => "test",
        ]
    ],
];
