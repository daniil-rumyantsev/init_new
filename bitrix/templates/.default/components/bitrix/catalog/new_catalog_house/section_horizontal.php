<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();



use Bitrix\Main\Loader,
    Bitrix\Main\ModuleManager;

$SECTION_ID = $arResult["VARIABLES"]["SECTION_ID"];
$res = CIBlockSection::GetByID($SECTION_ID);
if ($ar_res = $res->GetNext()) {
    $SECTION_NAME = $ar_res['NAME'];
    $SECTION_CODE = $ar_res['CODE'];
}
$APPLICATION->AddChainItem($SECTION_NAME, "/catalog/" . $SECTION_CODE . "/");


    $result_sql = "SELECT DISTINCT id_series FROM b_filter_house WHERE active = '1' AND category_name = '{$SECTION_NAME}'";
    $resultSQL = $DB->Query($result_sql);
    while ($row = $resultSQL->Fetch()) {
        $result_filter[] = $row['id_series'];
    }
?>




<section class="content filter-wrapper" role="content">
    <div class="container">
        <div class="row catlog-text">
            <div class="col-xs-12 col-md-12 col-sm-12">
                <div class="catalog-description + my-margin + my-padding">
                    <h2 class="filter-block__title">Выберите параметры дома, который нужен Вам</h2>
                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/include/filter.php'; ?>
                    <div class="filter-block__extra-info">
                        <p class="filter-block__extra-info--text">
                            Наши специалисты ответят на Ваши вопросы по телефону
                            <br>
                            +7 (495) 419-14-14 или <a href="#" class="modal-call" data-target="#call" data-toggle="modal"><span class="filter-block__extra-info--text--blue-link">перезвонят Вам через 30 секунд</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
global $APPLICATION;
$page = $APPLICATION->GetCurPage();
$dir = $APPLICATION->GetCurDir();
?>

