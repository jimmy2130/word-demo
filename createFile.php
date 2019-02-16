<?php

include 'documentStyle.php';
include 'getData.php';

$textIndex = 0;
$picIndex = 0;

/* [START PHPWORD] */
require "vendor/autoload.php";
$pw = new \PhpOffice\PhpWord\PhpWord();

// 設定預設字型
$pw->setDefaultFontName('新細明體');
$pw->setDefaultFontSize(12);

$tableTextStyle = array_merge(setFontSize(9),setLineHeight(1.2));

if($print_file == false)
{
	$section = $pw->addSection();
	$section->addText($error_message,array_merge(f_TNR,setFontSize(12)));
	$section->addText($error_message2);
}
else if($print_file == true)
{
	if(count($id) == 0)
	{
		header("Location: index.php");
		exit();
	}
	for($index = 0; $index < count($id); $index++)
	{
		// 新增一頁，版面配置，設定邊界
		$section = $pw->addSection(setPageMargin(pageMarginTop,pageMarginRight,pageMarginBottom,pageMarginLeft));

		// 標題, 副標題
		$title = '臺北自來水事業處';
		$section->addText($title,array_merge(f_SK,setFontSize(14)),U_textCenter);
		$section->addText('',setLineHeight(0.3));

		$subtitle = ' 檔案名稱：'.'                                                 '.'工程編號：'.'                              '.'承商：';
		$section->addText($subtitle,setFontSize(11));

		// 表格
		$pw->addTableStyle('waterTable', array('borderSize' => 6, 'align' => 'center', 'cellMarginTop' => 0.1*twip, 'cellMarginBottom' => 0.1*twip, 'cellMarginLeft' => 0.1*twip, 'cellMarginRight' => 0.1*twip));
		$table = $section->addTable('waterTable');

		for($i = 0; $i <= 3; $i++)
		{
			if($i % 2 == 0)
			{
				$row = $table->addRow();
				for($j = 0; $j <= 1; $j++)
				{
					$space = $row->addCell(tableColWidth*twip);
					printText($space, $address[$index], $graph_valve_number[$index], $work_date[$index], $distance[$textIndex], $textIndex);
					$textIndex++;
				}
			}
			else
			{
				$row = $table->addRow(tableRowHeight*twip);
				for($j = 0; $j <= 1; $j++)
				{
					if($photo[$picIndex] != null)
					{
						$imageStyle = scaleImageFile($photo[$picIndex], tableColWidth-0.1, tableRowHeight-0.1);
						$row->addCell(tableColWidth*twip, U_textVCenter)->addImage($photo[$picIndex],$imageStyle);
					}
					else
					{
						$row->addCell(tableColWidth*twip);						
					}
					$picIndex++;
				}		
			}
		}
		// 尾字
		$footnote = '            承商編製：'.'                                                                                           '.'監工：';
		$section->addText($footnote,setFontSize(11));
	}	
}


// 產生word檔
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment;filename="convert.docx"');
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, 'Word2007');
$objWriter->save('php://output');