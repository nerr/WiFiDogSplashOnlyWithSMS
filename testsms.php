<?php
include 'config.php';
require 'class/hotspotsms.php';

$hotspot = new hotspotsms($config);

$hotspot->sendSms_fetion('13524289996', "测试");
