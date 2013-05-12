<?php
include 'config.php';
require 'class/hotspotsms.php';

$hotspot = new hotspotsms($config);

if($_GET['action'] == 'step1')
	$hotspot->step1();
elseif($_GET['action'] == 'step2')
	$hotspot->step2();
?>