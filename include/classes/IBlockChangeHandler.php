<?php

/*
 * =================================================
 * 		IBlockChangesHandlrer:
 * 	Данный класс содержит статические методы для
 * 	отслеживания изменений в инфоблоках сайта
 * =================================================
 */

 class IBlockChangeHandler
 {
 	protected static $AdditionForbidden = array();			// Список ID инфоблоков, в которых запрещено добавление элементов
 	protected static $UpdateForbidden = array();			// Список ID инфоблоков, в которых запрещено изменение элементов
 	protected static $DeletionForbidden = array(36);  		// Список ID инфоблоков, в которых запрещено удаление элементов
 	 
	// Список ID инфоблоков и обработчиков, которые вызываются после добавления элемента в виде ID => "имя обработчика в данном классе"		   
 	protected static $AfterAdditionOccured = array(
 		13 => array("UpdateFilter"),
 		21 => array("UpdateFilter"),	
	);		
	// Список ID инфоблоков и обработчиков, которые вызываются после изменения элемента в виде ID => "имя обработчика в данном классе"	
 	protected static $AfterUpdateOccured = array(
 		13 => array("UpdateFilter"),
 		21 => array("UpdateFilter", "UpdateParser"),
	);	
	// Список ID инфоблоков и обработчиков, которые вызываются после удаления элемента в виде ID => "имя обработчика в данном классе"
 	protected static $AfterDeletionOccured = array(
 		13 => array("UpdateFilter"),
 		21 => array("UpdateFilter"),	
	); 	
	
	protected static function UpdateParser($arFields)
	{
		//srand(time(0));
		//file_put_contents($_SERVER["DOCUMENT_ROOT"]."/t.txt", rand());
		CAddServicesParcer::ParceFileData($arFields);
        return $arFields;
	}
	
	// Функция обнровления основного фильтра на сайте
	// Вызывается методаим ElementUpdateHandler, ElementAdditionHandler, ElementDeletionHandler	
	
	protected static function UpdateFilter()
	{
		if (CModule::IncludeModule("iblock")) 
		{
		    global $USER;
		    global $DB;
		
		    //Собираем серии
		    
		    $SERIES = Array();
		    $arSelect = Array(
		        "ID",
		        "NAME",
		        "IBLOCK_SECTION_ID",
		        "PROPERTY_KARKAS_VARIANTS_HOUSE",
		        "PROPERTY_BRUS_VARIANTS_HOUSE",
		        "PROPERTY_KIRPICH_VARIANTS_HOUSE",
		        "PROPERTY_VARIANTS_HOUSE",
		        "PROPERTY_SERIES"
		    );
		    $arFilter = Array("IBLOCK_ID" => 13, "ACTIVE" => "Y");
		    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 500), $arSelect);
		    $cnt = 0;
		
		    //Присваеваем в массив серий все необходимые занчания для  фильтра из серий
		    
		    while ($ob = $res->GetNextElement()) 
		    {
		        $data = $ob->GetFields();               //echo "<pre>";var_dump($data);die();
		        $SERIES[$cnt]['id_category'] = (int) $data['IBLOCK_SECTION_ID'];
		
		        //Получаем и присваеваем имя категории по ID
		        $res_cat = CIBlockSection::GetByID($data['IBLOCK_SECTION_ID']);
		        if ($ar_res_cat = $res_cat->GetNext()) 
		        {
		            $SERIES[$cnt]['category_name'] = $ar_res_cat['NAME'];
		        }
		
		        $SERIES[$cnt]['id_series'] = (int) $data['ID'];
		        $SERIES[$cnt]['series_name'] = $data["PROPERTY_SERIES_VALUE"];
		
		        foreach($data["PROPERTY_KARKAS_VARIANTS_HOUSE_VALUE"]  as $v) $SERIES[$cnt]['houses'][] = $v;
				foreach($data["PROPERTY_BRUS_VARIANTS_HOUSE_VALUE"]    as $v) $SERIES[$cnt]['houses'][] = $v;
				foreach($data["PROPERTY_KIRPICH_VARIANTS_HOUSE_VALUE"] as $v) $SERIES[$cnt]['houses'][] = $v;
		        $cnt++;
		    }
		
		    //Собираем дома
		    
		    $HOUSE = Array();
		    $cnt = 0;
		    foreach ($SERIES as $k => $SERIE) 
		    {
		        foreach ($SERIE['houses'] as $v) 
		        {
		            $ELEMENT_ID = $v;
		            $arSelect = Array(
		                "ID",
		                "NAME",
		                "ACTIVE",
		                "PROPERTY_SQUARE_ALL_HOUSE",
		                "PROPERTY_SQUARE_HOUSE",
		                "PROPERTY_SQUARE_LIFE_HOUSE",
		                "PROPERTY_FLOOR",
		                "PROPERTY_TEHNOLOGY_HOUSE",
		                "PROPERTY_PRICE_HOUSE",
		                "PROPERTY_SIZE1",
		                "PROPERTY_SIZE2",
		            );
		
		            $arFilter = Array("IBLOCK_ID" => 21, "ID" => $ELEMENT_ID);
		            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 800), $arSelect);
		
		            while ($ob = $res->GetNextElement()) 
		            {
		                $cnt++;
		                $data = $ob->GetFields();
		                
		                $HOUSE[$cnt]['id_house'] = (int) $data['ID'];
		                $HOUSE[$cnt]['house_name'] = $data['NAME'];
		                $HOUSE[$cnt]['active'] = $data['ACTIVE'] == 'Y' ? 1 : 0;
		           
		                $HOUSE[$cnt]['id_category'] = $SERIES[$k]['id_category'];
		                $HOUSE[$cnt]['id_series'] = $SERIES[$k]['id_series'];
		                $HOUSE[$cnt]['series_name'] = $SERIES[$k]['series_name'];
		                $HOUSE[$cnt]['category_name'] = $SERIES[$k]['category_name'];
		
		                $HOUSE[$cnt]['total_area'] = (float)$data["PROPERTY_SQUARE_ALL_HOUSE_VALUE"];
		                $HOUSE[$cnt]['building_area'] = (float)$data["PROPERTY_SQUARE_HOUSE_VALUE"];
		                $HOUSE[$cnt]['living_area'] = (float)$data["PROPERTY_SQUARE_LIFE_HOUSE_VALUE"];
		                $HOUSE[$cnt]['floors'] = (int)$data["PROPERTY_FLOOR_VALUE"];
		                $HOUSE[$cnt]['technology'] = $data["PROPERTY_TEHNOLOGY_HOUSE_VALUE"];
		
		                $HOUSE[$cnt]['length'] = $data["PROPERTY_SIZE1_VALUE"];
		                $HOUSE[$cnt]['width'] = $data["PROPERTY_SIZE2_VALUE"];
		
		                if (stristr($data["PROPERTY_TEHNOLOGY_HOUSE_VALUE"], "аркасный")) $HOUSE[$cnt]['short_technology'] = 'Каркас';
		                if (stristr($data["PROPERTY_TEHNOLOGY_HOUSE_VALUE"], "ирпичный")) $HOUSE[$cnt]['short_technology'] = 'Кирпич'; 
		                if (stristr($data["PROPERTY_TEHNOLOGY_HOUSE_VALUE"], "брус")) $HOUSE[$cnt]['short_technology'] = 'Брус';
		                
		                $PRICE_ID = $data["PROPERTY_PRICE_HOUSE_VALUE"];
		                $arSelect_price = Array("ID", "NAME", "PROPERTY_PRICE_1", "PROPERTY_OPTIMAL_PRICE");
		                $arFilter_price = Array("IBLOCK_ID" => 22, "ID" => $PRICE_ID);
		                $res_price = CIBlockElement::GetList(Array(), $arFilter_price, false, Array("nPageSize" => 500), $arSelect_price);
		                while ($ob_price = $res_price->GetNextElement()) 
		                {
		                    $data_price = $ob_price->GetFields();
		                    $price_default = (int) $data_price["PROPERTY_PRICE_1_VALUE"];
		                    $price_optimal = (int) $data_price["PROPERTY_OPTIMAL_PRICE_VALUE"];
		                    $HOUSE[$cnt]['id_price'] = (int) $PRICE_ID;
							$HOUSE[$cnt]['price_value'] = ($price_default <= 0 || $price_default == $price_optimal) 
            											? (int)$price_optimal 
            											: (int)$price_default;
		                }
		            }
		        }
		    }
		
		    $clear_table_sql = "TRUNCATE TABLE b_filter_house;";
		    $DB->Query($clear_table_sql);
		
		    foreach ($HOUSE as $h) 
		    {
		        $insert_one_house_sql = "INSERT INTO `b_filter_house` "
		                . "(`id_category`, `id_series`, `id_house`, `category_name`, `series_name`, `house_name`, `id_price`, `price_value`, `total_area`, `building_area`, `living_area`, `floors`, `technology`, `short_technology`, `active`,`width`,`length`) VALUES "
		                . "({$h['id_category']}, {$h['id_series']}, {$h['id_house']}, '{$h['category_name']}', '{$h['series_name']}', '{$h['house_name']}', {$h['id_price']}, '{$h['price_value']}', {$h['total_area']}, {$h['building_area']}, {$h['living_area']}, {$h['floors']}, '{$h['technology']}', '{$h['short_technology']}', {$h['active']},'{$h['width']}','{$h['length']}');";
		
		        //echo $insert_one_house_sql."<br/>";
		        //die();
		
		        $res_sql = $DB->Query($insert_one_house_sql);
		        //echo "<pre>";
		        //var_dump($res_sql);
		    }
		}	
	}    
	
 	public static function ElementDeletionPreventer($ID)
    {
        global $APPLICATION;
        $res = CIBlockElement::GetById($ID);
        $arRes = $res->GetNext(); 
        if(in_array($arRes["IBLOCK_ID"], self::$DeletionForbidden))
        {
            $APPLICATION->throwException("В этом инфоблоке запрещено удалять элементы!");
			return false;
        }
    }
	
	public static function ElementAdditionHandler(&$arFields)
    { 
        if (array_key_exists($arFields["IBLOCK_ID"], self::$AfterAdditionOccured)) 
		{
        	// Вызываем требуемый обработчик для данного IBlock
        	foreach (self::$AfterAdditionOccured[$arFields["IBLOCK_ID"]] as $method) self::$method($arFields); 
		}
    }
	
	public static function ElementUpdateHandler(&$arFields)
    { 
        if (array_key_exists($arFields["IBLOCK_ID"], self::$AfterUpdateOccured)) 
		{
			// Вызываем требуемый обработчик для данного IBlock
        	foreach (self::$AfterUpdateOccured[$arFields["IBLOCK_ID"]] as $method) self::$method($arFields);  
		}
    }
	
	public static function ElementDeletionHandler($arFields)
    {
        if (array_key_exists($arFields["IBLOCK_ID"], self::$AfterDeletionOccured)) 
		{
			// Вызываем требуемый обработчик для данного IBlock
        	foreach (self::$AfterDeletionOccured[$arFields["IBLOCK_ID"]] as $method) self::$method($arFields);  
		}
    }
 }
 
?>
