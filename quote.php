<?php
header("Access-Control-Allow-Origin: *");

	if(isset($_GET["userInput"])) {
        //construct URL for quote
        $quoteURL = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$_GET["userInput"];
        $jsonStr = file_get_contents($quoteURL);
        echo $jsonStr;
	}
	
?>