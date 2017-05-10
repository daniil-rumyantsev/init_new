<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
$this->setFrameMode(true);
?>
<section class="content" role="content">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-sm-12" id="category">
                <div class="flex-reversed">


                    <?php $cnt = 0; ?>
                    <?php foreach ($arResult["SECTIONS"] as $k => $arSection): ?>
                        <?php if ($arSection['ID'] != '29123'): ?>

                            <?php if ($cnt == 0): ?>
                                <div class="row">
                            <?php endif; ?>

                            <div class="col-xs-12 col-md-6 col-sm-12">
                                <div class="my-promotion desgin-3 + my-margin">
                                    <div>
                                        <a href="<?= $arSection["SECTION_PAGE_URL"] ?>">
                                            <img src="<?= $arSection['PICTURE']['SRC'] ?>"
                                                 alt="<?= $arSection['NAME'] ?>">
                                        </a>
                                    </div>
                                    <div>
                                        <h4 class="text-uppercase">
                                            <?= $arSection['NAME'] ?>
                                        </h4>
                                        <p>
                                            <?= $arSection['DESCRIPTION'] ?>
                                        </p>
                                    </div>
                                    <a class="all-item-link" href="<?= $arSection["SECTION_PAGE_URL"] ?>"></a>
                                </div>
                            </div>
                            <?php $cnt++; ?>
                            <?php if ($cnt == 2): ?>
                                </div>
                                <?php $cnt = 0; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php $arLongItem = $k; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>


                    <!-- START LONG -->
                    <div class="row"></div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-sm-12">
                            <div class="my-promotion ( desgin-2 && one-column ) + my-margin">
                                <div>
                                    <a href="<?= $arResult["SECTIONS"][$arLongItem]['SECTION_PAGE_URL'] ?>">
                                        <img src="<?= $arResult["SECTIONS"][$arLongItem]['PICTURE']['SRC'] ?>"
                                             alt="<?= $arResult["SECTIONS"][$arLongItem]['NAME'] ?>">
                                    </a>
                                </div>
                                <div>
                                    <h4 class="text-uppercase">
                                        <a href="<?= $arResult["SECTIONS"][$arLongItem]['SECTION_PAGE_URL'] ?>"
                                           class="text-uppercase">
                                            <?= $arResult["SECTIONS"][$arLongItem]['NAME'] ?>
                                        </a>
                                    </h4>
                                    <p>
                                        <?= $arResult["SECTIONS"][$arLongItem]['DESCRIPTION'] ?>
                                    </p>
                                </div>
                                <a class="all-item-link"
                                   href="<?= $arResult["SECTIONS"][$arLongItem]['SECTION_PAGE_URL'] ?>"></a>
                            </div>
                        </div>
                    </div>
                    <!-- END LONG -->

                </div>
            </div>

        </div>

        <div class="row catlog-text">
            <div class="col-xs-12 col-md-12 col-sm-12">
                <div class="catalog-description + my-margin bottom-text">
                    <h1 class="catalog-titile">Теремъ: деревянные дома</h1>
                    <p>
                        Строительная компания «Теремъ» - один из лидеров рынка загородного домостроения. Мы занимаемся
                        проектированием, производством и строительством домов из бруса, каркасных домов и кирпичных
                        строений
                        с учетом русских традиций домостроения и применения новейших технологий.
                    </p>
                    <p>«Теремъ» строит быстро и качественно. Благодаря прорыву современных технологий, строительный
                        процесс
                        больше не затягивается на долгие годы. Деревянные дома строятся из современных материалов,
                        сделанных
                        на собственном производстве из экологически чистой, качественной древесины.</p>
                    <p>Мы предлагаем большой выбор проектов деревянных домов. Дом в Тереме - это оптимальная
                        комплектация,
                        продуманная планировка, современный внешний вид строения, а так же фиксированная стоимость, что
                        немаловажно при заказе полноценного проекта под ключ.</p>
                    <p>Индивидуальный подход к каждому клиенту – это наш принцип. Архитекторы компании спроектируют
                        деревянные дома согласно Вашим желаниям и потребностям, внесут изменения в типовой проект,
                        предложат
                        идеальное комплексное решение.</p>

                    <p>«Теремъ» так же готов предоставить полный комплекс услуг для загородной жизни:
                    <ul>
                        <li>
                            Необходимые инженерные коммуникации для дома: электрика, отопление, септики, водоподъем
                        </li>
                        <li>
                            Реконструкция, достройка или ремонт существующих строений
                        </li>
                        <li>
                            Благоустройство участка, ландшафтный дизайн
                        </li>
                        <li>
                            Ограждение участка – заборы из евроштакетника, профнастила, сетки-рабицы
                        </li>
                        <li>
                            Пристройка террас и веранд к существующим строениям
                        </li>
                    </ul>
                    </p>
                    <p>Для удобства покупателей мы предоставляем услуги по оформлению кредитов и страховых
                        полисов.</p>
                    <p>В нашей компании внимание уделяется каждому покупателю. Нам важен хороший результат, для его
                        достижения мы внимательно отслеживаем все этапы строительства, занимаемся гарантийным
                        обслуживанием
                        домов после сдачи объектов.</p>
                    <p>Компания «Теремъ» следует простому принципу: делать все четко и последовательно. Таким образом мы
                        обеспечиваем нашему потребителю качество при доступной цене.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-3 col-sm-3">
                <a href="/services/dostroika/" class="my-block-link my-margin">
                    <img src="/bitrix/templates/.default/assets/img/catalog-item/1-1.png" alt="Ремонт и реконструкция">
                 </a>
            </div>
            <div class="col-xs-12 col-md-3 col-sm-3">
                <a href="/services/individual_projects/" class="my-block-link my-margin">
                    <img src="/bitrix/templates/.default/assets/img/catalog-item/2-1.png" alt="Индивидуальные проекты">
                 </a>
            </div>
            <div class="col-xs-12 col-md-3 col-sm-3">
                <a href="http://zemli.terem-pro.ru/" class="my-block-link my-margin">
                    <img src="/bitrix/templates/.default/assets/img/catalog-item/3-1.png" alt="Продажа земли в поселках">
                 </a>
            </div>
            <div class="col-xs-12 col-md-3 col-sm-3">
                <a href="/services/enginering_communications/" class="my-block-link my-margin">
                    <img src="/bitrix/templates/.default/assets/img/catalog-item/4-1.png" alt="Инженерные системы">
                 </a>
            </div>
        </div>


    </div>


</section>