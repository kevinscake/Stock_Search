<?php
header("Access-Control-Allow-Origin: *");
	
	//lookup
	if(isset($_GET["lookupInput"])) {
		//construct URL for quote
    	$lookupURL = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input=".$_GET["lookupInput"];
    	$jsonStr = file_get_contents($lookupURL);
    	echo $jsonStr;
	}

	//quote
	if(isset($_GET["quoteInput"])) {
        //construct URL for quote
        $quoteURL = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$_GET["quoteInput"];
        $jsonStr = file_get_contents($quoteURL);
        echo $jsonStr;
	}

	//historical chart
	if(isset($_GET["chart_symbol"])) {
        //construct URL for quote
        $chartDataURL = "http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters="."{\"Normalized\":false,\"NumberOfDays\":1095,\"DataPeriod\":\"Day\",\"Elements\":[{\"Symbol\":\"".$_GET["chart_symbol"]."\",\"Type\":\"price\",\"Params\":[\"ohlc\"]}]}";
        $jsonStr = file_get_contents($chartDataURL);
        echo $jsonStr;
	}

	//bing search
	if (isset($_GET['bing_symbol'])) 
    {
        // Replace this value with your account key
        $accountKey = "eYv62HAO2JX3JmV2IQgFP24NmQP8ZExYBU7kMrZdfRU";

        $ServiceRootURL =  "https://api.datamarket.azure.com/Bing/Search/v1/";
        
        $WebSearchURL = $ServiceRootURL . "News?Query=%27". $GET["bing_symbol"] . "%27&\$format=json";
        
        $context = stream_context_create(array(
            'http' => array(
                'request_fulluri' => true,
                'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
            )
        ));
        
        $response = file_get_contents($WebSearchURL, 0, $context);
        
        echo $response;
    }


	
?>