<section class="content" role="content" id="category_cheked">
    <div class="container">
        <div class="row catlog-text">
            <div class="col-xs-12 col-md-12 col-sm-12">
                <div class="catalog-description + my-margin">


                    <?php if ($dir == '/catalog/malye-stroeniya-besedki/' && !isset($_GET['PAGEN_1'])): ?>
						<?php
							$APPLICATION->SetPageProperty("description", "Строительство различных беседок под ключ по низкой цене с барбекю. Звоните +7 (495) 419-14-14");
							$APPLICATION->SetPageProperty("keywords", "беседки под ключ, строительство беседок, беседка с барбекю");
							$APPLICATION->SetPageProperty("title", "Проекты беседок под ключ недорого с мангалом и барбекю от компании Терем");
							$APPLICATION->SetTitle("");
						?>
                        <h1 class="catalog-titile">Малые строения</h1>
                        <p>
                            Малые архитектурные формы – это деревянные беседки и гараж. Эти строения помогают организовать пространство на участке, чтобы ваши гости и транспорт не зависели от погодных условий. Надежная крыша позволит провести пикник в любую погоду, не беспокоится о сохранности автомобиля. Деревянные беседки от компании «Теремъ» - практичное украшения участка. Чтобы узнать подробности строительства – обращайтесь к менеджерам.
                        </p>
                    <?php endif; ?> 

                    <?php if ($dir == '/catalog/sadovye-doma/' && !isset($_GET['PAGEN_1'])): ?>
						<?php
							$APPLICATION->SetPageProperty("description", "Строительство садовых домов различного размера из бруса и каркаса под ключ недорого. Звоните +7 (495) 419-14-14");
							$APPLICATION->SetPageProperty("keywords", "садовые дома, садовые дома под ключ, садовые дома из бруса");
							$APPLICATION->SetPageProperty("title", "Садовые дома под ключ недорого из бруса и каркаса купить в Москве");
							$APPLICATION->SetTitle("");
						?>
                        <h1 class="catalog-titile text-uppercase">Садовые домики: проекты, цены, сроки</h1>
                        <p>Садовые дома - компактные здания в классическом дачном стиле. Проекты компании «Теремъ» предполагают комфортные условия для проживания 1-4 человек в зависимости от планировки. Одноэтажный садовый домик подходит в качестве главного дачного здания на небольших участках, как дополнительная гостевая постройка или летняя кухня. Звоните, чтобы уточнить подробности строительства садовых домиков на вашем участке.</p>
                    <?php endif; ?>  



                    <?php if ($dir == '/catalog/kottedzhi/' && !isset($_GET['PAGEN_1'])): ?>
						<?php
							$APPLICATION->SetPageProperty("description", "Строительство коттеджей под ключ по готовым проектам для постоянного и сезонного проживания недорого. Звоните +7 (495) 419-14-14");
							$APPLICATION->SetPageProperty("keywords", "строительство коттеджей, коттеджи под ключ, проекты коттеджей");
							$APPLICATION->SetPageProperty("title", "Строительство коттеджей под ключ по готовым проектам с низкой ценой в Москве");
							$APPLICATION->SetTitle("");
						?>
                        <h1 class="catalog-titile ">Оригинальные загородные коттеджи</h1>
                        <p>
                            Каркасные дома под ключ - проекты, которые компания «Теремъ» построит в краткие сроки. В среднем, строительные работы занимают не более двух месяцев, заселяться можно сразу, ведь здание не дает усадку. Деревянные дома от компании «Теремъ» возводятся без привязки к сезону благодаря скорости работ: материалы готовы к монтажу, а сложные узлы собираются под контролем на производстве. Здания, представленные в каталоге, подходят для сезонного и постоянного проживания. 
                        </p>
                    <?php endif; ?>   

                    <?php if ($dir == '/catalog/dachnye-doma/' && !isset($_GET['PAGEN_1'])): ?>
						<?php
							$APPLICATION->SetPageProperty("description", "Строительство дачных домов под ключ по низкой цене от компании Терем. Звоните +7 (495) 419-14-14");
							$APPLICATION->SetPageProperty("keywords", "дачные дома, дачные дома под ключ, дачные дома цены");
							$APPLICATION->SetPageProperty("title", "Проекты дачных домов недорого под ключ от компании Терем");
							$APPLICATION->SetTitle("");
						?>
                        <h1 class="catalog-titile ">Классические дачные дома</h1>
                        <p>Готовые проекты дачных домов от компании «Теремъ» - это надежное жилье на дачный сезон или на весь год. Мастера создают комфорт за пределами города в рамках фиксированного бюджета, без дополнительных трат во время строительства. Подробности о строительстве своего загородного дома вы всегда можете уточнить у менеджеров по телефону или на выставке в Кузьминках.</p>
                    <?php endif; ?>  


                    <?php if ($dir == '/catalog/bani/' && !isset($_GET['PAGEN_1'])): ?>
						<?php
							$APPLICATION->SetPageProperty("description", "Строительство бань из дерева под ключ недорого от компании Терем в Москве. Звоните +7 (495) 419-14-14");
							$APPLICATION->SetPageProperty("keywords", "бани под ключ, баня под ключ, деревянная баня, каркасная баня, брусовая баня");
							$APPLICATION->SetPageProperty("title", "Деревянные бани – строительство под ключ недорого в Москве");
							$APPLICATION->SetTitle("");
						?>
                        <h1 class="catalog-titile ">Деревянные бани – строительство под ключ</h1>
                        <p>Деревянные бани от компании «Теремъ» - продуманные проекты в каркасном и брусовом исполнении. В каталоге представлены бани, которые отличаются по габаритам и планировкам. Компактные – для небольших участков или просторные – с большой зоной отдыха для многочисленной компании. Строительство деревянных бань от «Теремъ» – доступный комфорт загородного отдыха.</p>
                    <?php endif; ?>  
                </div>
            </div>
        </div>
    </div>
</section>




