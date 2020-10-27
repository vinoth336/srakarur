<?php
session_start();

include_once("PHPExcel/PHPExcel.php");
include('Engine.php');
include('Util.php');

frame_request();
if(!isset($_SESSION['sra_username'])){
        ob_end_clean();
        if(isset($_REQUEST['mode'])){
                echo json_encode(array('code' => 1501),true);
                exit;
        }else{
                ob_end_clean();
                header("Location: login.php");
                exit;
        }
}
frame_request();
GetXLS();

function GetXLS(){
		global $request;
		include_once("module/PurchaseOrder.php");
		$content = GetPurchaseOrderForExport();
		$workbook=new PHPExcel();
		$worksheet=$workbook->setActiveSheetIndex(0);
		$sheet = $workbook->getActiveSheet();
		$worksheet->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$header_styles = array(
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'b4dfe5')),
				'font' => array( 'bold' => true )
				);
		$content_styles = array(
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color'=>array('rgb'=>'B8B8B8')),
				);
	
		$footer_styles = array(
				'font' => array( 'bold' => true )
				);

		$negativevalue_styles = array(
				'font' => array('color'=>array('rgb'=>'ff0808')),
				);
		$count=0;
		$rowcount=1;	
		$cell = 'A';
	

		foreach($content['header'] as $key=>$values)
		{	
			if($count)	
			$cell++;
			$worksheet->setCellValueExplicitByColumnAndRow($count,$rowcount,$values, true);
			$worksheet->getStyleByColumnAndRow($count, $rowcount)->applyFromArray($header_styles);

			$count = $count + 1;
		}
		$worksheet->setAutoFilter('A1:'.$cell.'1');
		$worksheet->getRowDimension($rowcount)->setRowHeight(15);
        	$rowcount++;

		$sheet->calculateColumnWidths();	
		foreach(range('A', $cell) as $columnID){
			$sheet->getColumnDimension($columnID)->setAutoSize(false);
			$sheet->getColumnDimension($columnID)->setWidth(14);
		}



		$i=0;
		foreach($content['data'] as $key=>$values){
			$count=0;
			$cell = 'A';

			#FORM ACTION VALUES
			$values['cost_per_sub'] 	= $_POST['cost_per_sub'][$i];
			$values['cost_per_deal'] 	= $_POST['cost_per_deal'][$i];
			$values['amount_paid'] 		= $_POST['amount_paid'][$i];
			$values['gross'] 		= $_POST['gross'][$i];
			$values['net'] 			= $_POST['net'][$i];

	
			foreach($content['header'] as $clm => $val){
				if($content['column_format'][$clm] == 'currency'){
					$values[$clm] = preg_replace("/,/",'',$values[$clm]);
					$worksheet->setCellValue($cell.$rowcount,$values[$clm]);
					$worksheet->getStyle($cell.$rowcount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
					$cell++;
				}elseif($content['column_format'][$clm] == 'n'){
					$values[$clm] = preg_replace('/[^0-9.]/','',$values[$clm]);	
					$worksheet->setCellValue($cell.$rowcount,$values[$clm]);
					$worksheet->getStyle($cell.$rowcount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
					$cell++;

				}elseif($content['column_format'][$clm] == 'decimal'){
					$worksheet->setCellValue($cell.$rowcount,$values[$clm]);
					if($clm == 'factor_rate')
					$worksheet->getStyle($cell.$rowcount)->getNumberFormat()->setFormatCode('0.000');
					else
					$worksheet->getStyle($cell.$rowcount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
					$cell++;

				}elseif($content['column_format'][$clm] == 'date'){
					$dateString = strftime("%Y-%m-%d", strtotime($values[$clm]));
					$datetemp = PHPExcel_Shared_Date::stringToExcel($dateString);
					$worksheet->setCellValue($cell.$rowcount,$datetemp);
					$worksheet->getStyle($cell.$rowcount)->getNumberFormat()->setFormatCode('dd/mm/yyyy');
					$cell++;

				}else{
					$worksheet->setCellValue($cell.$rowcount,$values[$clm]);
					$cell++;

				}
				$count++;	
			}

			$worksheet->getRowDimension($rowcount)->setRowHeight(15);
			$rowcount++;
			$i++;
		}

		$count = 0;
		$rw = $rowcount - 1;
		$filename = 'PurchaseOrder_'.$request['date'];
		ob_end_clean();
		if(true){	
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$filename.'.xls');
			$workbookWriter = PHPExcel_IOFactory::createWriter($workbook, 'Excel2007');
		}else{
			header('Content-Type: application/csv');
			header('Content-Disposition: attachment; filename='.$filename.'.csv');
			$workbookWriter = PHPExcel_IOFactory::createWriter($workbook, 'CSV');

		}
		$workbookWriter->save('php://output');


}


?>
