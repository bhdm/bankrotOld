jQuery(function ($) {
    $('[data-drop-rule-remove]').on('click', function (e) {
        if (confirm('Вы действительно хотите удалить это правило?')) {
            var $self = $(this);

            $.ajax({
                url: '/api/v1/lots/' + $(this).data('lot-id') + '/drop-rules/' + $(this).data('drop-rule-id') + '/remove',
                method: 'POST',
                success: function (response) {
                    $self.parents('[data-root]').eq(0).fadeOut(function () {
                        $(this).remove();
                    });
                }
            });

        }

        e.preventDefault();
    });
});
