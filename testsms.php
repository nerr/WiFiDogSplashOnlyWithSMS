<?php
include 'config.php';
require 'class/hotspotsms.php';

$hotspot = new hotspotsms($config);

$result = $hotspot->sendSms_fetion('13524289996', "测试");

echo $result;
