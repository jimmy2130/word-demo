<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="reset.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="bg"></div>
	<div class="navigation_bar"></div>
	<div class="container">
		<form class="form" id="docxform" method="post" action="createFile.php">
			<label for="">選擇資料的起始日期</label>
			<input name="startDate" type="date" required>
			<label for="">選擇資料的結束日期</label>
			<input name="endDate" class="currentDate" type="date" value="">
			<input type="submit" name = "genDocSubmit" id="docx-button" value="下載這段期間的資料 (Word檔)">
		</form>
	</div>
	<div class="footer"></div>
	<script type="text/javascript" src="script.js"></script>
</body>
</html>
