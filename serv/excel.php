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

//-- all record
$sheetId = 1;
$data = $hotspot->querydb("select mobile, DATE_FORMAT(from_unixtime(logtime),'%Y-%m-%d %H:%i:%s'), clientinfo from log order by logtime desc");
foreach($data as $k=>$v)
{
	$browserinfo = json_decode($v['clientinfo']);
	$data[$k]['clientinfo'] = $browserinfo->useragent;
}
$objWorkSheet = $objPHPExcel->createSheet($sheetId);
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
							ORDER BY date');
array_unshift($data, array('日期', '验证次数'));
$objWorkSheet->fromArray($data);
$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn('A')->setAutoSize(true);

/*
 * fill data end
 */

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('图表');
$objWorkSheet->addChart(chartData('日验证次数', count($data)));


function chartData($sheet, $linenum)
    {
        //-- create rate chart
        $dataseriesLabels = array(
            new PHPExcel_Chart_DataSeriesValues('String', $sheet.'!$B$1', NULL, 1),
        );

        $xAxisTickValues = array(
            new PHPExcel_Chart_DataSeriesValues('String', $sheet.'!$A$2:$A$'.$linenum, NULL, 4),
        );

        $dataSeriesValues = array(
            new PHPExcel_Chart_DataSeriesValues('Number', $sheet.'!$B$2:$B$'.$linenum, NULL, 4),
        );

        //  Build the dataseries
        $series = new PHPExcel_Chart_DataSeries(
            PHPExcel_Chart_DataSeries::TYPE_LINECHART_3D,      // plotType
            PHPExcel_Chart_DataSeries::GROUPING_STANDARD,    // plotGrouping
            range(0, count($dataSeriesValues)-1),           // plotOrder
            $dataseriesLabels,                              // plotLabel
            $xAxisTickValues,                               // plotCategory
            $dataSeriesValues                               // plotValues
        );

        //  Set the series in the plot area
        $plotarea = new PHPExcel_Chart_PlotArea(NULL, array($series));
        //  Set the chart legend
        $legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOPRIGHT, NULL, false);

        $title = new PHPExcel_Chart_Title('日验证次数趋势');
        $yAxisLabel = new PHPExcel_Chart_Title('验证次数');

        //  Create the chart
        $chart = new PHPExcel_Chart(
            'chart1',       // name
            $title,         // title
            $legend,        // legend
            $plotarea,      // plotArea
            true,           // plotVisibleOnly
            0,              // displayBlanksAs
            NULL,           // xAxisLabel
            $yAxisLabel     // yAxisLabel
        );

        //  Set the position where the chart should appear in the worksheet
        $chart->setTopLeftPosition('A1');
        $chart->setBottomRightPosition('P26');

        return $chart;
    }


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="HotspotReport.'.date('Y-m-d').'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setIncludeCharts(TRUE);
$objWriter->save('php://output');
exit;