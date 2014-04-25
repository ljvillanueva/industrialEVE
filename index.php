<html>
<head>

<style>
@font-face
{
font-family: eve;
src: url('eve.ttf');
}
H1
{
font-family: eve;
}
</style>

</head>

<body>

<h1>Industrial EVE</h1>

<ul>
<?php

require("functions.php");
require("config.php");

// Create connection
$connection=mysqli_connect($host, $user, $password, $database);

// Check connection
if (mysqli_connect_errno($connection))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result=query_several("SELECT ItemID, ItemName, myQuant FROM items", $connection);
$nrows = mysqli_num_rows($result);

for ($i=0; $i<$nrows; $i++) {
	$row = mysqli_fetch_array($result);
	extract($row);
	
	$xml = simplexml_load_file("http://api.eve-central.com/api/marketstat?usesystem=30002659&hours=24&typeid=$ItemID&minQ=$myQuant");
	echo "<li><a href=\"data.php?ItemID=$ItemID\">$ItemName</a>: " . $xml->marketstat->type->buy->max . " (Buy vol: " . round($xml->marketstat->type->buy->volume/1000, 3) . " k)</li>";
	
	}

?>
</ul>

<?php

#require_once "libs/Pheal/Pheal.php";

#spl_autoload_register("Pheal::classload");
#$pheal = new Pheal($EVEkeyID, $EVEvCode);
#$pheal = new Pheal("keyID", "vCode"[, "scope for request"]);

#$pheal->scope = "eve";
#$result = $pheal->CharacterID(array("names" => "Peter Powers"));
#echo $result->characters[0]->characterID;



?>
<p><a href="trade.php">Inter-station trade</a>

</body>
</html>
