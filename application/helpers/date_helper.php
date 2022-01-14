<?php
const LONG_MONTH = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];

const SHORT_MONTH = [
    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
    'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'
];

function getMonth($index = null, $type = 'long')
{
    if ($index !== null) {
        $index = (int)$index;
        if ($type === 'long') {
            return LONG_MONTH[$index - 1];
        } else if ($type === 'short') {
            return SHORT_MONTH[$index - 1];
        }
    } else {
        if ($type === 'long') {
            return LONG_MONTH;
        } else if ($type === 'short') {
            return SHORT_MONTH;
        }
    }
}

//date => YYYY-MM-DD
function getYearFromDate($date)
{
    $dt = explode("-", $date);
    return (int)$dt[0];
}

function IdFormatDate($strDate)
{
    $arrDate = explode("-", $strDate);
    $arrDate = array_reverse($arrDate);
    return implode("-", $arrDate);
}

function getCurrentDate($id_format = true)
{
    $today = date('Y-m-d');
    if (!$id_format) {
        return $today;
    }

    return IdFormatDate($today);
}