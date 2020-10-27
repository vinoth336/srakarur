<?php
	global $request;

	function column_typeformat($type,$value){
		
				if($type == 'c'){
					 $a = number_format($value,2,'.',',');
					 if($a < 0){
						$a = $a * -1;	
						$a= '<span class="currency_negative">($'.$a.')</span>';
					  }else
						$a= '<span class="currency_positive">$'.$a.'</span>';
				}
				elseif($type == 's')
					 $a= html_entity_decode($value,ENT_QUOTES);
				elseif($type == 'p')
					 $a = number_format($value,2);
				elseif($type == 'f')
					 $a= number_format($value,3);
				elseif($type == 'd'){	
					 $a= date("m/d/Y",strtotime($value));
					if($a == '01/01/1970'){
						$a = 'N/A';	
					}
				}
				elseif($type == 'n')	
					 $a= number_format($value,2);
				else
					$a= $value;				
		
			return array('value' => $value , 'displayvalue' => $a);

	}
	function Basic_Export($content ,$filename ,$type='xls'){
		include("lib/PHPExcel/PHPExcel.php");
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
		$rowcount = 1;
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



		$column_format = $content['column_format'];

		foreach($content['recordContent'] as $key=>$values){
			$cell = 'A';
			foreach($content['header'] as $clm => $headlabel){
					
					if(isset($values[$clm]['value'])){
						$val = $values[$clm]['value'];
					}else
						$val = $values[$clm];
					$column_type = $column_format[$clm];
                                        if($column_type == 'c'){
						$worksheet->setCellValue($cell.$rowcount,$val);
                                                $sheet->getStyle($cell."".$rowcount)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                                        }elseif($column_type == 'p'){
						$val = $val/100;
						$worksheet->setCellValue($cell.$rowcount,$val);
                                                $sheet->getStyle($cell."".$rowcount)->getNumberFormat()->setFormatCode('0.00%');
                                        }elseif($column_type == 'f'){
						$worksheet->setCellValue($cell.$rowcount,$val);
                                                $sheet->getStyle($cell."".$rowcount)->getNumberFormat()->setFormatCode('0.000');;
                                        }elseif($column_type == 'd'){
						$dateString = strftime("%Y-%m-%d", strtotime($values[$clm]['value']));
						$datetemp = PHPExcel_Shared_Date::stringToExcel($dateString);
						$worksheet->setCellValue($cell.$rowcount,$datetemp);
                                                $sheet->getStyle($cell."".$rowcount)->getNumberFormat()->setFormatCode('mm/dd/yyyy');
                                        }elseif($column_type == 's'){
						$val = $values[$clm]['displayvalue'];
						$worksheet->setCellValue($cell.$rowcount,$val);

					}else{
						$worksheet->setCellValue($cell.$rowcount,$val);
					}
					$cell++;

			}
			$worksheet->getRowDimension($rowcount)->setRowHeight(15);
			$rowcount++;
		}


		ob_end_clean();
                if($type == 'xls'){
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

	function frame_request(){
		global $request;
		foreach($_REQUEST as $key => $val){
			if($val !=''){
				$request[$key] = stripslashes_recursive($val);
			}else
				$request[$key] = $val;
		}
	}

	function stripslashes_recursive($value){
                $value = is_array($value) ? array_map('stripslashes_recursive', $value) : stripslashes($value);
                return $value;
        }

	function error(){
		if(isset($_SESSION['flash_message']['error'])) {
			return $_SESSION['flash_message']['error'];
		}
		return false;
	}

	function show_error() {
		if($error = error()) {
			return '<div class="text-danger "><b>' . $error . '</b></div>';
		}
	}


?>
