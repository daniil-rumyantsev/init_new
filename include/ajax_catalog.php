<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
global $APPLICATION;


?>
<?php if (!$_GET['result_filter']): ?>
    <?php
    $APPLICATION->IncludeComponent(
            "bitrix:catalog.section.list", "", array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
        "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
        "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
        "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
        "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
            ), $component, array("HIDE_ICONS" => "Y")
    );
    ?>
<?php else: ?>

	<?php
		$result_filter = $_GET['result_filter'];

        $arSelect = Array("ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_VARIANTS_HOUSE", "PROPERTY_FILES", "PROPERTY_SIZER", "PREVIEW_PICTURE", "PROPERTY_PODPIS");
        $arFilter = Array("IBLOCK_ID" => 13, "ACTIVE" => "Y", Array("ID" => $result_filter));
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 150), $arSelect);
        while ($ob = $res->GetNextElement()) {
            $arFields[] = $ob->GetFields();
        }


        if (count($arFields) > 0) {
            foreach ($arFields as $k => $item) {
                foreach ($item["PROPERTY_VARIANTS_HOUSE_VALUE"] as $id) {
                    $arSelect = Array("ID", "NAME", "PROPERTY_TEHNOLOGY_HOUSE", "PROPERTY_PRICE_HOUSE", "PROPERTY_CODE_1C","PROPERTY_SQUARE_ALL_HOUSE");
                    $arFilter = Array("IBLOCK_ID" => 21, "ID" => $id);
                    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                    while ($ob = $res->GetNextElement()) {
                        $arFields[$k]['OPT'][] = $ob->GetFields();
                        $arFields[$k]['SQ'][] = $ob->GetFields()["PROPERTY_SQUARE_ALL_HOUSE_VALUE"];
                    }
                }
            }

            foreach ($arFields as $k => $item) {
                foreach ($item["OPT"] as $i => $value) {
                    if ($value["PROPERTY_PRICE_HOUSE_VALUE"]) {
                        $arSelect = Array("ID", "NAME", "PROPERTY_PRICE_1", "PROPERTY_PRICE_2", "PROPERTY_OPTIMAL_PRICE");
                        $arFilter = Array("IBLOCK_ID" => 22, "ID" => $value["PROPERTY_PRICE_HOUSE_VALUE"]);
                        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                        while ($ob = $res->GetNextElement()) {
                            $arFields[$k]['OPT'][$i]['PRICE'] = $ob->GetFields();
                        }
                    }
                }
            }
        }
