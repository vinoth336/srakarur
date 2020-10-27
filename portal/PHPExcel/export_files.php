<?php

/* HOW TO USE THIS
        require_once ('libraries/PHPExcel/export_files.php');

        //name of Headers - array('ID', 'Name', 'Phone', 'Amount1','amount2', 'age');
        $php_excel_data['Header']= $subhead;


        //data - array(array('1', 'doss', '9994596906', '10','20', '27','07-12-1989'),array('2', 'Jai', '9994512334', '40','50', '26', '01-26-1990'),array('3', 'NILA', '9994596666', '60','70','03', '02-21-2015',));
        $php_excel_data['File_Data']=$file_data_rec;

        //file name -test_file_name IT AUTO ADD DATE AND TIME @ END OF FILE NAME
        $php_excel_data['File_Name']='test_file_name_1011';

        //output file format -xls,xlsx,csv
        if($request->get('type')=='exportxls)
                $php_excel_data['Export_Type']='xls';
        else
                $php_excel_data['Export_Type']='csv';

        //for auto filter on off -1 to ON 0 to OFF
        $php_excel_data['Xls_Autofilter']=1;

        // set subtotal from head field val -array('Amount1', 'Amount2');
        //        $php_excel_data['Subtotal']=array(' MONTHLY VOLUME ');

        //'[$$-409]#,##0.00;[RED]-[$$-409]#,##0.00' =>$11.20 input any cell format(that code get from excel cell format)-array('D' => "[$$-409]#,##0.00;[RED]-[$$-409]#,##0.00",'E' => "[$$-409]#,##0.00;[RED]-[$$-409]#,##0.00", 'G' => "HH:MM:SS AM/PM");
        $php_excel_data['Cell_Format']=array(' MONTHLY VOLUME ' => "[$$-409]#,##0.00;[RED]-[$$-409]#,##0.00");

        //rgb color code $header_color='b9f7ef'; https://www.google.co.in/?gfe_rd=cr&ei=RpDoWOqrFsSL8QfD6LagAw&gws_rd=ssl#q=rgb+color+picker
        $php_excel_data['Header_Color']='b9f7ef';

        // set cell color code rgb array('A'=>'edf7b9','C'=>'f2b9f7','E'=>'f7dbb9');
        //        $php_excel_data['Cell_Colorset']=array(' MONTHLY VOLUME '=>'edf7b9');

        //direct download(download file without return) or ajax download(return file name)
        //$php_excel_data['DirectDownload']=1;
				$php_excel_data['PathHide']=1; for hide file path Eg:downloader.php?view=off&modules=CustomReport&type=MerchantPinmap&id=123&key=xxxxxxx

        //return filename with path
					$fileurl=Export_File::Export($php_excel_data);
	//For CustomPath
	$php_excel_data['CustomPath']='../storage/xlsexport/';

 */

