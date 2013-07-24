<?php

include 'config.php';
require 'class/hotspotsms.php';
$hotspot = new hotspotsms($config);

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Shanghai');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once 'class/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Nerrsoft.com")
							 ->setLastModifiedBy("Nerrsoft.com")
							 ->setTitle("SMS Hotspot Auth Report")
							 ->setSubject("For MXCQ")
							 ->setDescription("SMS Hotspot Auth Excel Report")
							 ->setKeywords("sms mobile report")
							 ->setCategory("report");


/*
 * fill data begin
 */

$sheetId = 0;
//-- all record
$data = $hotspot->querydb("select mobile, DATE_FORMAT(from_unixtime(logtime),'%Y-%m-%d %H:%i:%s'), clientinfo from log order by logtime desc");
foreach($data as $k=>$v)
{
	$browserinfo = json_decode($v['clientinfo']);
	$data[$k]['clientinfo'] = $browserinfo->useragent;
}

$objWorkSheet = $objPHPExcel->setActiveSheetIndex($sheetId);
array_unshift($data, array('号码', '验证时间', '获取信息'));
$objWorkSheet->fromArray($data);
$objPHPExcel->getActiveSheet()->setTitle('全部记录');

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('B')->setAutoSize(true);


//-- 
$sheetId++;
$objWorkSheet = $objPHPExcel->createSheet($sheetId);
$objPHPExcel->setActiveSheetIndex($sheetId);
$objPHPExcel->getActiveSheet()->setTitle('全部号码和排序');
$data = $hotspot->querydb("select mobile,count(id) as c from log GROUP BY mobile ORDER BY c DESC");
array_unshift($data, array('号码', '验证次数'));
$objWorkSheet->fromArray($data);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);

//-- 
$sheetId++;
$objWorkSheet = $objPHPExcel->createSheet($sheetId);
$objPHPExcel->setActiveSheetIndex($sheetId);
$objPHPExcel->getActiveSheet()->setTitle('日验证次数');
$data = $hotspot->querydb('select DATE(from_unixtime(logtime)) as date,count(id) as count
							from log
							GROUP BY DATE(from_unixtime(logtime))
							ORDER BY date desc');
array_unshift($data, array('日期', '验证次数'));
$objWorkSheet->fromArray($data);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);

/*
 * fill data end
 */

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="HotspotReport.'.date('Y-m-d').'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;