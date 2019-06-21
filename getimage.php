<?php

/*
*	读取excel表中的图片链接获取图片下载到本地资源
* 	获取网站图片文件
*/

	header("Content-type: text/html; charset=utf-8");  

	// 先引入
	include_once 'PHPExcel/PHPExcel.class.php';		//导入
	include_once 'PHPExcel/PHPExcel/IOFactory.php';	//导出
	include_once 'PHPExcel/PHPExcel/Reader/Excel5.php';
	include_once 'PHPExcel/PHPExcel/Writer/Excel5.php';
	date_default_timezone_set("PRC");

	// 获取excel数据 start
	function excelGet($inputFileName){

		date_default_timezone_set("PRC");

		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
			die("加载文件发生错误：".pathinfo($inputFileName,PATHINFO_BASENAME).":".$e->getMessage());
		}


		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		// 获取一行的数据
		for ($row = 1; $row <= $highestRow; $row++){
			// Read a row of data into an array
			$rowData = $sheet->rangeToArray("A" . $row . ":" . $highestColumn . $row, NULL, TRUE, FALSE);
			
			$rowData_array[$row] = $rowData;
		}

		return $rowData_array;
	}
	
	// 获取excel数据	end


	$dir = 'C:\Users\fanyi\Desktop';

	$file_name = '/findschool图片.xls';

	$ziyuan = excelGet($dir .  $file_name);

	foreach ($variable as $key => $value) {
		$variable
	}
	print_r(count($ziyuan));


