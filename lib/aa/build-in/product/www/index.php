<?php

$appDir=__DIR__.'/../../app/';
require $appDir.'lib/aa/web.php';

AA::run($appDir.'admin' , $appDir.'admin/conf/dev.php');