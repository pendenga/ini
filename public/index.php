<?php

use Pendenga\TemplatePHP\Template;

include_once 'bootstrap.php';

header('Content-type: text/plain');
$tp = new Template();
echo $tp->getIt();
