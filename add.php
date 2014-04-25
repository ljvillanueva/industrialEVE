<?php

require("head.php");
require("functions.php");
require("config.php");

// Create connection
$connection=mysqli_connect($host, $user, $password, $database);

// Check connection
if (mysqli_connect_errno($connection))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
$ItemIDtobuils = $_GET['ItemID'];
query_one("INSERT INTO `eve`.`trade` (`itemID`, `itemName`, `jita`, `dodixie`) VALUES ('$ItemID', '$ItemName', '', '');", $connection);
$my_quant=query_one("SELECT myQuant from items WHERE ItemID='$ItemIDtobuils'", $connection);

$xml = simplexml_load_file("http://api.eve-central.com/api/marketstat?usesystem=$system_id&hours=24&typeid=$ItemIDtobuils&minQ=100");

echo "$item_name: " . $xml->marketstat->type->sell->min . " - x$my_quant: " . round(($xml->marketstat->type->sell->min *$my_quant)/1000, 3) . " k (<a href=\"http://eve-central.com/home/quicklook.html?typeid=$ItemIDtobuils\" target=_blank>EC</a>)";

$orig = round(($xml->marketstat->type->sell->min *$my_quant)/1000, 3);

echo "<p>Components:<ul>";
$total = 0;
$totalbuy = 0;

$result=query_several("SELECT components.ItemID AS CompID, components.ItemName AS ItemName, mycomp.myQuant AS myQuant FROM components, mycomp WHERE mycomp.ForItem = '$ItemIDtobuils' AND mycomp.ItemID = components.ItemID", $connection);
$nrows = mysqli_num_rows($result);

for ($i=0; $i<$nrows; $i++) {
	$row = mysqli_fetch_array($result);
	extract($row);
	
	$xml = simplexml_load_file("http://api.eve-central.com/api/marketstat?usesystem=$system_id&hours=24&typeid=$CompID&minQ=100");
	$my_quant = $myQuant;
	$total = $total + ($xml->marketstat->type->sell->min * $my_quant);
	$totalbuy = $totalbuy + ($xml->marketstat->type->sell->min * $my_quant);
	echo "<li>$ItemName: " . $xml->marketstat->type->sell->min . " - x$my_quant: " . ($xml->marketstat->type->sell->min * $my_quant) . " || Buy: " . $xml->marketstat->type->buy->max . " (<a href=\"http://eve-central.com/home/quicklook.html?typeid=$ItemID\" target=_blank>EC</a>)</li>";
	
	}


$total = round($total/1000, 3);

echo "</ul>
<p>Total: $total k";

$savings = round($orig - $total, 3);

$totalbuy = round($totalbuy/1000, 3);

$sellcomponents = round($orig - $totalbuy, 3);

if ($savings > $sellcomponents){
	echo "<p><strong>Margin: $savings k</strong>";

	echo "<p>Selling components margin: $sellcomponents k";

}
else{
	echo "<p>Margin: $savings k";

	echo "<p><strong>Selling components margin: $sellcomponents k</strong>";

}

echo "<p>Buy costs: $totalbuy k";


?>




		<?php
			/*
			$xml = simplexml_load_file("http://api.eve-central.com/api/quicklook?usesystem=30002659&typeid=$ItemIDtobuils");
echo "1<br>";
			foreach($xml->quicklook->buy_orders->order as $key => $value){
				echo "['" . $value->reported_time . "," . strtotime($value->reported_time)*1000 . "'," . $value->price . "]";
#			    echo $value->price . ",";
				}
echo "1<br>";
			#foreach($stats as $key=>$stat){
			 #   echo "['" . strtotime($stat->statdatetime)*1000 . "'," . $stat->statvalue . "]";
			    
			
			  #}
echo $xml;
*/
			?>
			


<!--





<script type="text/javascript">
	(function basic_time(container) {
		var
		options,
		graph,
		i, x, o;
		d1 = [
	
		<?php
			
			$xml = simplexml_load_file("http://api.eve-central.com/api/quicklook?usesystem=30002659&typeid=$ItemIDtobuils");

			foreach($xml->quicklook->sellorders->order as $key => $value){
			    echo $value->price;
				}

			foreach($stats as $key=>$stat){
			    echo "['" . strtotime($stat->statdatetime)*1000 . "'," . $stat->statvalue . "]";
			    
			
			  }

			?>
			];

		options = {
			colors: ['#585858'],
			fontSize: 11,
			lines : { show : true },
			points : { show : true },

			mouse: {
				track: true,          // => true to track the mouse, no tracking otherwise
				trackAll: false,
				position: 'se',        // => position of the value box (default south-east)
				relative: false,       // => next to the mouse cursor
				<?php
				echo "trackFormatter: function(obj){ return seconds2time(obj.x/1000) + ' : ' + obj.y + ' " . $thiscategory->unit . "'; },";

				?>

				margin: 5,             // => margin in pixels of the valuebox
				lineColor: '#FF3F19',  // => line color of points that are drawn when mouse comes near a value of a series
				trackDecimals: 1,      // => decimals for the track values
				sensibility: 2,        // => the lower this number, the more precise you have to aim to show a value
				trackY: true,          // => whether or not to track the mouse in the y axis
				radius: 3,             // => radius of the track point
				fillColor: null,       // => color to fill our select bar with only applies to bar and similar graphs (only bars for now)
				fillOpacity: 0.4       // => opacity of the fill color, set to 1 for a solid fill, 0 hides the fill 
				},
	  
			xaxis : {
			mode: 'time',

			labelsAngle : 45,
				<?php
				echo "        title: '" . $thiscategory->resolution . "'" ;
				?>

				},
			yaxis : {
				<?php
				$thismin = (float)$minmax->minstatvalue;
				$thismax = (float)$minmax->maxstatvalue;

				echo "min: " . $thismin . ",\nmax: " . $thismax . ",";
				echo "    title: '" . $thiscategory->unit . "'" ;
				?>

				},
			selection : {
				mode : 'x'
				},
			HtmlText : false,

			<?php
				echo " title : '" . html_entity_decode($thiscategory->datum) . " - " . html_entity_decode($thiscategory->source) . "'" ;
				#	echo " title : '" . $thiscategory->datum . " - " . $thiscategory->source . " (" . $thiscategory->better . ")'" ;
			?>

			};

		// Draw graph with default options, overwriting with passed options
		function drawGraph (opts) {

		// Clone the options, so the 'options' variable always keeps intact.
		o = Flotr._.extend(Flotr._.clone(options), opts || {});

		// Return a new graph.
		return Flotr.draw(
			container,
			[ d1 ],
			o
			);
			}

		graph = drawGraph();      

		Flotr.EventAdapter.observe(container, 'flotr:select', function(area){
			// Draw selected area
			graph = drawGraph({
				xaxis : { min : area.x1, max : area.x2, mode : 'time', labelsAngle : 45 },
				yaxis : { min : area.y1, max : area.y2 }
				});
			});

		// When graph is clicked, draw the graph with default area.
		Flotr.EventAdapter.observe(container, 'flotr:click', function () { graph = drawGraph(); });
		})(document.getElementById("container"));
	</script>
	-->
	
