<?php
function setFormattedDateCellValue($sheet, $cell, $dateValue) {
    if ($dateValue !== '0000-00-00') {
        $formattedDate = date('d.m.Y', strtotime($dateValue));
    } else {
        $formattedDate = '';
    }

    $sheet->setCellValue($cell, $formattedDate);
}
?>