<?php
header("Access-Control-Allow-Origin: *");

	if(isset($_GET["symbol"])) {
        //construct URL for quote
        $chartDataURL = "http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters="."{\"Normalized\":false,\"NumberOfDays\":1095,\"DataPeriod\":\"Day\",\"Elements\":[{\"Symbol\":\"".$_GET["symbol"]."\",\"Type\":\"price\",\"Params\":[\"ohlc\"]}]}";
        $jsonStr = file_get_contents($chartDataURL);
        echo $jsonStr;
	}

?>
