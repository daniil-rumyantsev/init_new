<?php
require_once("Mobile_Detect.php");
require_once("excel/reader.php");
require_once("CAddServicesParcer.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/include/classes/IBlockChangeHandler.php");

// Запрет удаления элементов инфоблока
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("IBlockChangeHandler", "ElementDeletionPreventer"));

// Отслеживание изменений элементов инфоблока
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("IBlockChangeHandler", "ElementUpdateHandler"));

// Отслеживание добавления элементов в инфоблок
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("IBlockChangeHandler", "ElementAdditionHandler"));

// Отслеживание удаления элементов из инфоблока
AddEventHandler("iblock", "OnAfterIBlockElementDelete", Array("IBlockChangeHandler", "ElementDeletionHandler"));


function isCard(){

        global $APPLICATION;

        $page = $APPLICATION->GetCurPage();
        $isCard = false;

        $arFilter = Array('IBLOCK_ID'=>13);
        $db_list = CIBlockSection::GetList(Array(), $arFilter, true);
 
          while($ar_result = $db_list->GetNext())
          {
            $arURL[] = $ar_result['CODE'];
          }

          foreach ($arURL as $key => $value) {

            if(strripos($page, $value)){
                $str = explode('/', $page);

                if(count($str) >= 5){
                    $isCard =  true;
                }
             
            }
             
          }


        return $isCard;

}

// function OnAfterIBlockElementUpdate(&$arFields) {
    // if ($arFields["IBLOCK_ID"] == 21) {
        // CAddServicesParcer::ParceFileData($arFields);
        // return $arFields;
    // }
// }


//Прмяоугольник
function thumb2($path, $side_x = 640, $side_y = 480, $rewrite = FALSE) {

    $new_img_path = substr($path, 0, strlen($path) - 4).'_thumb.jpg';
    
    if (!$rewrite && file_exists($new_img_path)) {
        return $new_img_path;
    }
    
    $img_src = imagecreatefromjpeg($path);
    
    $img_dest = imagecreatetruecolor($side_x, $side_y);
    $color = imagecolorallocate($img_dest, 255, 255, 255);
    imagefill($img_dest, 0, 0, $color);
    
    $x = imagesx($img_src);
    $y = imagesy($img_src);
    
    $ratio = max($x / $side_x, $y / $side_y);
    
    $width = round($x / $ratio);
    $height = round($y / $ratio);
    
    $left = round(($side_x - $width) / 2);
    $top = round(($side_y - $height) / 2);
    
    imagecopyresampled($img_dest, $img_src, $left, $top, 0, 0, $width, $height, $x, $y);
    
    imagejpeg($img_dest, $new_img_path);
    
    return $new_img_path;
    
    
}


//Квадрат
function thumb($path, $side = 250) {

    $info = pathinfo($path);
    $file = basename($path, '.' . $info['extension']);

    $new_img_file = $info['dirname'] . '/' . $file . '_thumb.jpg';
    
    if (file_exists($new_img_file)) {
        return $new_img_file;
    }

    $info = getimagesize($path);
    $w = $info[0];
    $h = $info[1];
    $mime = $info['mime'];

    if ($w > $h) {
        $h = round($h / floatval($w / $side));
        $w = $side;

        $left = 0;
        $top = round(($side - $h) / 2);
    } elseif ($h > $w) {
        $w = round($w / floatval($h / $side));
        $h = $side;

        $left = round(($side - $w) / 2);
        $top = 0;
    } else {
        $w = $side;
        $h = $side;
        $left = 0;
        $top = 0;
    }

    switch ($mime) {
        case 'image/jpeg':
            $img_original = imagecreatefromjpeg($path);
            break;
        case 'image/png':
            $img_original = imagecreatefrompng($path);
            break;
    }

    $img_dest = imagecreatetruecolor($side, $side);
    $color = imagecolorallocate($img_dest, 255, 255, 255);
    imagefill($img_dest, 0, 0, $color);

    imagecopyresampled($img_dest, $img_original, $left, $top, 0, 0, $w, $h, imagesx($img_original), imagesy($img_original));

    imagejpeg($img_dest, $new_img_file, 100);
    
    return $new_img_file;

}


//Окончание слова
function declension_words($num,$arWords){
	if ($num < 21){
		if ($num == 1)
			$w = $arWords[0];
		elseif ($num > 1 && $num < 5)
			$w = $arWords[1];
		else
			$w = $arWords[2];
		return $w;
	} else {
		$l = (int)substr($num, -1);
		if ($l == 1)
			$w = $arWords[0];
		elseif ($l > 1 && $l < 5)
			$w = $arWords[1];
		else
			$w = $arWords[2];
		return $w;
	}
}
