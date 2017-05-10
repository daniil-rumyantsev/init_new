'use strict';

var initialUrl = getClearURL(window.location.href);

var resultData = {
    category_check: '',
    series_check: '',
    realmodel: '',
    floor_check: '',
    tech_check: '',
    max_area: 0,
    min_area: 0,
    max_price: 0,
    min_price: 0,
    min_width: 0,
    min_length: 0,
    ajax: '',
    input: 0,
    inputID: ''
};
$(document).ready(function () {
	
	var cat = getParameterByName("category");
	var ser = getParameterByName("series");
	var floor = getParameterByName("house-floors");
	var tech = getParameterByName("house-tech");
	var max_area = getParameterByName("max-area");
	var min_area = getParameterByName("min-area");
	var max_price = getParameterByName("max-price");
	var min_price = getParameterByName("min-price");
	var min_width = getParameterByName("min-width");
	var min_length = getParameterByName("min-length");
	
	

	resultData.category_check = cat;
	resultData.series_check = ser;
	resultData.floor_check = floor;
	resultData.tech_check = tech;
	if (max_area) resultData.max_area = max_area;
	if (min_area) resultData.min_area = min_area;
	if (max_price) resultData.max_price = max_price;
	if (min_price) resultData.min_price = min_price;
	if (min_width) resultData.min_width = min_width;
	if (min_length) resultData.min_length = min_length;
	
	//resultData!!!!
	//console.log(resultData);
	
	if (cat||ser||floor||tech||max_area||min_area||max_price||min_price||min_width||min_length) filter();
    //document.referrer
    //alert(window.location.href);
    //alert(document.referrer);
    
	//alert(window.location);
    $('.price-link-page').on('click',function(){

        return true;

    });


    var hintState = false;

    $('.house__filter').on('click', '.dropdown', function (e) {
        var targetBtn = $(this).children('.my-btn-filter');
        var class_cross = $(targetBtn).attr('id');
        if ($(targetBtn).data('checked') == 'true') {
            $('#' + class_cross + '_cross').show();
        }
    });

    $('#filter_refresh').on('click', function () {
        window.location = initialUrl;
        return false;
    });

    $('.house__filter').on('click', '.my-cross', function () {
        var class_cross = $(this).data('parent');
        var start_text = $('#' + class_cross).data('placeholder');
        var chosenOptionsBlock = $('.b-chosen-options');
        console.log(class_cross);
        $('#' + class_cross).data('checked', false);
        $('#' + class_cross + '_cross').hide();
        $('#' + class_cross + '_span').hide();
        $('#' + class_cross).html(start_text + '<span class="my-caret"></span>').removeClass('my-btn-filter--highlighted');

        constructorBtn();

        if (class_cross == 'categoryDropdown') {
            $('#category').val('');
            resultData.category_check = '';
            filter();
        }
        if (class_cross == 'seriesDropdown') {
            $('#modalinpt').val('');
            resultData.series_check = '';
            filter();
        }
        if (class_cross == 'house-floorsDropdown') {
            $('#floors').val('');
            resultData.floor_check = '';
            filter();
        }
        if (class_cross == 'house-techDropdown') {
            $('#tech').val('');
            resultData.tech_check = '';
            filter();
        }
        if (class_cross == 'house-priceDropdown') {
            $('#house-price-from').val('');
            $('#house-price-up-to').val('');
            resultData.min_price = 0;
            resultData.max_price = 0;
            rangePrice.textFrom = '';
            rangePrice.textTo = '';
            filter();
        }
        if (class_cross == 'house-sizeDropdown') {
            $('#house-width-from').val('');
            $('#house-length-from').val('');
            resultData.min_width = 0;
            resultData.min_length = 0;
            rangeSize.textFrom = '';
            rangeSize.textTo = '';
            filter();
        }
        if (class_cross == 'house-areaDropdown') {
            $('#house-area-from').val('');
            $('#house-area-up-to').val('');
            resultData.min_area = 0;
            resultData.max_area = 0;
            rangeArea.textFrom = '';
            rangeArea.textTo = '';
            filter();
        }
    });

    //action click filter start
    $('.house__filter').on('click', 'li', function (e) {

        e.preventDefault();
        var target = e.target || window.target;
        var targetLi = $(target).parent();
        var val = $(target).html();
        var filterBtn = $(this).parent().prev();
        var filterBtnID = $(filterBtn).attr('id');
        var chosenOptionsBlock = $('.b-chosen-options');
        var refreshBtn = $('.b-reset-button');
        var variantsCount = $('#variants-count');

        targetLi.addClass('active');
        targetLi.siblings().removeClass('active');
        filterBtn.html(val).addClass('my-btn-filter--highlighted').siblings('#' + filterBtnID).val(val);
        $(filterBtn).data('checked', 'true');
        if (hintState == false) {
            $('.hint-bubble').show();
            hintState = true;
        }
        if ($(this).hasClass('series-filter-li')) {
            var idx = $(this).data('key');
            var val = $(this).data('id');

            $('#realmodel').val(idx);
            $('#modalinpt').val(val);
            resultData.series_check = val;
            resultData.realmodel = idx;
        }

        if ($(this).hasClass('category-li-filter')) {
            var val = $(this).data('id');
            $('#category').attr('val', val);
            $('#category').val(val);
            resultData.category_check = val;
        }

        if ($(this).hasClass('floor-dilter-li')) {
            var val = $(this).data('id');
            $('#floors').val(val);
            resultData.floor_check = val;
        }

        if (!$(this).hasClass('filter-tech-li')) {} else {
            var val = $(this).data('id');
            $('#tech').val(val);
            resultData.tech_check = val;
        }

        if (filterBtnID == 'house-floorsDropdown') {
            $('#' + filterBtnID + '_span').html('\n                            ' + val + ' ' + declension(val, [' этаж', ' этажа', ' этажей']) + ' <span class="my-cross my-cross--b-chosen-option" data-parent="' + filterBtnID + '"></span>,\n\n                        ');
        } else {
            $('#' + filterBtnID + '_span').html('\n                            ' + val + ' <span class="my-cross my-cross--b-chosen-option" data-parent="' + filterBtnID + '"></span>,\n\n                        ');
        }

        $('#' + filterBtnID + '_span').show();

        chosenOptionsBlock.show();
        refreshBtn.show();
        filter();
    });
    var rangePrice = {
        textFrom: 'от',
        textTo: 'до',
        text: ''
    };
    var rangeSize = {
        textFrom: '',
        textTo: 'x',
        text: ''
    };
    var rangeArea = {
        textFrom: 'от',
        textTo: 'до',
        text: ''
    };

    var initialBtnName = '';
    $('.dropdown-toggle').on(function (e) {
        initialBtnName = '';
        var target = e.target || window.target;
        initialBtnName = $(target).text();
    });

    $('.range-box input').click(function (e) {
        e.stopPropagation();
    });

    $('.range-box').on('click', '.enter-icon', function (e) {
        var __this = this;
        inputHandler($(__this).prev('input'));
    });

    $('.range-box').on('keyup', 'input', function (e) {
        var __this = this;
        var input = $(__this).val();
        var inputID = $(__this).attr('id');

        if (e.keyCode == 13) {
            if (resultData.input != input && resultData.inputID == inputID) {
                resultData.input = $(__this).val();
                resultData.inputID = $(__this).attr('id');

                inputHandler(__this);
            } else if (resultData.inputID != inputID) {
                resultData.input = $(__this).val();
                resultData.inputID = $(__this).attr('id');

                inputHandler(__this);
            }
        }
        if (e.keyCode == 8 || e.keyCode == 46) {
            resultData.input = 0;
            resultData.inputID = '';
        }
    });

    function inputHandler(__this) {

        var target = $(__this);
        var initialBtnName = $(target).text();
        var idTarget = $(target).attr('id').split('-');
        var val = $(target).val();
        $(target).attr('data-val', parseInt(val));
        var filterBtn = $(__this).closest('.dropdown').find('.my-btn-filter');
        var filterBtnID = $(filterBtn).attr('id');
        var valTarget = parseInt($(target).val());
        var name = $(__this).attr('name');
        var chosenOptionsBlock = $('.b-chosen-options');
        var refreshBtn = $('.b-reset-button');
        // if (hintState == false) {
        //     $('.hint-bubble').show();
        //     hintState = true;
        // }

        if (name == 'house-areaFrom' || name == 'house-areaUpto') {
            if (parseInt(val)) {
                if (idTarget[2] == 'from') {
                    rangeArea.textFrom = textCombinate('from', valTarget);
                } else {
                    rangeArea.textTo = textCombinate('up', valTarget);
                }

                var textInputArea = '';
                if (rangeArea.textFrom != 'от') {
                    textInputArea += rangeArea.textFrom;
                }
                if (rangeArea.textTo != 'до') {
                    textInputArea += rangeArea.textTo;
                }
                if (!isNaN(rangeArea.from) && rangeArea.from) {
                    rangeArea.textAll += ' ' + rangeArea.textTo + ' ' + rangeArea.textFrom;
                }
            }
        } else {

            if (name == 'house-widthFrom' || name == 'house-lengthFrom') {

                if (parseInt(val)) {
                    if (name == 'house-widthFrom') {
                        rangeSize.textFrom = textCombinate2('from', valTarget);
                    } else {
                        rangeSize.textTo = textCombinate2('up', valTarget);
                    }
                    var textInputSize = '';
                    if (rangeSize.textFrom != '') {
                        textInputSize += rangeSize.textFrom;
                    }
                    if (rangeSize.textTo != 'x') {
                        textInputSize += rangeSize.textTo;
                    }
                    if (!isNaN(rangeSize.from) && rangeSize.from) {
                        rangeSize.textAll += ' ' + rangeSize.textTo + ' ' + rangeSize.textFrom;
                    }
                    $('#' + filterBtnID + '_cross').show();
                    $('#' + filterBtnID + '_span').show();
                }
            } else {
                if (parseInt(val)) {
                    if (idTarget[2] == 'from') {
                        rangePrice.textFrom = textCombinate('from', valTarget);
                    } else {
                        rangePrice.textTo = textCombinate('up', valTarget);
                    }
                    var textInputPrice = '';
                    if (rangePrice.textFrom != 'от') {
                        textInputPrice += rangePrice.textFrom;
                    }
                    if (rangePrice.textTo != 'до') {
                        textInputPrice += rangePrice.textTo;
                    }
                    if (!isNaN(rangePrice.from) && rangePrice.from) {
                        rangePrice.textAll += ' ' + rangePrice.textTo + ' ' + rangePrice.textFrom;
                    }

                    $('#' + filterBtnID + '_cross').show();
                    $('#' + filterBtnID + '_span').show();
                }
            }
        }

        var pmin = parseInt($('#house-price-from').val());

        var wmin = parseInt($('#house-width-from').val());
        var lmin = parseInt($('#house-length-from').val());

        var pmax = parseInt($('#house-price-up-to').val());
        var amin = parseInt($('#house-area-from').val());
        var amax = parseInt($('#house-area-up-to').val());
        var btnprice = $('#house-priceDropdown');
        var btnarea = $('#house-areaDropdown');
        var btnsize = $('#house-sizeDropdown');

        //('!!!!',wmin,lmin);


        if (isNaN(wmin) && isNaN(lmin)) {
            if ($('#' + filterBtnID + '_span').attr('id') == 'house-sizeDropdown_span') {
                $('#' + filterBtnID + '_span').hide();
            }
            $('#house-sizeDropdown').html('Размер<span class="my-caret"></span>');
            $('#house-sizeDropdown').removeClass('my-btn-filter--highlighted');
            $(filterBtn).siblings('.my-cross').hide();
            btnprice.html(btnprice.data("placeholder") + ' <span class="my-caret"></span>');
            resultData.min_width = 0;
            resultData.min_length = 0;
        } else {
            if (isNaN(wmin)) {
                resultData.min_width = 0;
            } else {
                //console.log('22',wmin);
                btnsize.html(textInputSize).addClass('my-btn-filter--highlighted');
                $('#' + filterBtnID + '_cross').show();
                $('#' + filterBtnID + '_span').show();
                var min_width = wmin; //parseInt($('#house-width-from').attr('data-val'))
                resultData.min_width = min_width;
                //console.log('3',resultData.min_width);
            }

            if (isNaN(lmin)) {
                resultData.min_length = 0;
            } else {
                btnsize.html(textInputSize).addClass('my-btn-filter--highlighted');
                $('#' + filterBtnID + '_cross').show();
                $('#' + filterBtnID + '_span').show();
                var min_length = parseInt($('#house-length-from').attr('data-val'));
                resultData.min_length = min_length;
            }
        }

        if (isNaN(pmin) && isNaN(pmax)) {
            if ($('#' + filterBtnID + '_span').attr('id') == 'house-priceDropdown_span') {
                $('#' + filterBtnID + '_span').hide();
            }
            $(filterBtn).siblings('.my-cross').hide();
            btnprice.html(btnprice.data("placeholder") + ' <span class="my-caret"></span>');
            resultData.max_price = 0;
            resultData.min_price = 0;
        } else {
            if (isNaN(pmin)) {
                resultData.min_price = 0;
            } else {
                btnprice.html(textInputPrice).addClass('my-btn-filter--highlighted');
                $('#' + filterBtnID + '_cross').show();
                $('#' + filterBtnID + '_span').show();
                var min_price = parseInt($('#house-price-from').attr('data-val'));
                resultData.min_price = min_price;
            }
            if (isNaN(pmax)) {
                resultData.max_price = 0;
            } else {

                btnprice.html(textInputPrice).addClass('my-btn-filter--highlighted');
                $('#' + filterBtnID + '_cross').show();
                $('#' + filterBtnID + '_span').show();
                var max_price = parseInt($('#house-price-up-to').attr('data-val'));
                resultData.max_price = max_price;
            }
        }

        if (isNaN(amin) && isNaN(amax)) {

            if ($('#' + filterBtnID + '_span').attr('id') == 'house-areaDropdown_span') {
                $('#' + filterBtnID + '_span').hide();
            }
            $(filterBtn).siblings('.my-cross').hide();
            btnarea.html(btnarea.data("placeholder") + ' <span class="my-caret"></span>');
            resultData.min_area = 0;
            resultData.max_area = 0;
        } else {

            if (isNaN(amin)) {
                resultData.min_area = 0;
            } else {
                btnarea.html(textInputArea).addClass('my-btn-filter--highlighted');
                $('#' + filterBtnID + '_cross').show();
                $('#' + filterBtnID + '_span').show();

                var min_area = parseInt($('#house-area-from').attr('data-val'));

                resultData.min_area = min_area;
            }
            if (isNaN(amax)) {
                resultData.max_area = 0;
            } else {
                btnarea.html(textInputArea).addClass('my-btn-filter--highlighted');
                $('#' + filterBtnID + '_cross').show();
                $('#' + filterBtnID + '_span').show();

                var max_area = parseInt($('#house-area-up-to').attr('data-val'));

                resultData.max_area = max_area;
            }
        }

        if (filterBtnID == 'house-priceDropdown') {
            $('#' + filterBtnID + '_span').html('\n                            ' + textInputPrice + ' \u0442\u044B\u0441.\u0440. <span class="my-cross my-cross--b-chosen-option ' + filterBtnID + '" data-parent="' + filterBtnID + '"></span>\n\n                        ');
        }

        if (filterBtnID == 'house-areaDropdown') {
            $('#' + filterBtnID + '_span').html('\n                            ' + textInputArea + ' \u043A\u0432.\u043C <span class="my-cross my-cross--b-chosen-option ' + filterBtnID + '" data-parent="' + filterBtnID + '"></span>\n\n                        ');
        }

        if (filterBtnID == 'house-sizeDropdown') {
            $('#' + filterBtnID + '_span').html('\n                            ' + textInputSize + ' м <span class="my-cross my-cross--b-chosen-option ' + filterBtnID + '" data-parent="' + filterBtnID + '"></span>\n\n                        ');
        }

        chosenOptionsBlock.show();
        refreshBtn.show();
        filter();
    }

    function constructorBtn() {
        var name = $('#categoryDropdown').data('placeholder');
        if (name != 'Категория дома') {
            resultData.category_check = name;
        }
    }

    function textCombinate(idx, vals) {
        var result = false;
        if (idx == 'from') {
            var Text = 'от';
        }
        if (idx == 'up') {
            var Text = ' до';
        }
        if (!isNaN(vals) && vals && vals != 0) {
            result = Text;
            result += ' ' + vals;
        } else {
            result = '';
        }
        return result;
    };

    function textCombinate2(idx, vals) {
        var result = false;
        if (idx == 'from') {
            var Text = '';
        }
        if (idx == 'up') {
            var Text = ' x';
        }
        if (!isNaN(vals) && vals && vals != 0) {
            result = Text;
            result += ' ' + vals;
        } else {
            result = '';
        }

        //console.log('textcomb', result);
        //console.log('textcomb', idx);
        //console.log('textcomb', vals);
        return result;
    };
    //action click filter end


    //filter();
});

