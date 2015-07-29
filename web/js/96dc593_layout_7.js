jQuery(function ($) {
    'use strict';

    $('select').selecter();

    $('select[data-toggle-control-visible]').on('change', function (e) {
        var $ele = $('#' + $(this).val());

        $ele.siblings('.form-control').hide();
        $ele.show();

        e.preventDefault();
    }).trigger('change').each(function () {
        $(this).children('option').each(function () {
            $('#' + $(this).prop('value')).on('change', function () {
                $(this).siblings('.form-control').val(null);
            });
        });
    });

    $('[data-inputmask]').each(function () {
        $(this).inputmask($(this).data('inputmask'));
    });

    $('[data-route]').on('click', function (e) {
        window.location.href = $(this).data('route');

        e.preventDefault();
    });
});
