<?php

$appDir=__DIR__.'/../../app/';
require $appDir.'lib/aa/web.php';

AWeb::run($appDir.'admin' , $appDir.'admin/conf/dev.php');