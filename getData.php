<?php

set_time_limit(0);

// 這個是正式拿資料的檔案

if(isset($_POST['genDocSubmit'])){
  $startDate = $_POST['startDate'];
  $endDate = $_POST['endDate']; 
  $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
}

if(strtotime($startDate) >= strtotime($endDate))
{
  header("Location: createFile.php");
  exit();
}

// 要存的資料
$id = array();
$address = array();
$graph_valve_number = array();
$work_date = array();
$photo = array();
$distance = array();

// 開始拿資料
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.djtechtw.com/taipeiwater/api/valve_card/data",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => array('date_range[0]' => $startDate,'date_range[1]' => $endDate),

  // 取得全部閥卡資料  

  // 查詢其中一個閥栓
  // CURLOPT_POSTFIELDS => array('where[0][graph_number]' => '3762C','where[0][valve_number]' => '7'),

  // 取得多個閥卡資料 
  // CURLOPT_POSTFIELDS => array('where[0][graph_number]' => '4056C','where[0][valve_number]' => '109','where[1][graph_number]' => '3762C','where[1][valve_number]' => '7'),

  // 兩個值在資料庫中個別都有，但無相符閥栓結果
  // CURLOPT_POSTFIELDS => array('where[0][graph_number]' => '3762C','where[0][valve_number]' => '22'),

  // 個別查詢條件在資料庫中沒有值
  // CURLOPT_POSTFIELDS => array('where[0][graph_number]' => 'dasdasdas','where[0][valve_number]' => 'dasda'),

  CURLOPT_HTTPHEADER => array(
    "Accept: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err)
{
  echo "cURL Error #:" . $err;
}
else
{
  $json_data = json_decode($response,true);
  $print_file = true;
  for($i = 0; $i < count($json_data); $i++)
  {
    array_push($id, $json_data[$i]['id']);
    array_push($address, $json_data[$i]['address']);
    $temp = $json_data[$i]['graph_number'] . $json_data[$i]['valve_number'];
    array_push($graph_valve_number, $temp);

    $temp = $json_data[$i]['updated_at'];
    $year = (int)substr($temp,-19,4) - 1911;
    $month = substr($temp,-14,2);
    $day = substr($temp,-11,2);
    $combine = $year . '.' . $month . '.' . $day;
    array_push($work_date, $combine);

    if($json_data[$i]['images'] == null)
    {
      for($j = 0; $j <= 3; $j++)
      {
        array_push($photo, null);
        array_push($distance, null);
      }
    }
    else
    {
      array_push($photo, $json_data[$i]['images']['horizon']);
      array_push($photo, $json_data[$i]['images']['vertical']);
      array_push($photo, $json_data[$i]['images']['distance1']);
      array_push($photo, $json_data[$i]['images']['distance2']);

      $temp = number_format($json_data[$i]['images']['horizon_distance'], 1);
      array_push($distance, $temp);
      $temp = number_format($json_data[$i]['images']['vertical_distance'], 1);
      array_push($distance, $temp);
      $temp = number_format($json_data[$i]['images']['distance1_distance'], 1);
      array_push($distance, $temp);
      $temp = number_format($json_data[$i]['images']['distance2_distance'], 1);
      array_push($distance, $temp);
    }
  }
}

