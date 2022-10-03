$(document).ready(function () {
    $(document).on('change', '.select-test', function () {
        var ele = $(document).find('.attributes');
        conceptName = $(this).find("option:selected").val();
        if (conceptName == 1 || conceptName == 2) {
            ele.removeClass('d-none');
        } else {
            ele.addClass('d-none');
        }
    });
});
