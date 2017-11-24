<?php

$appDir=__DIR__.'/../../app/';
require $appDir.'lib/aa/web.php';

aWeb::run($appDir.'admin' , $appDir.'admin/conf/dev.php');