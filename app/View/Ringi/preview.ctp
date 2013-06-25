<?php
$excelfile = "upload.xls";
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ringidata';
$someTable = 'attributes';


$path = $_SERVER['DOCUMENT_ROOT']."/uploads/";
$d = dir($path); 

$latest_ctime = 0;
$latest_filename = '';    

while (false !== ($entry = $d->read())) {
  $filepath = "{$path}/{$entry}";
  // could do also other checks than just checking whether the entry is a file
  if (is_file($filepath) && filectime($filepath) > $latest_ctime) {
    $latest_ctime = filectime($filepath);
    $latest_filename = $entry;
  }
}

echo $latest_filename;

if (preg_match("/.+xls/",$latest_filename)) {

$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/uploads/".$latest_filename);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');

$objWriter->setUseInlineCSS(true);

$objWriter->save('php://output');

}
?>