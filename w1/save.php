<?php
    $host = 'mysql.metropolia.fi';
    $dbname = ''; // your username
    $user = ''; // your username
    $pass = ''; // your database password
	

	$name = $_POST['name'];
	$email = $_POST['email'] ? $_POST['email'] : "";
	$desc = $_POST['desc'] ? $_POST['desc'] : "" ;
	$cell = $_POST['cell'] ? $_POST['cell'] : "";

	$date = $_POST['date'];
	$time = $_POST['time'];

	$sqlDate = date("Y-m-d H:i:s", strtotime($date . ' ' . $time));
	$yaha = $name . ' ' . $email . ' ' . $desc . ' ' . $cell . ' ' . $sqlDate;
   // TODO: get the data from the form by using $_POST
   // this is how you convert the date from the form to SQL formatted date:
   // date ("Y-m-d H:i:s", strtotime(dataFromDateField.' '.dataFromTimeField));
   
// this part was in dbConnect.php in last period:
try {

	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$DBH->query("SET NAMES 'UTF8';");

}catch(PDOException $e) {

	echo "Could not connect to database.";
	file_put_contents('log.txt', $e->getMessage(), FILE_APPEND);
}
    
try {
	$sqlInsert = $DBH->prepare('INSERT INTO calendar (eName, eDescription, pEmail, pPhone, eDate) VALUES (:name, :desc, :email, :phone, :date)');
	$sqlInsert->bindParam(':name', $name);	
	$sqlInsert->bindParam(':desc', $desc);
	$sqlInsert->bindParam(':email', $email);
	$sqlInsert->bindParam(':phone', $cell);
	$sqlInsert->bindParam(':date', $sqlDate);
	$sqlInsert->execute();
	// TODO: insert the data from the form to database table 'calendar'
	

} catch (PDOException $e) {
	echo 'Something went wrong';	
	file_put_contents('log.txt', $yaha."\n\r", FILE_APPEND); // remember to set the permissions so that log.txt can be created
	file_put_contents('log.txt', $e->getMessage() ."\n\r", FILE_APPEND); 
}
?>