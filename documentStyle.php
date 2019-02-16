<?php

// 單位換算
const twip = 566.929133858;  // 1 cm = 566.929133858 twip 用在表格寬高
const pt = 28.346456693;  // 1 cm = 28.346456693 pt 用在圖片寬高

// 文件參數
const pageMarginTop = 2;
const pageMarginRight = 2;
const pageMarginBottom = 2;
const pageMarginLeft = 2;

const tableColWidth = 8.5;
const tableRowHeight = 6;

// 樣式
const f_PMLU = array('name' => '新細明體');
const f_SK = array('name' => '標楷體');
const f_TNR = array('name' => 'Times New Roman');

const U_textCenter = array('align' => 'center'); // 文字水平置中，要設在「文字 Text」上，是 Paragraph 屬性
const U_textVCenter = array('valign' => 'center');

// 不會更動的文字
const jobDescription = '制水閥定位';


// 設定樣式的函式
function setFontSize($num)
{
	return array('size' => $num);
}

function setLineHeight($num)
{
	return array('lineHeight' => $num);
}

function setPageMargin($topNum, $rightNum, $bottomNum, $leftNum)
{
	return array('marginLeft' => $leftNum*twip, 'marginRight' => $rightNum*twip,'marginTop' => $topNum*twip, 'marginBottom' => $bottomNum*twip);
}

function printText($space, $address, $graph_valve_number, $workDate, $distance, $index)
{
	$word = '作業地點：'.$address.' ('.$graph_valve_number.')';
	$space->addText($word,array_merge(setFontSize(9),setLineHeight(1.2)));
	$word = '施作日期：'.$workDate;
	$space->addText($word,array_merge(setFontSize(9),setLineHeight(1.2)));

	if($index % 4 == 0)
		$referenceIndex = 1;
	else
		$referenceIndex = $index % 4;

	$word = '作業內容：'.jobDescription.' (參考點'.$referenceIndex.')';
	$space->addText($word,array_merge(setFontSize(9),setLineHeight(1.2)));

	if($distance == null)
		$word = '距離：';
	else
		$word = '距離：'.$distance.'M';
	$space->addText($word,array_merge(setFontSize(9),setLineHeight(1.2)));
}

function scaleImageFile($file, $max_width, $max_height) {

	$max_width = $max_width * pt;
	$max_height = $max_height * pt;

    list($width, $height) = getimagesize($file);

	if($width <= $max_width && $height <= $max_height) //如果圖片可以完全塞下
	{
		$imageStyle = array('width' => $width, 'height' => $height, 'align' => 'center');
	}
	else //圖片的width或height超過
	{
		$widthRatio = $max_width / $width; //算width的縮放比例
		$heightRatio = $max_height / $height; //算height的縮放比例

		if($widthRatio < $heightRatio) //如果width的縮放比例較小，則width卡住，height縮小，上下留白
		{
			$imageStyle = array('width' => $max_width, 'height' => $height*$widthRatio, 'align' => 'center');
		} 	
		else if($widthRatio > $heightRatio) //如果height的縮放比例較小，則height卡住，width縮小，左右留白
		{
			$imageStyle = array('width' => $width*$heightRatio, 'height' => $max_height, 'align' => 'center');
		} 		
		else //完美長寬比，直接指定長寬
		{
			$imageStyle = array('width' => $max_width, 'height' => $max_height, 'align' => 'center');
		} 			
	}
    return $imageStyle;
}