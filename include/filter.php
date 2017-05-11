<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $USER;
global $DB;
$SECTION_ID = $arResult["VARIABLES"]["SECTION_ID"];
$res = CIBlockSection::GetByID($SECTION_ID );
if($ar_res = $res->GetNext()){
    $SECTION_NAME = $ar_res['NAME'];
}

if($_GET['resetFilter'] == 'Y'){
    SetCookie("categories","");
    SetCookie("series_check","");
    SetCookie("realmodel","");
    SetCookie("tech_check","");
    SetCookie("max_area","");
    SetCookie("min_area","");
    SetCookie("floor_check","");
    SetCookie("max_price","");
    SetCookie("min_price","");
}
?>
<?php if (CModule::IncludeModule("iblock")): ?>
    <?php
    $result = array();
    if($SECTION_ID){
    	
        $categories = array($SECTION_ID => $SECTION_NAME);
		$_GET["category"] = $SECTION_NAME;
    }else{
        $categories = array();
    }
    
    $series = array();
    $floors = array();
    $tehnologies = array();
    $areas = array();
    $min_area = 0;
    $max_area = 0;
    $prices = array();
    $widths = array();
    $lengths = array();
    $min_price = 0;
    $max_price = 0;
    $min_width = 0;
    $max_width = 0;
    $min_length = 0;
    $max_length = 0;
	
    if (!empty($_GET))
    {

        $result_sql = "SELECT * FROM b_filter_house WHERE active = '1'";

        if ($_GET["category"]) {
            $cat = mysql_escape_string(HTMLToTxt($_GET["category"]));
            $result_sql = $result_sql . " AND category_name = '{$cat}'";
        }
        if ($_GET["model"]) {
            $ser = mysql_escape_string(HTMLToTxt($_GET["model"]));
            $result_sql = $result_sql . " AND series_name = '{$ser}'";
        }

        if ($_GET["house-floors"]) {
            $floor = (int)$_GET["house-floors"];
            $result_sql = $result_sql . " AND floors = '{$floor}'";
        }

        if ($_GET["house-tech"]) {
            $tech = mysql_escape_string(HTMLToTxt($_GET["house-tech"]));
            $result_sql = $result_sql . " AND technology = '{$tech}'";
        }

        if ($_GET["max-area"] && $_GET["max-area"] != 'NaN' && $_GET["max-area"] != '0') {
            $max_area = (int)$_GET["max-area"];
            $result_sql = $result_sql . " AND total_area <= {$max_area}";
        }

        if ($_GET["min-area"] && $_GET["min-area"] != 'NaN' && $_GET["min-area"] != '0') {
            $min_area = (int)$_GET["min-area"];
            $result_sql = $result_sql . " AND total_area >= {$min_area}";
        }

        if ($_GET["max-area"] && $_GET["max-area"] != 'NaN' && $_GET["max-area"] != '0') {
            $max_price = (int)$_GET["max-area"];
            $result_sql = $result_sql . " AND price_value <= {$max_price}";
        }

        if ($_GET["min-price"] && $_GET["min-price"] != 'NaN' && $_GET["min-price"] != '0') {
            $min_price = (int)$_GET["min-price"];
            $result_sql = $result_sql . " AND price_value >= {$min_price}";
        }

		if ($_GET["max-price"] && $_GET["max-price"] != 'NaN' && $_GET["max-price"] != '0') {
            $max_price = (int)$_GET["max-price"];
            $result_sql = $result_sql . " AND price_value <= {$max_price}";
        }


        if ($_GET["min-length"] && $_GET["min-length"] != 'NaN' && $_GET["min-length"] != '0') {
            $min_length = (int)$_GET["min-length"];
            $result_sql = $result_sql . " AND length >= {$min_length}";
        }
        

        if ($_GET["min-width"] && $_GET["min-width"] != 'NaN' && $_GET["min-width"] != '0') {
            $min_width = (int) $_GET["min-width"];
            $result_sql = $result_sql . " AND width >= {$min_width}";
        }

        $result_sql = $result_sql." ORDER BY series_name";
        $resultSQL = $DB->Query($result_sql);

        $result = array();
        while ($row = $resultSQL->Fetch()) {
            $result[] = $row;
        }

       // echo 'sql';
       // var_dump($result);
       // $result = array_unique($result);
       // die();

        foreach ($result as $v) 
        {
            if (!in_array($v['category_name'], $categories)) {
                $categories[$v['id_category']] = $v['category_name'];
            }
            if (!in_array(trim($v['series_name']), $series)) {

                $series[$v['id_series']] = trim($v['series_name']);
            }
            if (!in_array($v['floors'], $floors)) {
                $floors[] = $v['floors'];
            }
            if (!in_array($v['technology'], $tehnologies)) {
                $tehnologies[] = $v['technology'];
            }
            if (!in_array($v['total_area'], $areas)) {
                $areas[] = round($v['total_area']);
            }
            if (!in_array($v['price_value'], $prices)) {
                $prices[] = round($v['price_value']);
            }
            if (!in_array($v['width'], $widths)) {
                $widths[] = round($v['width']);
            }
            if (!in_array($v['length'], $lengths)) {
                $lengths[] = round($v['length']);
            }
        }

        $min_area = min($areas);
        $max_area = max($areas);

        $min_price = min($prices);
        $max_price = max($prices);

        $min_length = min($lengths);
        $max_length = max($lengths);


        $min_width = min($widths);
        $max_width = max($widths); 
        
  
    } else {

//var_dump($SECTION_ID);
		
        if($SECTION_ID){
        	
			
            $result_sql = $DB->Query("SELECT * FROM b_filter_house WHERE active = 1 AND category_name = '{$SECTION_NAME}' ORDER BY series_name");
        }else{
           $result_sql = $DB->Query("SELECT * FROM b_filter_house WHERE active = 1 ORDER BY series_name"); 
        }
        



        while ($row = $result_sql->Fetch()) {
            $result[] = $row;
        }

        foreach ($result as $v) {
            if (!in_array($v['category_name'], $categories)) {
                $categories[$v['id_category']] = $v['category_name'];
            }
            if (!in_array(trim($v['series_name']), $series)) {

                $series[$v['id_series']] = trim($v['series_name']);
            }
            if (!in_array($v['floors'], $floors)) {
                $floors[] = $v['floors'];
            }
            if (!in_array($v['technology'], $tehnologies)) {
                $tehnologies[] = $v['technology'];
            }
            if ($v['total_area'] && !in_array($v['total_area'], $areas)) {
                $areas[] = $v['total_area'];
            }
            if (!in_array($v['price_value'], $prices)) {
                $prices[] = $v['price_value'];
            }
            if (!in_array($v['width'], $widths)) {
                $widths[] = round($v['width']);
            }
            if (!in_array($v['length'], $lengths)) {
                $lengths[] = round($v['length']);
            }
        }

        $min_area = min($areas);
        $max_area = max($areas);

        $min_price = round(min($prices));
        $max_price = round(max($prices));

        $min_length = min($lengths);
        $max_length = max($lengths);


        $min_width = min($widths);
        $max_width = max($widths);
		
    }
    
    
  sort($series);
  reset($series);




    ?>
    <?//$APPLICATION->AddHeadScript('/include/new_filter.js');?>

    <div class="house__filter">
        <form action="" method="get" id="filter" class="filter-form" novalidate>
            <input type='hidden'name='security' id="valit" value='<?php echo md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);?>'/>
            <div class="dropdown">
                <input type="hidden" name="realmodel" id="realmodel" value="" id="realmodel"/>
                
                <?php  if($SECTION_ID) :?>
                 <input name="category" id="category" value="<?=$SECTION_NAME?>" class="hidden" type="text">
                    <span class="my-cross" id="categoryDropdown_cross" data-parent="categoryDropdown" style="display: block;"></span>
                    <button class="btn my-btn-filter btn-lg dropdown-toggle my-btn-filter--highlighted" type="button" id="categoryDropdown" data-checked="true" data-placeholder="<?=$SECTION_NAME?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$SECTION_NAME?>
                        <span class="my-caret" style="display:none;"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu--terem categories-filter" aria-labelledby="dropdownRoad">
                        <span class="my-arrow-top"></span>
                        <?php foreach ($categories as $k => $v): ?>
                            <li data-id="<?=$SECTION_NAME?>" class="category-li-filter" data-id="<?=$SECTION_NAME?>"><a href="#" data-name="<?=$SECTION_NAME?>"><?=$SECTION_NAME?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else:?>    

                        <?php if($_GET["category"]):?>
                            <input name="category" id="category" value="<?= $_GET["category"] ?>" class="hidden" type="text">
                            <span class="my-cross" id="categoryDropdown_cross" data-parent="categoryDropdown" style="display: block;"></span>
                            <button class="btn my-btn-filter btn-lg dropdown-toggle my-btn-filter--highlighted" type="button" id="categoryDropdown" data-checked="true" data-placeholder="Категория дома" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_GET["category"] ?>
                                <span class="my-caret" style="display: none;"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu--terem categories-filter" aria-labelledby="dropdownRoad">
                                <span class="my-arrow-top"></span>
                                <?php foreach ($categories as $k => $v): ?>
                                    <li data-id="<?= $v ?>" class="category-li-filter"><a href="#" data-name="<?= $v ?>"><?= $v ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else:?>
                            <input name="category" id="category" value="" class="hidden" type="text">
                            <span class="my-cross" id="categoryDropdown_cross" data-parent="categoryDropdown"></span>
                            <button class="btn my-btn-filter btn-lg dropdown-toggle" type="button" id="categoryDropdown" data-checked="false" data-placeholder="Категория дома" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Категория дома
                                <span class="my-caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu--terem categories-filter" aria-labelledby="dropdownRoad">
                                <span class="my-arrow-top"></span>


                                <?php foreach ($categories as $k => $v): ?>
                                    <li data-id="<?= $v ?>" class="category-li-filter"><a href="#" data-name="<?= $v ?>"><?= $v ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                <?php endif; ?>



               
            </div>

            <div class="dropdown">


                    <?php if($_GET['series']): ?>
                        <input name="model" id="modalinpt" value="<?= $_GET['series'] ?>" class="hidden" type="text">
                        <span class="my-cross" id="seriesDropdown_cross" style="display: inline;" data-parent="seriesDropdown"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle my-btn-filter--highlighted" type="button" id="seriesDropdown" data-checked="false" data-placeholder="Серия" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $_GET['series'] ?>
                            <span class="my-caret" style="display: none;"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu--terem series-filter" aria-labelledby="dropdownRoad">
                            <?php foreach ($series as $k => $v): ?>
                                <li data-id="<?= $v ?>" data-value="<?= $v ?>" data-key="<?= $k ?>" class="series-filter-li"><a href="#" data-name="<?= $v ?>" ><?= $v ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <input name="model" id="modalinpt" value="" class="hidden" type="text">
                        <span class="my-cross" id="seriesDropdown_cross" data-parent="seriesDropdown"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle" type="button" id="seriesDropdown" data-checked="false" data-placeholder="Серия" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Серия
                            <span class="my-caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu--terem series-filter" aria-labelledby="dropdownRoad" >
                            <?php foreach ($series as $k => $v): ?>
                                <li data-id="<?= $v ?>" data-value="<?= $v ?>" data-key="<?= $k ?>" class="series-filter-li"><a href="#" data-name="<?= $v ?>" ><?= $v ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>



            </div>

            <div class="dropdown">


                    <?php if($_GET['min-area'] || $_GET['max-area']):?>
                        <span class="my-cross" id="house-areaDropdown_cross" style="display: inline;" data-parent="house-areaDropdown"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle my-btn-filter--highlighted" type="button" id="house-areaDropdown" data-placeholder="Площадь" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if ($_GET['min-area']): ?> от <?= $_GET['min-area'] ?> <?php endif; ?>
                            <?php if ($_GET['max-area']): ?> до <?= $_GET['max-area'] ?> <?php endif; ?>
                            <span class="my-caret" style="display: none;"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu--terem" aria-labelledby="house-areaDropdown">
                            <div class="range-box">
                                <div class="input-wrapper"><input name="house-areaFrom" data-name="house-area" id="house-area-from" placeholder="от <?= $min_area ?>" data-val="<?= $min_area ?>" value="<?= $_GET['min-area'] ?>" step="1" type="number" min="<?= $min_area ?>"><span class="enter-icon"></span></div>
                                <span>&nbsp;-&nbsp;</span>
                                 <div class="input-wrapper"><input name="house-areaUpto" data-name="house-area" id="house-area-up-to" placeholder="до <?= $max_area ?>" data-val="<?= $max_area ?>" value="<?= $_GET['max-area'] ?>" step="1" type="number" max="<?= $max_area ?>"><span class="enter-icon"></span></div>
                                <span>м<sup>2</sup></span>
                            </div>
                        </div>
                    <?php else: ?>
                        <span class="my-cross" id="house-areaDropdown_cross" data-parent="house-areaDropdown"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle" type="button" id="house-areaDropdown" data-placeholder="Площадь" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Площадь
                            <span class="my-caret"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu--terem" aria-labelledby="house-areaDropdown">
                            <div class="range-box">
                                 <div class="input-wrapper"><input name="house-areaFrom" data-name="house-area" id="house-area-from" placeholder="от <?= $min_area ?>" data-val="<?= $min_area ?>" value="" step="1" type="number" min="<?= $min_area ?>"><span class="enter-icon"></span></div>
                                <span>&nbsp;-&nbsp;</span>
                                 <div class="input-wrapper"><input name="house-areaUpto" data-name="house-area" id="house-area-up-to" placeholder="до <?= $max_area ?>" data-val="<?= $max_area ?>" value="" step="1" type="number" max="<?= $max_area ?>"><span class="enter-icon"></span></div>
                                <span>м<sup>2</sup></span>
                            </div>
                        </div>
                    <?php endif; ?>





            </div>
            <div class="dropdown">

                    <?php if($_GET['house-floors']):?>
                        <input name="house-floors" id="floors" value="<?= $_GET['house-floors'] ?>" class="hidden" type="text">
                        <span class="my-cross" id="house-floorsDropdown_cross" style="display: inline;" data-parent="house-floorsDropdown"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle my-btn-filter--highlighted" type="button" id="house-floorsDropdown" data-checked="false" data-placeholder="Этажность" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $_GET['house-floors'] ?> <?php echo declension_words($_GET['house-floors'], ['этаж', 'этажа', 'этажей']); ?>
                            <span class="my-caret" style="display: none;"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu--terem floors-filter" aria-labelledby="dropdownRoad">
                            <?php foreach ($floors as $k => $v): ?>
                                <li data-id="<?= $v ?>" class="floor-dilter-li" data-real="<?= $k ?>"><a href="#" data-name="<?= $v ?>" data-id="<?= $k ?>"><?= $v ?> <?php echo declension_words($v, ['этаж', 'этажа', 'этажей']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else:?>
                        <input name="house-floors" id="floors" value="" class="hidden" type="text">
                        <span class="my-cross" id="house-floorsDropdown_cross" data-parent="house-floorsDropdown"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle " type="button" id="house-floorsDropdown" data-checked="false" data-placeholder="Этажность" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Этажность
                            <span class="my-caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu--terem floors-filter" aria-labelledby="dropdownRoad">
                            <?php foreach ($floors as $k => $v): ?>
                                <li data-id="<?= $v ?>" class="floor-dilter-li" data-real="<?= $k ?>"><a href="#" data-name="<?= $v ?>" data-id="<?= $k ?>"><?= $v ?> <?php echo declension_words($v, ['этаж', 'этажа', 'этажей']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif;?>





            </div>
            <div class="dropdown">


                    <?php if($_GET['house-tech']):?>
                        <input name="house-tech" value="<?= $_GET['house-tech'] ?>" id="tech" class="hidden" type="text">
                        <span class="my-cross" id="house-techDropdown_cross" data-parent="house-techDropdown" style="display: inline;"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle my-btn-filter--highlighted" type="button" id="house-techDropdown" data-checked="false" data-placeholder="Технология" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $_GET['house-tech'] ?>
                            <span class="my-caret" style="display: none;"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu--terem tehnologies-filter" aria-labelledby="dropdownRoad">
                            <?php foreach ($tehnologies as $k => $v): ?>
                                <li  data-id="<?= $v ?>" class="filter-tech-li"><a href="#" data-name="<?= $v ?>"><?= $v ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else:?>
                        <input name="house-tech" value="" id="tech" class="hidden" type="text">
                        <span class="my-cross" id="house-techDropdown_cross" data-parent="house-techDropdown"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle" type="button" id="house-techDropdown" data-checked="false" data-placeholder="Технология" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Технология
                            <span class="my-caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu--terem tehnologies-filter" aria-labelledby="dropdownRoad">
                            <?php foreach ($tehnologies as $k => $v): ?>
                                <li  data-id="<?= $v ?>" class="filter-tech-li"><a href="#" data-name="<?= $v ?>"><?= $v ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif;?>

            </div>







                <?php if($_GET['min-price'] || $_GET['max-price']):?>
                    <div class="dropdown">
                        <span class="my-cross" id="house-priceDropdown_cross" style="display: inline;" data-parent="house-priceDropdown"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle my-btn-filter--highlighted" type="button" id="house-priceDropdown" data-placeholder="Цена" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if ($_GET['min-price']): ?> от <?= $_GET['min-price'] ?> <?php endif; ?>
                            <?php if ($_GET['max-price']): ?> до <?= $_GET['max-price'] ?> <?php endif; ?>
                            <span class="my-caret" style="display: none;"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu--terem" aria-labelledby="house-priceDropdown">
                            <div class="range-box">
                                <div class="input-wrapper"><input name="house-priceFrom" data-name="house-price" id="house-price-from" data-val="<?= $min_price ?>" value="<?= $_GET['min-price'] ?>" placeholder="от <?= $min_price ?>" type="number" min="<?= $min_price ?>"><span class="enter-icon"></span></div>
                                &nbsp;-&nbsp;
                                <div class="input-wrapper"><input name="house-priceUpto" data-name="house-price" id="house-price-up-to" data-val="<?= $max_price ?>" value="<?= $_GET['max-price'] ?>" placeholder="до <?= $max_price ?>" type="number" max="<?= $max_price ?>"><span class="enter-icon"></span></div>
                                тыс.&nbsp;р.
                            </div>
                        </div>
                    </div>
                <?php else:?>
                    <div class="dropdown">
                        <span class="my-cross" id="house-priceDropdown_cross" data-parent="house-priceDropdown"></span>
                        <button class="btn my-btn-filter btn-lg dropdown-toggle" type="button" id="house-priceDropdown" data-placeholder="Цена" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Цена
                            <span class="my-caret"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu--terem" aria-labelledby="house-priceDropdown">
                            <div class="range-box">
                                <div class="input-wrapper"><input name="house-priceFrom" data-name="house-price" id="house-price-from" data-val="<?= $min_price ?>" value="" placeholder="от <?= $min_price ?>" type="number"><span class="enter-icon"></span></div>
                                &nbsp;-&nbsp;
                                <div class="input-wrapper"><input name="house-priceUpto" data-name="house-price" id="house-price-up-to" data-val="<?= $max_price ?>" value="" placeholder="до <?= $max_price ?>" type="number"><span class="enter-icon"></span></div>
                                тыс.&nbsp;р.
                            </div>
                        </div>
                    </div>
                <?php endif;?>


            <?php if($_GET['min-width'] || $_GET['min-length']):?>
                <div class="dropdown">
                    <span class="my-cross" id="house-sizeDropdown_cross" style="display: inline;" data-parent="house-sizeDropdown"></span>
                    <button class="btn my-btn-filter btn-lg dropdown-toggle my-btn-filter--highlighted" type="button" id="house-sizeDropdown" data-placeholder="Размер" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if ($_GET['min-length']): ?> <?= $_GET['min-length'] ?> <?php endif; ?>
                        <?php if ($_GET['min-width']): ?> x <?= $_GET['min-width'] ?> <?php endif; ?>
                        <span class="my-caret"  style="display: none;"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu--terem" aria-labelledby="house-sizeDropdown">
                        <div class="range-box">
                            <div class="input-wrapper"><input name="house-lengthFrom" data-name="house-length" id="house-length-from" data-val="<?= $min_length ?>" value="<?= $_GET['min-length'] ?>" placeholder="ширина" type="number"><span class="enter-icon"></span></div>
                            &nbsp;-&nbsp;
                            <div class="input-wrapper"><input name="house-widthFrom" data-name="house-width" id="house-width-from" data-val="<?= $min_width ?>" value="<?= $_GET['min-width'] ?>" placeholder="длина" type="number"><span class="enter-icon"></span></div>
                            м
                        </div>
                    </div>
                </div>
            <?php else:?>
                <div class="dropdown">
                    <span class="my-cross" id="house-sizeDropdown_cross" data-parent="house-sizeDropdown"></span>
                    <button class="btn my-btn-filter btn-lg dropdown-toggle" type="button" id="house-sizeDropdown" data-placeholder="Размер" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Размер
                        <span class="my-caret"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu--terem" aria-labelledby="house-sizeDropdown">
                        <div class="range-box">
                            <div class="input-wrapper"><input name="house-lengthFrom" data-name="house-length" id="house-length-from" data-val="<?= $min_length ?>" value="" placeholder="до <?= $max_length ?>" type="number"><span class="enter-icon"></span></div>
                            &nbsp;-&nbsp;
                            <div class="input-wrapper"><input name="house-widthFrom" data-name="house-width" id="house-width-from" data-val="<?= $min_width ?>" value="" placeholder="до <?= $max_width ?>" type="number"><span class="enter-icon"></span></div>
                            м.
                        </div>
                    </div>
                </div>
            <?php endif;?>

        </form>
        <div class="row b-chosen-options">
            <div class="col-xs-12 text-center">
                Вы выбрали <span id="variants-count"></span>: 
                            
                            <?php  if($SECTION_ID) :?>
                                <span class="chosen-option" id="categoryDropdown_span">
                                    <?=$SECTION_NAME?>
                                </span>
                            <?php else:?>
                                <?php if($_GET['category']):?>
                                    <span class="chosen-option" id="categoryDropdown_span">
                                        <?= $_GET['category'] ?>
                                        <span class="my-cross my-cross--b-chosen-option house-categoryDropdown" data-parent="house-categoryDropdown"></span>
                                    </span>
                                <?php else:?>
                                    <span class="chosen-option" id="categoryDropdown_span"></span>
                                <?php endif;?>
                            <?php endif;?>

                            <?php if($_GET['series']): ?>
                                <span class="chosen-option" id="seriesDropdown_span">
                                    <?= $_GET['series'] ?>
                                    <span class="my-cross my-cross--b-chosen-option house-seriesDropdown" data-parent="house-seriesDropdown"></span>
                                </span>
                            <?php else:?>
                                <span class="chosen-option" id="seriesDropdown_span"></span>
                            <?php endif;?>
                            
                            <?php if($_GET['min-area'] || $_GET['max-area']):?>
                                <span class="chosen-option" id="house-areaDropdown_span">
                                    <?php if ($_GET['min-area']): ?> от <?= $_GET['min-area'] ?> <?php endif; ?>
                                    <?php if ($_GET['max-area']): ?> до <?= $_GET['max-area'] ?> <?php endif; ?> кв.м
                                    <span class="my-cross my-cross--b-chosen-option house-areaDropdown" data-parent="house-areaDropdown"></span>
                                </span>
                            <?php else:?>
                                <span class="chosen-option" id="house-areaDropdown_span"></span>
                            <?php endif;?>



                            <?php if($_GET['house-floors']):?>
                                <span class="chosen-option" id="house-floorsDropdown_span">
                                    <?= $_GET['house-floors'] ?> эт.
                                    <span class="my-cross my-cross--b-chosen-option house-floorDropdown" data-parent="house-floorDropdown"></span>
                                </span>
                            <?php else:?>
                                <span class="chosen-option" id="house-floorsDropdown_span"></span>
                            <?php endif;?>


                            <?php if($_GET['house-tech']):?>
                                <span class="chosen-option" id="house-techDropdown_span">
                                    <?= $_GET['house-tech'] ?> 
                                    <span class="my-cross my-cross--b-chosen-option house-techDropdown" data-parent="house-techDropdown"></span>
                                </span>
                            <?php else:?>
                                <span class="chosen-option" id="house-techDropdown_span"></span>
                            <?php endif;?>

                            
                            <?php if($_GET['min-price'] || $_GET['max-price']):?>
                                <span class="chosen-option" id="house-priceDropdown_span">
                                    <?php if ($_GET['min-price']): ?> от <?= $_GET['min-price'] ?> <?php endif; ?>
                                    <?php if ($_GET['max-price']): ?> до <?= $_GET['max-price'] ?> <?php endif; ?> тыс.р.
                                    <span class="my-cross my-cross--b-chosen-option house-priceDropdown" data-parent="house-priceDropdown"></span>
                                </span>
                            <?php else:?>
                                <span class="chosen-option" id="house-priceDropdown_span"></span>
                            <?php endif;?>

                            <?php if($_GET['min-width'] || $_GET['min-length']):?>
                                <span class="chosen-option" id="house-sizeDropdown_span">
                                    <?php if ($_GET['min-length']): ?> <?= $_GET['min-length'] ?> <?php endif; ?>
                                	<?php if ($_GET['min-width']): ?> x <?= $_GET['min-width'] ?> <?php endif; ?> м
                                    <span class="my-cross my-cross--b-chosen-option house-sizeDropdown" data-parent="house-sizeDropdown"></span>
                                </span>
                            <?php else:?>
                                <span class="chosen-option" id="house-sizeDropdown_span"></span>
                            <?php endif;?>
                 <a href="/catalog/" id="filter_refresh" class="refresh-button  refresh-button--sm-font">Сбросить все фильтры<span class="my-cross--link2"></span></a>
            </div>
            <div class="col-xs-12 text-center error-msg">
                <span>
                    <strong>Нет домов, подходящих условию поиска!</strong>
                </span>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php
//echo "<pre>";
//var_dump($_COOKIE);
?>