?>
<noidex>
    <section class="content" role="">
        <div class="container">
            <div class="flex-reversed">
                
                
               
                    
                    
                    <?php if (count($arFields) > 0): ?>
                        <?php $cnt = 0;?>
                        <?php foreach ($arFields as $item): ?>
                            <?php if($cnt == 0):?>
                                 <div class="row" id="items">
                            <?php endif?>
                    
                            
                                <?php if (count($item['PROPERTY_FILES_VALUE']) === 1): ?>
                                    <div sortkey="2" sort="10" class="col-xs-12 col-md-6 col-sm-12">
                                    <div class="my-promotion desgin-4 my-margin hover-grey single-item new-single-item">
                                <?php else: ?>
                                        <div sortkey="2" sort="10" class="col-xs-12 col-md-6 col-sm-12">
                                    <div class="my-promotion desgin-4 my-margin hover-grey new-single-item">
                                <?php endif; ?>
                                    
                                    <div class="flex-row">
                                       <div>
                                            <a href="<?= $item["DETAIL_PAGE_URL"] ?>">
                                                <?php if ($item["PREVIEW_PICTURE"]): ?>
                                                    <?php $img = CFile::GetPath($item["PREVIEW_PICTURE"]); ?>
                                                    <img src="<?= $img ?>" alt="<?= $arItem["NAME"] ?>">
                                                <?php else: ?>
                                                    <img src="/bitrix/templates/.default/assets/img/yeplo1.jpg">
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                        <div>
                                            <div class="description">
                                                <h4 class="text-uppercase">
                                                    <?= $item['NAME'] ?>
                                                </h4>
                                                <?php foreach ($item['OPT'] as $k => $Item): ?>
                                                    <?php $CODE_1C = $item["OPT"][0]['PROPERTY_CODE_1C_VALUE']; ?>
                                                <?php endforeach; ?>
                                                <a href="#" class="advice" data-target="#formAdvice" data-code="<?= $CODE_1C ?>" data-price="<?= $item['OPT'][0]["PRICE"]["PROPERTY_PRICE_1_VALUE"] ?>000" data-whatever="<?= $item["NAME"] ?> <?= $item["PROPERTIES"]['SIZER']['VALUE'] ?>" data-toggle="modal"><i class="glyphicon glyphicon-earphone"></i></a>
                                            </div>
                                            <div class="options">
                                                <div>
                                                            <?php 
                                                               //echo "<pre>";
                                                                //var_dump($item["OPT"][0]["PRICE"]);
                                                            ?>
                                                    <div class="description-title">
                                                        <?php
                                                        echo preg_replace('(х)', 'х', $item["PROPERTY_SIZER_VALUE"]) . ' м';
                                                        ?> 
                                                        <p>Площадь: <strong><?=min($item['SQ'])?> – <?=max($item['SQ'])?>  кв.м</strong></p>
                                                        <?= $item["PROPERTY_PODPIS_VALUE"] ?>
                                                    </div>
                                                    <div class="description__price">
                                                        <span class="current-price">
                                                            <?php if ($item["OPT"][0]["PRICE"]["PROPERTY_OPTIMAL_PRICE_VALUE"] > 0 && $item["OPT"][0]["PRICE"]["PROPERTY_OPTIMAL_PRICE_VALUE"] != NULL): ?>  
                                                                    <?php echo 'от ' . number_format($item["OPT"][0]["PRICE"]["PROPERTY_OPTIMAL_PRICE_VALUE"], 3, ' ', ' '); ?> р.
                                                                <?php else: ?>  
                                                                    <?php echo 'от ' . number_format($item["OPT"][0]["PRICE"]["PROPERTY_PRICE_1_VALUE"], 3, ' ', ' '); ?> р.
                                                                <?php endif; ?>
                                                        </span>
                                                        <span class="future-price">
                                                            <?php echo number_format($item["OPT"][0]["PRICE"]["PROPERTY_PRICE_2_VALUE"], 3, ' ', ' '); ?> р.
                                                        </span>
                                                        <a href="<?= $item["DETAIL_PAGE_URL"] ?>" class="show-more-link">Смотреть планировку</a>
                                                    </div>
                                                    <!-- <p>
                                                        <b>Варианты исполнения:</b>
                                                    </p>
                                                    <?php foreach ($item['OPT'] as $k => $Itemar): ?>
                                                        <p><?= $Itemar["PROPERTY_TEHNOLOGY_HOUSE_VALUE"] ?>: 
                                                            <strong>от 
                                                                <?php if ($Itemar["PRICE"]["PROPERTY_OPTIMAL_PRICE_VALUE"] > 0 && $Itemar["PRICE"]["PROPERTY_OPTIMAL_PRICE_VALUE"] != NULL): ?>  
                                                                    <?php echo preg_replace("/000$/", "$1", number_format($Itemar["PRICE"]["PROPERTY_OPTIMAL_PRICE_VALUE"], 3, ' ', ' ')); ?> т.р.
                                                                <?php else: ?>  
                                                                    <?php echo preg_replace("/000$/", "$1", number_format($Itemar["PRICE"]["PROPERTY_PRICE_1_VALUE"], 3, ' ', ' ')); ?> т.р.
                                                                <?php endif; ?>          

                                                            </strong>
                                                        </p>
                                                    <?php endforeach; ?>
                                                    </p> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <a class="all-item-link" href="<?= $item["DETAIL_PAGE_URL"] ?>" ></a>


                                </div>
                            </div>
                                
                            <?php $cnt++;?>    
                            <?php if($cnt == 2):?>
                                <?php $cnt =0;?>   
                                         </div>
                            <?php endif?>
                        <?php endforeach; ?>
                    <?php endif; ?>



               
            </div>


        </div>
    </section>
</noidex>
<?php endif;?>