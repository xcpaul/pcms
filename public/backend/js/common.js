/**
 * Created by jinfangchao on 16/7/11.
 */
$(document).ready(function() {

    var active_href='#'+$.cookie('languageTab');
    $('.nav-tabs li a[href='+active_href+']').tab('show');
    $('.languagesbox').each(function () {
        var id = $(this).attr('id').replace('box-', '');
        $(this).find('input, select, textarea').attr('data-language', id);
    });
    $('.nav-tabs li a').click(function () {
        var langIndex = $(this).attr('href').replace('#','');
        $.cookie('languageTab', langIndex);
    });
});