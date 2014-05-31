<?php
//	PHP PDO Tutorials
// =============================================
// http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
// http://liljosh.com/introduction-to-php-pdo/
// http://www.youtube.com/watch?v=XQjKkNiByCk
// http://stackoverflow.com/questions/13569/mysqli-or-pdo-what-are-the-pros-and-cons
// http://stackoverflow.com/questions/10942972/php-pdo-bindparam-with-html-content
// Why it's safer:
// http://stackoverflow.com/questions/1314521/how-safe-are-pdo-prepared-statements
// =============================================

//Configuration variables stored in an associative array
//http://www.w3schools.com/php/php_arrays.asp
$config['db'] = array(
	'host' => 'localhost',
	'username' => 'root',
	'password' => '',
	'dbname' => 'Shoutbox'
);

//Connect to the MySQL database through the database handle (DBH)
//http://www.youtube.com/watch?v=XQjKkNiByCk
try {
	$DBH = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['dbname'], $config['db']['username'], $config['db']['password']);
	//See "Exceptions and PDO"
	//http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} 	catch (PDOException $e) {
	echo "Fix your connection to the database, homie <br><br>";
	echo $e->getMessage();
}

// INSERT data into the database (few ways to do so)
// =============================================
// Placeholders and bindParam


//$inputName = '<img class="img-polaroid" alt="Placeholder" src="http://miguelamigotgonzalez.com/materialFiles/rszGHS.png">';
$inputName = $_GET['name'];
$inputTrait = "Sales";

$STH = $DBH->prepare("INSERT INTO thugs (name, trait) value (:name, :trait)");
//Add PDO::PARAM_STR so we can input HTML code
//See http://stackoverflow.com/questions/10942972/php-pdo-bindparam-with-html-content
$STH->bindParam(":name", $inputName, PDO::PARAM_STR);
$STH->bindParam(":trait", $inputTrait);
$STH->execute();

// =============================================
// Associative array (shortcut but similar):
/*
$addThisData = array (
	'name' => 'Happy Bird',
	'trait' => 'Badass mofo',
);
//Insert with named parameters or placeholders
$STH = $DBH->prepare("INSERT INTO thugs (name, trait) value (:name, :trait)");
//Placeholders from the prepared statement match those of $addThisData
$STH->execute($addThisData);
*/

// =============================================
// Directly inserting an object:
class Thug { //This class is also used to fetch data
	public $name;
	public $trait;
	//Constructor to create instances
	/*
	function __construct($name, $trait) {
		$this->name = $name;
		$this->trait = $trait;
	}
	*/
}
/*
//Make an instance for every object-entry that you want
$newCandidate = new Thug('Harvey Dent', 'Kinda nice');
//Insert with named parameters or placeholders (same as previous method)
$STH = $DBH->prepare("INSERT INTO thugs (name, trait) value (:name, :trait)");
//Call the object but cast it into an array before
//PDO treats the object's properties as array keys
$STH->execute((array)$newCandidate);
*/
// =============================================


// =============================================


// FETCH content from the database
//Use FETCH_OBJ (though there are more)
$STH = $DBH->query('SELECT name, trait from thugs');
//Specify the fetch mode
/*
//Traditional MySQL method
$STH->setFetchMode(PDO::FETCH_OBJ);
//Show the results
while($row = $STH->fetch() ) {
	echo $row->name."<br>";
	echo $row->trait."<br>";
	echo "NEXT THUG <br><br>";
}
*/
//Make sure the instantiated class doesn't have a constructor
$STH->setFetchMode(PDO::FETCH_INTO, new Thug);
foreach($STH as $newThug) {
	echo $newThug->name;
	echo "<br>";
}


//Close the connection by setting the DBH to null
$DBH = null;

