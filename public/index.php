<?php

require __DIR__ . "/../app/startup.php";

$bootstrap = new \Lianni\Bootstrap\Api();
echo $bootstrap->run();