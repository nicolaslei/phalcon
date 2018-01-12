<?php

require __DIR__ . "/../app/startup.php";

$bootstrap = new \Lianni\Bootstrap\Mvc();
echo $bootstrap->run();