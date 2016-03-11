<?php
/**
 * This view builds an Excel5 file containing the list of positions.
 * @copyright  Copyright (c) 2014-2016 Benjamin BALET
 * @license      http://opensource.org/licenses/AGPL-3.0 AGPL-3.0
 * @link            https://github.com/bbalet/jorani
 * @since         0.2.0
 */

$sheet = $this->excel->setActiveSheetIndex(0);
$sheet->setTitle(mb_strimwidth(lang('positions_export_title'), 0, 28, "..."));  //Maximum 31 characters allowed in sheet title.
$sheet->setCellValue('A1', lang('positions_export_thead_id'));
$sheet->setCellValue('B1', lang('positions_export_thead_name'));
$sheet->setCellValue('C1', lang('positions_export_thead_description'));
$sheet->getStyle('A1:C1')->getFont()->setBold(true);
$sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$positions = $this->positions_model->getPositions();
$line = 2;
foreach ($positions as $position) {
    $sheet->setCellValue('A' . $line, $position['id']);
    $sheet->setCellValue('B' . $line, $position['name']);
    $sheet->setCellValue('C' . $line, $position['description']);
    $line++;
}

//Autofit
foreach(range('A', 'C') as $colD) {
    $sheet->getColumnDimension($colD)->setAutoSize(TRUE);
}

$filename = 'positions.xls';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
$objWriter->save('php://output');