<?php

$appDir=__DIR__.'/../../app/';
require $appDir.'lib/aa/web.php';

Aweb::run($appDir.'admin' , $appDir.'admin/conf/dev.php');