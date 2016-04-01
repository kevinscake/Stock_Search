<?php
header("Access-Control-Allow-Origin: *");

	if(isset($_GET["userInput"])) {
		//construct URL for quote
    	$lookupURL = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input=".$_GET["userInput"];
    	$jsonStr = file_get_contents($lookupURL);
    	echo $jsonStr;
	}
	
?>