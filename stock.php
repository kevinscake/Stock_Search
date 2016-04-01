<html>
    <header>
        <title>Stock Search</title>
        <style>
            
            body {
                font-size: 16px;
            }
            
            img {
                width: 16px;
                height: 16px;
            }
            
            #bodyContainer {
                position: relative;    
            }
            
            #formContainer {
                margin: auto;
                width: 400px;
                height: 150px;
                background-color: #f4f4f4;
            }
            
            form {
                font-family: Times New Roman;
            }
            
            #searchFormH1 {
                text-align: center;
                font-style: italic;
                font-size: 30px;
                margin-top: 0px;
                padding-top: 5px;
                margin-bottom: 0px
                
            }
            
            #searchFormHr {
                color: #c9c9c9;
                height: 1px;
            }
            
            label {
                padding-left: 5px;
            }
            
            #buttons {
                margin-left: 190px;
                width-top: 5px;
                margin-bottom: 5px;
            }
            
            input {
                margin: auto;
            }
            
            table {
                margin: auto;
                position: relative;
                font-size: 14px;
                font-family: Helvetica;
                border: 2px solid #cccccc;
                border-collapse: collapse;
            }
            
            th {
                background-color: #f4f4f4;
                text-align: left;
            }
            
            td, th {
                border: 1px solid #cccccc;
                height: 30px;
            }
            
            td {
                background-color: #fafafa;
            }
            
            #XMLtable {
                text-align: left;
            }
            
            #JSONtable td{
                text-align: center;
            }
            
            
            
            
        </style>
    </header>
    
    <body>
        <!--Javascript for Clear button-->
        <script>
            function clearClick(thisform) {
                //code here
                document.getElementById("content").innerHTML = "";
                thisform.NameOrSymbol.value = "";
            }
        </script>
        
        <div id="bodyContainer">
            
        <div id="formContainer">
            <!--build a search form-->
            <form  name="searchForm" action="" method="GET">
                <h1 id="searchFormH1">Stock Search</h1>
                <hr id="searchFormHr"></hr>
                <lable>Company Name or Symol: <lable/><input type="text" name="NameOrSymbol" value= '<?php echo isset($_GET["NameOrSymbol"])? $_GET["NameOrSymbol"] : "" ?>' required/><br>
                <div id="buttons">
                    <input type="submit" name = "Submit" value="Search">
                    <input type="button" value="Clear" onclick="clearClick(this.form)"><br>
                </div>

                <a href="http://www.markit.com/product/markit-on-demand">Powered by Markit on Demand</a>
            </form>
        </div>
        



            <div id="content">
                <!--php for displaying data-->
            <?php

            //LookUp
            if (isset($_GET["Submit"])) {
                //constuct URL for LookUp
                $lookupURL = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=".$_GET["NameOrSymbol"];
                //building simpleXML Obj
                $xml=simplexml_load_file($lookupURL);

                if (! $xml) {
                    echo "<div>No Records has been found<div>";
                }
                else {
                    //create display table
                    echo "<table id=\"XMLtable\">\n";
                    //create table header row
                    echo "<tr>\n";

                    $header = ["Name", "Symbol", "Exchange", "Details"];

                    foreach($header as $value) {
                        echo "<th> $value </th>\n";
                    }
                    echo "</tr>\n";
                    //create data row

                    //loop for each company
                    foreach($xml as $aCompany) {
                        echo "<tr>\n";
                        echo "<td>$aCompany->Name</td>\n";
                        echo "<td>$aCompany->Symbol</td>\n";
                        echo "<td>$aCompany->Exchange</td>\n";
                        echo "<td><a href = \"stock.php?symbol=$aCompany->Symbol&NameOrSymbol=$aCompany->Symbol\">More Info</a></td>\n";
                        echo "</tr>\n";
                    }
                    echo "</table>\n";
                }
            }

            //Quote
            if(isset($_GET["symbol"])) {
                //construct URL for quote
                $quoteURL = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=".$_GET["symbol"];
                $jsonStr = file_get_contents($quoteURL);
                $jsonObj = json_decode($jsonStr, true);



                if($jsonObj["Status"] == "SUCCESS") {
                    //create display table
                    echo "<table id=\"JSONtable\">\n";
                    //build each row
                    foreach($jsonObj as $key=>$value) {

                        echo "<tr>\n";
                        $key2 = "";
                        $value2 = "";

                        if($key != "Status" && $key!= "MSDate") {
                            //output format adjustment

                            if($key == "LastPrice") {
                                $key2 = "Last Price";
                                $value2 = $value;
                            }
                            else if($key == "Change") {
                                $key2 = "Change";
                                $value2 = round($value,2);
                                $value2 = $value2.arrowImage($value2);
                            }
                            else if($key == "ChangePercent") {
                                $key2 = "Change Percent";
                                $value2 = round($value,2);
                                $value2 = $value2."%".arrowImage($value2);
                            }
                            else if($key == "Timestamp") {
                                date_default_timezone_set("America/New_York");
                                $key2 = "Timestamp";
                                $value2 = date("Y-m-d h:i A", strtotime($value))." EST"; 
                            }
                            else if($key == "MarketCap") {
                                $key2 = "Market Cap";
                                $value2 /= 1000000000;
                                $value2 = $value2."B";
                            }
                            else if($key == "Volume") {
                                $key2 = "Volume";
                                $value2 = number_format($value);
                            }
                            else if($key == "ChangeYDT") {
                                $key2 = "Change YDT";
                                $value2 = "(".round($value, 2).")".arrowImage(round($value, 2));
                            }
                            else if($key == "ChangePercentYTD") {
                                $key2 = "Change Percent YTD";
                                $value2 = "(".round($value, 2).")".arrowImage(round($value, 2));
                            }
                            else{
                                $key2 = $key;
                                $value2 = $value;
                            }

                            echo "<th>$key2</th>\n";
                            echo "<td>$value2</td>\n";    
                            echo "<tr>\n";
                        }                    
                    }
                    echo "</table>\n";
                }
                else {
                    echo "<div>There is no stock infomation available</div>";
                }
            }


            function arrowImage($value) {
                if($value>0) return "<img alt= \"Green_Arrow_Up\" src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png\">";
                else if($value<0) return "<img alt= \"Red_Arrow_Down\" src=\"http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png\">";
                else return "";
            }
            ?>
            </div>
               
        </div>
        
        
        
        
    </body>
    
</html>