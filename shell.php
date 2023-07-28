<?php
/**
 * @author Dawnc
 * @date   2023-07-28
 */

require __DIR__ . "/vendor/autoload.php";

use Wms\Fw\Conf;
use Wms\Fw\Fw;

Conf::set('app', include __DIR__ . "/config/app.conf.php");
Conf::set('route', include __DIR__ . "/config/route.conf.php");
$fw = new Fw();
$fw->shell($argv);

