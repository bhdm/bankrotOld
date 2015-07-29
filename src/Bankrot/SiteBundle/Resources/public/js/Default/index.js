//jQuery(function ($) {
//    'use strict';
//    var $show = $('#show');
//
//    $('#lots td').on('click', function (e) {
//        handler(this);
//        return false;
//    });
//    function handler (element) {
//        var $element =$(element).parents('tr[data-href]').eq(0);
//        var href =$element.data('href');
//        var tradelink = $element.data('tradelink');
//        if (href) {
//            $show.find('.content').html('<i class="fa fa-spin fa-spinner"></i>');
//            $show.modal();
//
//            $.ajax({
//                url: href,
//                dataType: 'html',
//                success: function (html) {
//                    $show.find('.content').html(html);
//                }
//            });
//            if(tradelink) {
//                $("#tradelink").off('click').on('click', function () {
//                    window.open(tradelink, '_blank');
//                    return false;
//                });
//            }
//        }
//    }
//
//        $('.infinite-scroll').jscroll({
//            contentSelector: 'table',
//            callback: function (a) {
//                var $jscrolladded =$('.jscroll-added');
//                var $newelements =  $jscrolladded.find('tbody tr').clone();
//                $jscrolladded.remove();
//                $newelements.find('td').on('click', function (e) {handler(this)});
//                $('.infinite-scroll').find('tbody').eq(0).append($newelements);
//            }
//        });
//});
