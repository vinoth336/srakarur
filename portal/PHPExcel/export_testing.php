<?php

require_once ('export_files.php');

//name of Headers - array('ID', 'Name', 'Phone', 'Amount1','amount2', 'age');
$php_excel_data['Header']= array('ID', 'Name', 'Phone', 'Amount1','Amount2', 'Age', 'Birthday');

//data - array(array('1', 'doss', '9994596906', '10','20', '27','07-12-1989'),array('2', 'Jai', '9994512334', '40','50', '26', '01-26-1990'),array('3', 'NILA', '9994596666', '60','70','03', '02-21-2015',));
$php_excel_data['File_Data']=array(array('1', 'doss', '9994596906', '10','20', '27','07-12-1989'),array('2', 'Jai', '9994512334', '40','50', '26', '01-26-1990'),array('3', 'NILA', '9994596666', '60','70','03', '02-21-2015',));

//file name -test_file_name
$php_excel_data['File_Name']='test_file_name';

//output file format -xls,xlsx,csv
$php_excel_data['Export_Type']='xls'; 

//for auto filter on off -1 to ON 0 to OFF
$php_excel_data['Xls_Autofilter']=1; 

// set subtotal from head field val -array('Amount1', 'Amount2');
$php_excel_data['Subtotal']=array('Amount1', 'Amount2');

//'[$$-409]#,##0.00;[RED]-[$$-409]#,##0.00' =>$11.20 input any cell format(that code get from excel cell format)-array('D' => "[$$-409]#,##0.00;[RED]-[$$-409]#,##0.00",'E' => "[$$-409]#,##0.00;[RED]-[$$-409]#,##0.00", 'G' => "HH:MM:SS AM/PM");
$php_excel_data['Cell_Format']=array('Amount1' => "[$$-409]#,##0.00;[RED]-[$$-409]#,##0.00",'Amount2' => "[$$-409]#,##0.00;[RED]-[$$-409]#,##0.00", 'Birthday' => "HH:MM:SS AM/PM");

//rgb color code $header_color='b9f7ef'; https://www.google.co.in/?gfe_rd=cr&ei=RpDoWOqrFsSL8QfD6LagAw&gws_rd=ssl#q=rgb+color+picker
$php_excel_data['Header_Color']='b9f7ef';

// set cell color code rgb array('A'=>'edf7b9','C'=>'f2b9f7','E'=>'f7dbb9');
$php_excel_data['Cell_Colorset']=array('Name'=>'edf7b9','Age'=>'f2b9f7','Birthday'=>'f7dbb9');
        
Export_File::Export($php_excel_data);
