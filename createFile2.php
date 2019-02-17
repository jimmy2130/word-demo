<?php

include 'documentStyle.php';

/* [START PHPWORD] */
require "vendor/autoload.php";
$pw = new \PhpOffice\PhpWord\PhpWord();

// 設定預設字型
$pw->setDefaultFontName('新細明體');
$pw->setDefaultFontSize(12);

// 新增一頁，版面配置，設定邊界
$section = $pw->addSection(setPageMargin(pageMarginTop,pageMarginRight,pageMarginBottom,pageMarginLeft));

// 標題, 副標題
$imageStyle = scaleImageFile('https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Ash_Tree_-_geograph.org.uk_-_590710.jpg/220px-Ash_Tree_-_geograph.org.uk_-_590710.jpg', tableColWidth-0.1, tableRowHeight-0.1);
$section->addImage('https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Ash_Tree_-_geograph.org.uk_-_590710.jpg/220px-Ash_Tree_-_geograph.org.uk_-_590710.jpg',$imageStyle);


// 產生word檔
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment;filename="convert.docx"');
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, 'Word2007');
$objWriter->save('php://output');