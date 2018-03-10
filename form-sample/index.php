<html>
<head>
	<title>PHP Form Processing Example</title>
</head>
<body>

<?php if (isset($errorString)){
    echo $errorString;
}

?>

<form action="process.php" method="POST">
	Name:*<br /><input type="text" name="Name" value="" /><br /><br />
	Email:*<br /><input type="text" name="Email" value="" /><br /><br />
	URL:*<br /><input type="text" name="URL" value="" /><br /><br />
	Company:<br /><input type="text" name="Company" value="" /><br /><br />
	<input type="submit" name="submit" value="Submit Form" />
</form>
	
</body>
</html>