class Export_File
{
	public function Export($php_excel_data)
	{
		ini_set("memory_limit", -1);
		$header	   	= $php_excel_data['Header'];
		$filedata	= $php_excel_data['File_Data'];
		$filename	= $php_excel_data['File_Name'];
		$sheet_title    = $php_excel_data['Sheet_Title'];
		$exporttype 	= $php_excel_data['Export_Type'];
		$xls_autoFilter	= $php_excel_data['Xls_Autofilter'];
		$subtotal	= $php_excel_data['Subtotal'];
		$Cell_Format	= $php_excel_data['Cell_Format'];
		$header_color	= $php_excel_data['Header_Color'];
		$cell_color_set	= $php_excel_data['Cell_Colorset'];
		$datefield	= $php_excel_data['PaymentGatewayDateField'];
		$emptydatas	= $php_excel_data['PaymentGatewayemptydatas'];
		$NextApptDate	= $php_excel_data['NextApptDate'];
		$numberofrowsinexcel = $php_excel_data['PaymentGatewaynumberofrows'];
		$now   = time();

		if (!empty($header) && !empty($filedata) && !empty($filename) && !empty($exporttype)) {
			require_once('PHPExcel.php');
			if ($php_excel_data['CustomPath']) {

				$dir_path = $php_excel_data['CustomPath'];
			} else {
				$dir_path = 'storage/xlsexport/';
			}
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			if ($sheet_title)
				$objPHPExcel->getActiveSheet()->setTitle($sheet_title);
			//delete old files
			$files = glob($dir_path . '*.{csv,xls,xlsx}', GLOB_BRACE); // get all file names
			foreach ($files as $file) { // iterate files
				if (is_file($file))
					if ($now - filemtime($file) >= 60 * 60) //one day older
						unlink($file); // delete file
			}

			//array based insert
			$header_ar[] = $header;

			if ($emptydatas == 1) {
				$filedata = $header_ar;
			} else {
				array_splice($filedata, 0, 0, $header_ar); //$tmp1+$filedata;
			}
			$objPHPExcel->getActiveSheet()->fromArray($filedata);
			$objPHPExcel->getActiveSheet()->freezePane('A2'); // Freeze Header Row
			$c = count($filedata);
			// end

			$boldsubtotal = array(
				'font'  => array(
					'bold'  => true,
				)
			);

			$i = 0;
			//for header
			foreach ($header as $i => $col) {
				$header_list[$col] = export_file::getColLetter($i);
				$objPHPExcel->getActiveSheet()->getColumnDimension(export_file::getColLetter($i))->setAutoSize(true); //set size http://stackoverflow.com/questions/9965476/phpexcel-column-size-issues

			}
			if (!empty($header_color)) {
				$objPHPExcel->getActiveSheet()->getStyle('A1:' . export_file::getColLetter($i) . '1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($header_color);
				$objPHPExcel->getActiveSheet()->getStyle('A1:' . export_file::getColLetter($i) . '1')->applyFromArray($boldsubtotal);
			}
			if (!empty($subtotal)) {
				//sub total
				foreach ($subtotal as $autodata) {
					if ($header_list[$autodata]) {
						if ($autodata == 'FACTOR RATE') {
							$objPHPExcel->getActiveSheet()->SetCellValue($header_list[$autodata] . ($c + 2), '=ROUND(J' . ($c + 2) . '/H' . ($c + 2) . ',3)');
						} else {
							$objPHPExcel->getActiveSheet()->SetCellValue($header_list[$autodata] . ($c + 2), '=SUBTOTAL(9,' . $header_list[$autodata] . '2' . ':' . $header_list[$autodata] . ($c + 1) . ')');
						}

						$objPHPExcel->getActiveSheet()->getStyle($header_list[$autodata] . ($c + 2))->applyFromArray($boldsubtotal);
						if (!empty($Cell_Format[$autodata])) {
							// if(!empty($header_list[$autodata]))
							$objPHPExcel->getActiveSheet()->getStyle($header_list[$autodata] . ($c + 2))->getNumberFormat()->setFormatCode($Cell_Format[$autodata]);
						}
					}
				}
			}

			//cell format
			if (!empty($Cell_Format)) {
				foreach ($Cell_Format as $cellname => $cell_val) {
					if ($header_list[$cellname])
						$objPHPExcel->getActiveSheet()->getStyle($header_list[$cellname] . '2' . ":" . $header_list[$cellname] . ($c + 1))->getNumberFormat()->setFormatCode($cell_val);
				}
			}

			//set cell color
			if (!empty($cell_color_set)) {
				foreach ($cell_color_set as $cellname => $cell_val) {
					if ($header_list[$cellname])
						$objPHPExcel->getActiveSheet()->getStyle($header_list[$cellname] . '2' . ":" . $header_list[$cellname] . ($c + 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB($cell_val);
					$objPHPExcel->getActiveSheet()->getStyle($header_list[$cellname] . '2' . ":" . $header_list[$cellname] . ($c + 1))->applyFromArray($boldsubtotal);
				}
			}

			//set Auto Filter
			if ($xls_autoFilter == 1) {
				$objPHPExcel->getActiveSheet()->setAutoFilter(
					$objPHPExcel->getActiveSheet()->calculateWorksheetDimension()
				);
			}

			if (!is_null($datefield) && !is_null($numberofrowsinexcel)) {
				$headerplus = $numberofrowsinexcel + 1;
				$forsubtotal = $headerplus + 2;
				$objPHPExcel->getActiveSheet()->getStyle('H1:H' . "$headerplus")->getNumberFormat()->setFormatCode('MM/DD/YYYY');
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow('2', $forsubtotal, "Subtotal");
			}
			if (!is_null($NextApptDate)) {
				$objPHPExcel->getActiveSheet()->getStyle('H1:H' . $c)->getNumberFormat()->setFormatCode('MM/DD/YYYY');
			}

			//check file type
			if ($exporttype == 'xls') {
				$downloadType = "Excel2007";
				$contentType = 'Content-Type: application/vnd.ms-excel';
				$fileName = $filename . "_" . date("Y-m-d") . '_' . date("h-i-s") . ".xls";
			} else if ($exporttype == 'xlsx') {
				$downloadType = "Excel2007";
				$contentType = 'Content-Type: application/vnd.ms-excel';
				$fileName = $filename . ".xlsx";
			} else if ($exporttype == 'csv') {
				$downloadType = "CSV";
				$contentType = 'Content-Type: text/csv';
				$fileName = $filename . date("Y-m-d") . '_' . date("h-i-s") . ".csv";
			}

			$file = $fileName;

			ob_end_clean();
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $downloadType);
			$objWriter->save($dir_path . $file);

			if ($php_excel_data['PathHide']) {
				$ckey = Export_File::RandomString();
				$sql = "INSERT INTO `file_downloader` (`user_id`, `key`, `edate`, `filename`) VALUES ('0', '" . $ckey . "',DATE_ADD(NOW(), INTERVAL 2 DAY), '" . $dir_path . $file . "');";
				$result = mysql_query($sql);
				$log_id = mysql_insert_id();

				$downloader_file = "downloader.php?view=off&modules=CustomReport&type=MerchantPinmap&id=" . $log_id . "&key=" . $ckey;
			} else {
				$downloader_file = $dir_path . $file;
			}
			if (!$php_excel_data['DirectDownload']) {
				return $downloader_file;
			} else {
				header("Location:downloader.php?force=" . $downloader_file);
				exit;
			}
		} else {
			return $dir_path . $file;
		}
	}

	public function getColLetter($num)
	{
		$numeric = $num % 26;
		$letter = chr(65 + $numeric);
		$num2 = intval($num / 26);
		if ($num2 > 0) {
			return export_file::getColLetter($num2 - 1) . $letter;
		} else {
			return $letter;
		}
	}
	public function RandomString()
	{
		$key_length = 10;
		$randstr = null;
		srand((float) microtime(TRUE) * 1000000);
		$chars = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
		);
		for ($rand = 1; $rand <= $key_length; $rand++) {
			$random = rand(0, count($chars) - 1);
			$randstr .= $chars[$random];
		}
		return $randstr;
	}
}
