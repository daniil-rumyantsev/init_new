<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
$this->setFrameMode(false);
?>


<section class="content filter-wrapper" role="content">
    <div class="container">
        <div class="row catlog-text">
            <div class="col-xs-12 col-md-12 col-sm-12">
                <div class="catalog-description + my-margin + my-padding">
                     <h2 class="filter-block__title">Выберите параметры дома, который нужен Вам</h2>
                        <?php include $_SERVER['DOCUMENT_ROOT'].'/include/filter.php'; ?>
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
<div id="ajax-catalog">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/include/ajax_catalog.php'; ?>
     
</div>


