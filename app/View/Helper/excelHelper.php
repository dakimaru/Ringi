<?php  

class ExcelHelper extends AppHelper { 
   
    var $xls; 
    var $sheet; 
    var $data; 
    var $blacklist = array(); 
    
 		function outputExcel() {
 			// Create new PHPExcel object
			$phpExcel = new PHPExcel();

			// Create a first sheet, representing data
			$phpExcel->setActiveSheetIndex(0);

			// Rename sheet
			$phpExcel->getActiveSheet()->setTitle("My Sheet");

			// Create a new worksheet, after the default sheet
			$phpExcel->createSheet();


			// Add some data to the second sheet, resembling some different data types
			$phpExcel->setActiveSheetIndex(1);
			$phpExcel->getActiveSheet()->setCellValue('A1', 'More data');

			// Rename 2nd sheet
			$phpExcel->getActiveSheet()->setTitle('Second sheet');


			// Redirect output to a client’s web browser (Excel5). We'll be outputting an excel file
			header('Content-type: application/vnd.ms-excel');

			// It will be called ringi_output.xls
			header('Content-Disposition: attachment; filename="ringi_output.xls"');
			header("Cache-Control: max-age=0");

			$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");

			// Write file to the browser
			$objWriter->save('php://output');

			//return $objWriter; Activating this will spit html format.
			exit;
		}

    function excelHelper() { 
        $this->xls = new PHPExcel(); 
        $this->sheet = $this->xls->getActiveSheet(); 
        $this->sheet->getDefaultStyle()->getFont()->setName('Verdana'); 
    } 
                  
    function generate(&$data, $title = 'Report') { 
         $this->data =& $data; 
         $this->_title($title); 
         $this->_headers(); 
         $this->_rows(); 
         $this->_output($title); 
         return true; 
    } 
     
    function _title($title) { 
        $this->sheet->setCellValue('A2', $title); 
        $this->sheet->getStyle('A2')->getFont()->setSize(14); 
        $this->sheet->getRowDimension('2')->setRowHeight(23); 
    } 

    function _headers() { 
        $i=0; 
        foreach ($this->data[0] as $field => $value) { 
            if (!in_array($field,$this->blacklist)) { 
                $columnName = Inflector::humanize($field); 
                $this->sheet->setCellValueByColumnAndRow($i++, 4, $columnName); 
            } 
        } 
        $this->sheet->getStyle('A4')->getFont()->setBold(true); 
        $this->sheet->getStyle('A4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
        $this->sheet->getStyle('A4')->getFill()->getStartColor()->setRGB('969696'); 
        $this->sheet->duplicateStyle( $this->sheet->getStyle('A4'), 'B4:'.$this->sheet->getHighestColumn().'4'); 
        for ($j=1; $j<$i; $j++) { 
            $this->sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($j))->setAutoSize(true); 
        } 
    } 
         
    function _rows() { 
        $i=5; 
        foreach ($this->data as $row) { 
            $j=0; 
            foreach ($row as $field => $value) { 
                if(!in_array($field,$this->blacklist)) { 
                    $this->sheet->setCellValueByColumnAndRow($j++,$i, $value); 
                } 
            } 
            $i++; 
        } 
    } 
         
    function _output($title) { 
        header("Content-type: application/vnd.ms-excel");  
        header('Content-Disposition: attachment;filename="'.$title.'.xls"'); 
        header('Cache-Control: max-age=0'); 
        $objWriter = new PHPExcel_Writer_Excel5($this->xls); 
        $objWriter->setTempDir(TMP); 
        $objWriter->save('php://output'); 
    } 
} 
?>