<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MyForm</title>
</head>
<body>

<form method="post" enctype="multipart/form-data" action="textAnalysis.php">
	<textarea name="text" placeholder="Enter text for analysis"></textarea><br>
	<input type="file" name="docs[]" multiple><br>
	<input type="submit">
	
</body>
</html>