<?php

class PHPExcel_Reader_Excel2007_NonStandardNamespacesWorkaround extends PHPExcel_Reader_Excel2007
{

    public function securityScan($xml)
    {
        $xml = parent::securityScan($xml);
        return str_replace(
            [
                '<x:',
                '</x:',
                /*':x=',*/
                '<d:',
                '</d:'
                /*, ':d='*/
            ],
            [
                '<',
                '</',
                /*'=',*/
                '<',
                '</'
                /*, '='*/
            ],
            $xml
        );
    }

}
