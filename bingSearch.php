<?php
    header("Access-Control-Allow-Origin: *");

    if (isset($_GET['symbol'])) 
    {
        // Replace this value with your account key
        $accountKey = "eYv62HAO2JX3JmV2IQgFP24NmQP8ZExYBU7kMrZdfRU";

        $ServiceRootURL =  "https://api.datamarket.azure.com/Bing/Search/v1/";
        
        $WebSearchURL = $ServiceRootURL . "News?Query=%27". $GET["symbol"] . "%27&\$format=json";
        
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
