<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

require dirname(__DIR__) . "/vendor/autoload.php";

use Wms\Fw\Conf;
use Wms\Fw\Fw;

define("APP_PATH", dirname(__DIR__) . "/app");

Conf::set('app', include dirname(__DIR__) . "/config/app.conf.php");
Conf::set('route', include dirname(__DIR__) . "/config/route.conf.php");
$fw = new Fw();
$fw->run();