<?php
if (CModule::IncludeModule("iblock")) {

    $areas = array();

    $arSelect = Array("ID", "NAME", "SORT", "DETAIL_PAGE_URL", "PROPERTY_VARIANTS_HOUSE", "PROPERTY_PODPIS", "PROPERTY_FILES", "PROPERTY_SIZER", "PREVIEW_PICTURE", "PROPERTY_PODPIS", "PROPERTY_SORTY");
    $arFilter = Array("IBLOCK_ID" => 13, "ACTIVE" => "Y", Array("ID" => $result_filter));
    $res = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilter, false, Array(), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields[] = $ob->GetFields();
    }




    if (count($arFields) > 0) {
        foreach ($arFields as $k => $item) {
            foreach ($item["PROPERTY_VARIANTS_HOUSE_VALUE"] as $id) {
                $arSelect1 = Array("ID", "NAME", "PROPERTY_TEHNOLOGY_HOUSE", "PROPERTY_PRICE_HOUSE", "PROPERTY_CODE_1C","PROPERTY_SQUARE_ALL_HOUSE");
                $arFilter1 = Array("IBLOCK_ID" => 21, "ID" => $id);
                $res = CIBlockElement::GetList(Array(), $arFilter1, false, Array(), $arSelect1);
                while ($ob = $res->GetNextElement()) {
                    $arFields[$k]['OPT'][] = $ob->GetFields();
                    $arFields[$k]['SQ'][] = $ob->GetFields()["PROPERTY_SQUARE_ALL_HOUSE_VALUE"];



                }
            }
        }

        foreach ($arFields as $k => $item) {
            foreach ($item["OPT"] as $i => $value) {
                if ($value["PROPERTY_PRICE_HOUSE_VALUE"]) {
                    $arSelect2 = Array("ID", "NAME", "PROPERTY_PRICE_1","PROPERTY_PRICE_2", "PROPERTY_OPTIMAL_PRICE");
                    $arFilter2 = Array("IBLOCK_ID" => 22, "ID" => $value["PROPERTY_PRICE_HOUSE_VALUE"]);
                    $res = CIBlockElement::GetList(Array(), $arFilter2, false, Array(), $arSelect2);
                    while ($ob = $res->GetNextElement()) {
                        $arFields[$k]['OPT'][$i]['PRICE'] = $ob->GetFields();
                    }
                }
            }
        }
    }
}

//echo "<pre>";
//var_dump(max($arFields[0]['SQ']));

?>

<section class="content" role="">
    <div class="container">
        <div class="flex-reversed" id="ajax-catalog">
           
                <?php if (count($arFields) > 0): ?>

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
                                                <a href="#" class="advice" data-target="#formAdvice" data-code="<?= $CODE_1C ?>" data-price="<?= $item['OPT'][0]["PRICE"]["PROPERTY_PRICE_1_VALUE"] ?>000" data-house="<?= $item["NAME"] ?> <?= $item["PROPERTIES"]['SIZER']['VALUE'] ?>" data-toggle="modal"><i class="glyphicon glyphicon-earphone"></i></a>
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