function filter() {
	
	var url = initialUrl;
    var chosenOptionsBlock = $('.b-chosen-options');
    var refreshBtn = $('.b-reset-button');
    var variantsCount = $('#variants-count');

    if (resultData.category_check == '' && resultData.series_check == '' && resultData.floor_check == '' && resultData.tech_check == '' && resultData.max_area == 0 && resultData.min_area == 0 && resultData.max_price == 0 && resultData.min_price == 0 && resultData.min_width == 0 && resultData.min_length == 0) {
        chosenOptionsBlock.hide();
        refreshBtn.hide();
        // return;
    }

    var categories = resultData.category_check;
    var series = resultData.series_check;
    var floors = resultData.floor_check;
    var tehnologies = resultData.tech_check;
    var validate = $('#valit').val();
	var category_cheked = $('#category_cheked').length;
	var needAmp = false;
	
	
	
	if (categories && !category_cheked) 
	{
		url += (needAmp ? '&' : '?') + 'category='+categories;
		needAmp = true;
	}
	if (series) 
	{
		url += (needAmp ? '&' : '?') + 'series='+series;
		needAmp = true;
	}
	if (floors) 
	{
		url += (needAmp ? '&' : '?') + 'house-floors='+floors;
		needAmp = true;
	}
	if (tehnologies) 
	{
		url += (needAmp ? '&' : '?') + 'house-tech='+tehnologies;
		needAmp = true;
	}
	if (resultData.max_area)
	{
		url += (needAmp ? '&' : '?') + 'max-area='+resultData.max_area;
		needAmp = true;
	}
	if (resultData.min_area)
	{
		url += (needAmp ? '&' : '?') + 'min-area='+resultData.min_area;
		needAmp = true;
	}
	if (resultData.max_price)
	{
		url += (needAmp ? '&' : '?') + 'max-price='+resultData.max_price;
		needAmp = true;
	}
	if (resultData.min_price)
	{
		url += (needAmp ? '&' : '?') + 'min-price='+resultData.min_price;
		needAmp = true;
	}
	if (resultData.min_width)
	{
		url += (needAmp ? '&' : '?') + 'min-width='+resultData.min_width;
		needAmp = true;
	}
	if (resultData.min_length)
	{
		url += (needAmp ? '&' : '?') + 'min-length='+resultData.min_length;
		needAmp = true;
	}
	

    //console.log(resultData.min_width,resultData.min_length);
    //console.log(resultData.postajax);


    console.log(resultData);

	window.history.pushState(null, null, url);
	
	

    $.ajax('/include/filter_search.php', {
        method: 'GET',
        async: false,
        data: {
            categories: resultData.category_check,
            series: resultData.series_check,
            realmodel: resultData.realmodel,
            floors: resultData.floor_check,
            tehnologies: resultData.tech_check,
            max_area: resultData.max_area,
            min_area: resultData.min_area,
            max_price: resultData.max_price,
            min_price: resultData.min_price,
            min_width: resultData.min_width,
            min_length: resultData.min_length,
            valid: validate
        },
        success: function success(data) {
            var resultDataFilter = [];
            resultDataFilter = JSON.parse(data);

            //console.log(resultDataFilter);

            if (resultDataFilter.length > 0) {
                renderFilter(resultDataFilter);
            }

            renderResult(resultDataFilter);
            var resultCount = renderResult(resultDataFilter).length;
            var chosenOptionsBlock = $('.b-chosen-options');
            if (parseInt(resultCount) > 0) {
                $('.error-msg').hide();
                $(variantsCount).html(resultCount + ' ' + declension(resultCount, [' вариант', ' варианта', ' вариантов']));
                chosenOptionsBlock.show();
            } else {
                $('.error-msg').show();
            }
        }
    });
}

