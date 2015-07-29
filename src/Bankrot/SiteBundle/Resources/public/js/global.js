jQuery(function ($) {
    'use strict';

    $('[data-href]').on('click', function () {
        window.location = $(this).data('href');
    });

    Array.prototype.plural = function (number) {
        var index = null,
            n = Math.abs(number);
        n %= 100;

        if (n >= 5 && n <= 20) {
            index = 2;
        }

        n %= 10;

        if (1 === n) {
            index = 0;
        } else if (n >= 2 && n <= 4) {
            index = 1;
        } else {
            index = 2;
        }

        return number + ' ' + this[index];
    };
});