<section class="content" role="content">
    <div class="container">
        <div class="row catlog-text">
            <div class="col-xs-12 col-md-12 col-sm-12">
                <div class="catalog-description + my-margin bottom-text">
                    <?php if ($dir == '/catalog/malye-stroeniya-besedki/' && !isset($_GET['PAGEN_1'])): ?>
                        <h2 class="catalog-titile">Советы будущему владельцу деревянной беседки</h2>
                        <p>На большинстве дачных участков устанавливаются классические деревянные беседки – открытые и визуально просторные. Можно разделить готовые проекты на обычные беседки и беседки-барбекю. Первые представляют собой простое крытое пространство для отдыха, вторые – дополнительно оборудованы местом для барбекю для пикника.</p>
                        <p>Определитесь с местом на участке. В беседке 3х3 запросто можно поставить стол и посадочные места для компании в 5-7 человек. Если площадь участка позволяет и есть желание обустроить пространства для досуга большего числа гостей, то стоит выбрать беседку-барбекю 6х4, в которой предусмотрена зона для жаровни.  </p>
                        <h3 class="catalog-titile">Советы будущему владельцу деревянной беседки</h3>
                        <p>Уютная беседка создает дополнительный комфорт во время дачного сезона. Это дополнительное пространство, которое подходит в равной степени для встреч гостей и для семейных обедов на свежем воздухе. Беседка с каркасными стенами строится в течение недели, компактно располагается на территории. Постройка украшает участок, ведь классический стиль архитектуры универсально сочетается с жилым домом.</p>
                    <?php endif; ?> 

                    <?php if ($dir == '/catalog/sadovye-doma/' && !isset($_GET['PAGEN_1'])): ?>
                        <h2 class="catalog-titile text-uppercase">Особенности конструкции в недорогих садовых домах</h2>
                        <p>Каждый проект садового дома компании «Теремъ» обеспечивает жильцам комфорт на протяжении дачного сезона. Несмотря на различия планировки в разных ценовых вариантах, в помещении достаточно места для всего необходимого во время отдыха. В садовых домиках окна расположены продуманно, чтобы помещение легко проветривалось, не застаивался воздух. Аромат натуральной древесины добавит свежести в особо жаркие дни.</p>
                        <p>Здание строится быстро: строительство садового дома укладывается в 1 неделю, по завершению можно заселяться. Каркасная технология не предполагает усадки, а при строительстве из клееного бруса оставляются специальные зазоры с уплотнителем, чтобы усадка проходила по заранее определенному сценарию, без деформации элементов конструкции.</p>
                        <h2 class="catalog-titile text-uppercase">5 причин построить садовый дом с компанией «Теремъ»</h2>
                        <p>Главное преимущество садового домика – компактное размещение на участке. Небольшие размеры постройки гармонично сочетаются со всем архитектурным ансамблем территории. Если вы хотите хороший дом при скромном бюджете – заказывайте проекты садовых домиков в компании «Теремъ».</p>
                        <p>Компанию «Теремъ» выбирают потому, что здесь:</p>
                        <ul class="seo-list">
                            <li>1.Оптимальная стоимость каждого дома.</li>
                            <li>2.Фиксированная цена на весь период строительства.</li>
                            <li>3.Продуманные строительные проекты, которые представлены на выставке.</li>
                            <li>4.Результат соответствует вашим ожиданиям по срокам и качеству.</li>
                            <li>5.Гарантия на каждую постройку до 10 лет.</li>
                        </ul>
                        <p>Уточняйте подробности строительства садовых домиков под ключ у менеджеров компании «Теремъ».</p>
                    <?php endif; ?>  


                    <?php if ($dir == '/catalog/kottedzhi/' && !isset($_GET['PAGEN_1'])): ?>
                        <h2 class="catalog-titile ">Преимущества коттеджей от компании «Теремъ»</h2>
                        <p>
                            Технологии производства и строительства в компании «Теремъ» позволяют заказать каркасный дом высокой надежности, который прослужит долго. В каталоге предлагается более 70 готовых проектов, среди которых всегда найдется подходящий вариант под личные предпочтения каждого клиента. Не нашли подходящего варианта? Строительная компания «Теремъ» поможет построить дом Вашей мечты по индивидуальным критериям. 
                        </p>
                        <p>Преимущества коттеджей от компании «Теремъ»:</p>
                        <ul class="seo-list">
                            <li>полная автономность строительства</li>
                            <li>продуманные проекты и грамотные планировки</li>
                            <li>надежность с гарантией до 10 лет</li>
                        </ul>
                        <p>Звоните, менеджеры компании «Теремъ» с радостью ответят на все вопросы о строительстве загородных коттеджей!</p>
                    <?php endif; ?>  



                    <?php if ($dir == '/catalog/dachnye-doma/' && !isset($_GET['PAGEN_1'])): ?>
                        <h2 class="catalog-titile ">Преимущества дачных домов от компании «Теремъ»</h2>
                        <p>В каталоге компании представлены готовые проекты дачных домов. Разработка зданий основывалась на потребностях и пожеланиях реальных людей. Каждый клиент найдет дом, который подходит под его персональные предпочтения.</p>
                        <p>Преимущества дачных домов:</p>
                        <ul class="seo-list">
                            <li>легкий вес конструкции = быстрое возведение фундамента</li>
                            <li>экологически чистый материал = свежий воздух в помещении</li>
                            <li>отлаженная технология строительства = краткие сроки работ</li>
                        </ul>
                        <h2 class="catalog-titile ">5 причин выбрать двухэтажные дома из бруса в компании «Теремъ»</h2>
                        <ul class="seo-list">
                            <li>1.Предлагаем готовые дома и проектируем под персональные запросы.</li>
                            <li>2.Оплата фиксируется и не меняется в ходе работ.</li>
                            <li>3.Пиломатериалы подготавливаются в заводских условиях, а не на участке.</li>
                            <li>4.Строим под ключ, подводим коммуникации, проводим сопутствующие работы.</li>
                            <li>5.Гарантия качества до 10 лет на деревянные дома, до 20 лет на кирпичные.</li>
                        </ul>
                        <p>Чтобы уточнить подробности о строительстве понравившегося дачного дома – звоните, менеджеры компании «Теремъ» предоставят полную информацию о каждом проекте!</p>
                    <?php endif; ?>


                    <?php if ($dir == '/catalog/bani/' && !isset($_GET['PAGEN_1'])): ?>
                        <h2 class="catalog-titile ">Критерии качества при строительстве деревянной бани</h2>
                        <p>Брусовые бани от «Теремъ» строим из клеёного бруса – прочного и долговечного строительного материала. Его изготавливают из тонких досок (ламелей) хвойной древесины, которые соединяются клеящим составом на основе натуральной древесной смолы. Бани из бруса отлично держат тепло: в материале выпилены шип и паз, чтобы в межвенцовых стыках образовывался плотный ветровой замок.</p>
                        <p>Каркасные бани строим по канадской технологии – создаем «эффект термоса», что позволяет существенно сократить расходы на отопление. Секрет долговечности заключается в правильно оборудованной пароизоляции в стенах – внутри не образуется конденсат. Стены отделываются вагонкой из хвойных пород, а в парной – из осины, которая устойчива к влаге и перепадам температур.</p>
                        <p>Плюсы деревянной бани:</p>
                        <ul class="seo-list">
                            <li>кратчайшие сроки строительства – от 5 до 18 дней в зависимости от проекта;</li>
                            <li>независимость от погоды и времени года;</li>
                            <li>можно сразу приступать к внутренней отделке.</li>
                        </ul>
                        <p>Если среди готовых проектов бань не нашлось подходящего, архитекторы «Теремъ» внесут изменения или разработают новый проект по индивидуальным предпочтениям. </p>

                        <h2 class="catalog-titile ">Деревянные бани под ключ от компании «Теремъ»</h2>
                        <p>Деревянная баня – надежное и экологичное здание, которое строители могут подготовить под ключ.  Задача «Теремъ» не просто построить баню недорого и быстро, но и обеспечить уровень комфорта, необходимый клиенту.</p>
                        <p>Баня под ключ – это готовый комплекс условий:</p>
                        <ul class="seo-list">
                            <li>теплое и надежное здание;</li>
                            <li>внутренняя и внешняя отделка;</li>
                            <li>полный комплект инженерных коммуникаций.</li>
                        </ul>
                        <p>Все подробности о строительстве бани, действующих скидках и текущих акциях утоняйте по телефону или у менеджеров на выставке в Кузьминках!</p>
                    <?php endif; ?> 
                </div>
            </div>
        </div>
    </div>
</section>