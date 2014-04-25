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
  
echo "<table cellpadding=\"10\" border=\"1\"> 
<thead> 
<tr> 
    <th data-sort=\"string\">Item</th> 
    <th data-sort=\"float\">Jita -> Amarr (9)</th> 
    <th data-sort=\"float\">Amarr -> Jita (9)</th> 
    <th data-sort=\"float\">Jita -> Dodixie (15)</th> 
    <th data-sort=\"float\">Dodixie -> Jita (15)</th> 
    <th data-sort=\"float\">Dodixie -> Amarr (16)</th> 
    <th data-sort=\"float\">Amarr -> Dodixie (16)</th> 
    <th data-sort=\"float\"><small>BUY - Jita</small></th> 
    <th data-sort=\"float\"><small>BUY - Dodixie</small></th> 
    <th data-sort=\"float\"><small>BUY - Amarr</small></th> 
    <th data-sort=\"float\"><small>SELL - Jita</small></th> 
    <th data-sort=\"float\"><small>SELL - Dodixie</small></th> 
    <th data-sort=\"float\"><small>SELL - Amarr</small></th> 
    
</tr> 
</thead> 
<tbody> ";

$dodixie = 30002659;
$jita = 30000142;
$amarr = 30002187;
$taxrate=0.015;

$query="SELECT * FROM trade ORDER BY itemName";
$result = mysqli_query($connection, $query)
		or die (mysqli_error($connection));
$nrows = mysqli_num_rows($result);

for ($i=0; $i<$nrows; $i++) {
	$row = mysqli_fetch_array($result);
	extract($row);
	
	$xml1 = simplexml_load_file("http://api.eve-central.com/api/marketstat?usesystem=$dodixie&hours=24&typeid=$itemID&minQ=1");
	$xml2 = simplexml_load_file("http://api.eve-central.com/api/marketstat?usesystem=$jita&hours=24&typeid=$itemID&minQ=1");
	$xml3 = simplexml_load_file("http://api.eve-central.com/api/marketstat?usesystem=$amarr&hours=24&typeid=$itemID&minQ=1");

	$jita_sell_new = floatval($xml2->marketstat->type->sell->min);
	$jita_buy_new = floatval($xml2->marketstat->type->buy->max);
	$dodixie_sell_new = floatval($xml1->marketstat->type->sell->min);
	$dodixie_buy_new = floatval($xml1->marketstat->type->buy->max);
	$amarr_sell_new = floatval($xml3->marketstat->type->sell->min);
	$amarr_buy_new = floatval($xml3->marketstat->type->buy->max);

#	$jita_buy = round($jita_buy, 2);
#	$jita_sell = round($jita_sell, 2);
#	$dodixie_buy = round($dodixie_buy, 2);
#	$dodixie_sell = round($dodixie_sell, 2);

	$jita_dodixie = round($dodixie_buy_new - $jita_sell_new, 2);
	$dodixie_jita = round($jita_buy_new - $dodixie_sell_new, 2);
	$jita_amarr = round($amarr_buy_new - $jita_sell_new, 2);
	$dodixie_amarr = round($amarr_buy_new - $dodixie_sell_new, 2);
	$amarr_dodixie = round($dodixie_buy_new - $amarr_sell_new, 2);
	$amarr_jita = round($jita_buy_new - $amarr_sell_new, 2);

	$no_items = round((20000/$itemsize));
	if ($no_items > 1000 && $no_items < 1000000){
		$no_items = round($no_items/1000) . "k";
		}
	else{
		$no_items = round($no_items/1000) . "M";
		}

	echo "
	<tr> 
	    <td><a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID\" target=_blank>$itemName</a><br>
	    $no_items
	    </td>
	   	";
	 	    	
	$ja_total = round((($jita_amarr * (20000/$itemsize)/1000000) * (1-$taxrate)), 2);
	
	    if ($jita_amarr>0){
	    	echo "<td><strong>$ja_total M ($jita_amarr ea)</strong><br>
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$jita\" target=_blank>j</a> 
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$amarr#buys\" target=_blank>a</a></td>\n";
	    	}
	    else{
	    	echo "<td>$jita_amarr</td>\n";
	    	}


	$aj_total = round((($amarr_jita * (20000/$itemsize)/1000000) * (1-$taxrate)), 2);
		
	    if ($amarr_jita>0){
	    	echo "<td><strong>$aj_total M ($amarr_jita ea)</strong><br>
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$amarr\" target=_blank>j</a> 
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$jita#buys\" target=_blank>a</a></td>\n";
	    	}
	    else{
	    	echo "<td>$amarr_jita</td>\n";
	    	}
    
    
	   $jd_total = round((($jita_dodixie * (20000/$itemsize)/1000000) * (1-$taxrate)), 2);
	    
	    if ($jita_dodixie>0){
	    	echo "<td><strong>$jd_total M ($jita_dodixie ea)</strong><br>
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$jita\" target=_blank>j</a> 
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$dodixie#buys\" target=_blank>a</a></td>\n";
	    	}
	    else{
	    	echo "<td>$jita_dodixie</td>\n";
	    	}
	    	
	    	
	    $dj_total = round((($dodixie_jita * (20000/$itemsize)/1000000) * (1-$taxrate)), 2);
	    	    
	    if ($dodixie_jita>0){
	    	echo "<td><strong>$dj_total M ($dodixie_jita ea)</strong><br>
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$dodixie\" target=_blank>j</a> 
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$jita#buys\" target=_blank>a</a></td>\n";
	    	}
	    else{
	    	echo "<td>$dodixie_jita</td>\n";
	    	}
	    	
	    	
	   $da_total = round((($dodixie_amarr * (20000/$itemsize)/1000000) * (1-$taxrate)), 2);
	    
	    if ($dodixie_amarr>0){
	    	echo "<td><strong>$da_total M ($dodixie_amarr ea)</strong><br>
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$dodixie\" target=_blank>j</a> 
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$amarr#buys\" target=_blank>a</a></td>\n";
	    	}
	    else{
	    	echo "<td>$dodixie_amarr</td>\n";
	    	}
    
    
	    $ad_total = round((($amarr_dodixie * (20000/$itemsize)/1000000) * (1-$taxrate)), 2);
	    
	    if ($amarr_dodixie>0){
	    	echo "<td><strong>$ad_total M ($amarr_dodixie ea)</strong><br>
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$amarr\" target=_blank>j</a> 
	    		<a href=\"http://eve-central.com/home/quicklook.html?typeid=$itemID&setminQ=1000&usesystem=$dodixie#buys\" target=_blank>a</a></td>\n";
	    	}
	    else{
	    	echo "<td>$amarr_dodixie</td>\n";
	    	}
	
	
	echo " <td><small>$jita_buy_new</small></td> 
	    <td><small>$dodixie_buy_new</small></td> 
	    <td><small>$amarr_buy_new</small></td> 
	    <td><small>$jita_sell_new</small></td> 
	    <td><small>$dodixie_sell_new</small></td>
	    <td><small>$amarr_sell_new</small></td>
	</tr> 
	";
		
	#query_one("UPDATE trade SET jita_buy = '$jita_buy_new', dodixie_buy = '$dodixie_buy_new',
			#jita_sell = '$jita_sell_new', dodixie_sell = '$dodixie_sell_new' WHERE itemID = '$itemID'", $connection);
	
	}

echo "</tbody> 
</table>";
?>
