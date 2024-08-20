<?php
// โหลด mPDF อัตโนมัติ
require_once __DIR__ . '/vendor/autoload.php';

// สรา้งคลาส
$mpdf = new \Mpdf\Mpdf();

$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/ttfonts',
    ]),
    'fontdata' => $fontData + [
        'th-sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'th-sarabun',
    'default_font_size' => 16,
]);

// เขียนโค้ด HTML
$mpdf->WriteHTML('<h1>สวัสดีรัฐบาลไทย</h1>');

// ส่งออกไฟล์ PDF ไปยังเบราว์เซอร์โดยตรง
$mpdf->Output();