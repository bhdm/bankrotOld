jQuery(function ($) {
    'use strict';

    var $timer = $('[data-timer]');

    if (!$timer.length) {
        throw new Error('Невозможно найти виджет таймера');
    }

    var initialSeconds = parseInt($timer.data('timer')),
        redirectUrl = $timer.data('timer-href'),
        $target = $($timer.data('timer-id'));

    var interval = setInterval(function () {
        initialSeconds--;

        if (0 === initialSeconds) {
            window.location = redirectUrl;

            clearInterval(interval);
        } else {
            $target.text(['секунду', 'секунды', 'секунд'].plural(initialSeconds));
        }
    }, 1000);
});