function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
}

function renderResult(obj) {
    var seriesArr = [];

    for (var idSeries in obj) {
        seriesArr.push(obj[idSeries].id_series);
    }

    var uniqueID = seriesArr.filter(onlyUnique);

    $.ajax('/include/ajax_catalog.php', {
        method: 'GET',
        async: false,
        data: {
            result_filter: uniqueID
        },
        success: function success(data) {
            $('#ajax-catalog').html(data);
        }
    });

    return uniqueID;
}

function renderFilter(finalArr) {
    var listCat = $('.categories-filter');
    var listSeries = $('.series-filter');
    var listFloors = $('.floors-filter');
    var listTech = $('.tehnologies-filter');
    var categories = [];
    var categories_html = '';
    var series = [];
    var series_html = '';
    var floors = [];
    var floors_html = '';
    var tech = [];
    var tech_html = '';
    var areas = [];
    var prices = [];
    var widths = [];
    var lengths = [];
    finalArr.filter(function (obj) {
        if (find(categories, obj.id_category) == -1) {
            categories.push(obj.id_category);
            if (obj.id_category == resultData.category_check) {
                categories_html = categories_html + '<li  class="category-li-filter active" data-id="' + obj.category_name + '"><a href="#" data-name="' + obj.category_name + '" >' + obj.category_name + '</a></li>';
            } else {
                categories_html = categories_html + '<li  class="category-li-filter" data-id="' + obj.category_name + '"><a href="#" data-name="' + obj.category_name + '" >' + obj.category_name + '</a></li>';
            }
        }
        if (find(series, obj.series_name) === -1) {
            series.push(obj.series_name);
            if (obj.series_name == resultData.series_check) {
                series_html = series_html + '<li data-id="' + obj.series_name + '" data-id="' + obj.series_name + '" data-key="' + obj.id_series + '" class="series-filter-li active" ><a href="#" data-name="' + obj.series_name + '" >' + obj.series_name + '</a></li>';
            } else {
                series_html = series_html + '<li data-id="' + obj.series_name + '" data-id="' + obj.series_name + '" data-key="' + obj.id_series + '" class="series-filter-li" ><a href="#" data-name="' + obj.series_name + '" >' + obj.series_name + '</a></li>';
            }
        }

        if (find(floors, obj.floors) === -1) {
            floors.push(obj.floors);
            if (obj.series_name == resultData.floor_check) {
                floors_html = floors_html + '<li data-id="' + obj.floors + '" class="floor-dilter-li active"><a href="#" data-name="' + obj.floors + '" >' + obj.floors + declension(obj.floors, [' этаж', ' этажа', ' этажей']) + ' </a></li>';
            } else {
                floors_html = floors_html + '<li data-id="' + obj.floors + '" class="floor-dilter-li"><a href="#" data-name="' + obj.floors + '" >' + obj.floors + declension(obj.floors, [' этаж', ' этажа', ' этажей']) + ' </a></li>';
            }
        }

        if (find(tech, obj.technology) === -1) {
            tech.push(obj.technology);
            if (obj.technology == resultData.tech_check) {
                tech_html = tech_html + '<li class="filter-tech-li active" data-id="' + obj.technology + '"><a href="#" data-name="' + obj.technology + '" >' + obj.technology + '</a></li>';
            } else {
                tech_html = tech_html + '<li class="filter-tech-li" data-id="' + obj.technology + '"><a href="#" data-name="' + obj.technology + '" >' + obj.technology + '</a></li>';
            }
        }

        if (find(areas, parseInt(obj.total_area)) === -1) {
            areas.push(parseInt(obj.total_area));
        }

        if (find(prices, parseInt(obj.price_value)) === -1) {
            prices.push(parseInt(obj.price_value));
        }

        if (find(widths, parseInt(obj.length)) === -1) {
            widths.push(parseInt(obj.length));
        }

        if (find(lengths, parseInt(obj.width)) === -1) {
            lengths.push(parseInt(obj.width));
        }

        //console.log('arr',lengths);
        //console.log(obj.length);
    });
    var min_area = Math.min.apply(null, areas); //Math.min(...areas);
    var max_area = Math.max.apply(null, areas); //Math.max(...areas);

    //min area set
    $('#house-area-from').attr('data-val', parseInt(min_area));
    $('#house-area-from').attr('placeholder', 'от ' + min_area);

    //max area set
    $('#house-area-up-to').attr('data-val', parseInt(max_area));
    $('#house-area-up-to').attr('placeholder', 'до ' + max_area);

    var min_price = Math.min.apply(null, prices); //Math.min(...prices);
    var max_price = Math.max.apply(null, prices); //Math.max(...prices);

    //min price set
    $('#house-price-from').attr('data-val', min_price);
    $('#house-price-from').attr('placeholder', 'от ' + min_price);

    //max price set
    $('#house-price-up-to').attr('data-val', max_price);
    $('#house-price-up-to').attr('placeholder', 'до ' + max_price);

    var min_width = Math.max.apply(null, widths);
    var min_length = Math.max.apply(null, lengths);

    $('#house-width-from').attr('data-val', min_width);
    $('#house-width-from').attr('placeholder', 'до ' + min_width);

    $('#house-length-from').attr('data-val', min_length);
    $('#house-length-from').attr('placeholder', 'до ' + min_length);

    if (categories.length > 0) {
        listCat.html(categories_html);
    }
    if (series.length > 0) {
        listSeries.html(series_html);
    }
    if (floors.length > 0) {
        listFloors.html(floors_html);
    }
    if (tech.length > 0) {
        listTech.html(tech_html);
    }
}

function find(array, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i] == value) return i;
    }
    return -1;
}

function declension(num, expressions) {
    var resultat;
    var count = num % 100;
    if (count >= 5 && count <= 20) {
        resultat = expressions['2'];
    } else {
        count = count % 10;
        if (count == 1) {
            resultat = expressions['0'];
        } else if (count >= 2 && count <= 4) {
            resultat = expressions['1'];
        } else {
            resultat = expressions['2'];
        }
    }
    return resultat;
}

function getParameterByName(name) 
{
	
	
	name = name.replace(/[\[\]]/g, "\\$&");
	
    var url = window.location.href;
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");
    var results = regex.exec(url);
    
    
    if(name == 'category'){
    	var res = $('#categoryDropdown').text().trim();
    	if(res != 'Категория дома'){
    		return res;
    	}
    	
    }
    
    
    if (!results) return '';
    if (!results[2]) return '';
   
	

    return decodeURIComponent(results[2].replace(/\+/g, " "));;
}

function getClearURL(url)
{
	return url.replace(/\?(.*)/, "");
}

