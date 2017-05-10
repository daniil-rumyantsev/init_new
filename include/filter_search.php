<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

//if (CModule::IncludeModule("iblock")) {
    //$valid = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
    //global $USER;
    //global $DB;

    //if ($_GET['valid'] == $valid) {
//        echo "<pre>";
//        var_dump($_GET);

        $result_sql = "SELECT * FROM b_filter_house WHERE active = '1'";

        if ($_GET["categories"]) {
            $cat = $_GET["categories"];
            $result_sql = $result_sql . " AND category_name = '{$cat}'";
        }

        if ($_GET["series"]) {
            $ser = $_GET["series"];
            $result_sql = $result_sql . " AND series_name = '{$ser}'";
        }

        if ($_GET["floors"]) {
            $floor = (int) $_GET["floors"];
            $result_sql = $result_sql . " AND floors = '{$floor}'";
        }

        if ($_GET["tehnologies"]) {
            $tech = $_GET["tehnologies"];
            $result_sql = $result_sql . " AND technology = '{$tech}'";
        }

        if ($_GET["max_area"] && $_GET["max_area"] != 'NaN' && $_GET["max_area"] != '0') {
            $max_area = (int) $_GET["max_area"];
            $result_sql = $result_sql . " AND total_area <= {$max_area}";
        }

        if ($_GET["min_area"] && $_GET["min_area"] != 'NaN' && $_GET["min_area"] != '0') {
            $min_area = (int) $_GET["min_area"];
            $result_sql = $result_sql . " AND total_area >= {$min_area}";
        }

        if ($_GET["max_price"] && $_GET["max_price"] != 'NaN'  && $_GET["max_price"] != '0') {
            $max_price = (int) $_GET["max_price"];
            $result_sql = $result_sql . " AND price_value <= {$max_price}";
        }

        if ($_GET["min_price"] && $_GET["min_price"] != 'NaN' && $_GET["min_price"] != '0') {
            $min_price = (int) $_GET["min_price"];
            $result_sql = $result_sql . " AND price_value >= {$min_price}";
        }

        if ($_GET["min_width"] && $_GET["min_width"] != 'NaN' && $_GET["min_width"] != '0') {
            $min_width = (int) $_GET["min_width"];
            $result_sql = $result_sql . " AND width >= {$min_width}";
        }

        if ($_GET["min_length"] && $_GET["min_length"] != 'NaN' && $_GET["min_length"] != '0') {
            $min_length = (int) $_GET["min_length"];
            $result_sql = $result_sql . " AND length >= {$min_length}";
        }

        //echo $result_sql;
        
        $resultSQL = $DB->Query($result_sql);
        
        $result = [];
        while ($row = $resultSQL->Fetch()) {
            //var_dump($row);
            //die();
            $result[] = $row;
        }
        
       //var_dump($result);
        
        
        //header('Content-Type: application/json');
        
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        //echo $result_sql;
   // }



//
//    $result_sql = $DB->Query("SELECT * FROM b_filter_house WHERE active = '1'");
//
//    $result = [];
//    while ($row = $result_sql->Fetch()) {
//       //var_dump($row);
//       //die();
//       $result[] = $row;
//    }
//    
//    header('Content-Type: application/json');
//    print json_encode($result, JSON_UNESCAPED_UNICODE);
//}