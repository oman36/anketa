(function() {

    // получаем номер последнего вопроса
    function getLast() {
        return $('.field-ankets-questions').last().find('label span').text();
    }

    // проверяем, все ли вопросы стоят по порядку 1,2,3...
    function checkNumbers(){
        $('.field-ankets-questions').each(function(i,el){
            var span = $(this).find('label span');
            var tempIndex = parseInt(span.text()) - 1;
            if (i !== tempIndex) span.text(tempIndex)
        });

    }

    function removeField (e) {
        if ($(e.target).is('button.remove')) {
            $(this).remove();
            checkNumbers();
        }
        e.preventDefault();
    }

    $('#add-field').on('click',function(e){
        var last = parseInt(getLast()) + 1;
        var html = '<div class="form-group field-ankets-questions">' +
            '<div class="row">' +
            '<label class="col-lg-12 text-left control-label" for="ankets-questions' + last + '">' +
            'Вопрос №<span>' + last + '</span>' +
            '</label>' +
            '</div>' +
            '<div class="row">' +
            '<div class="col-lg-11">' +
            '<input type="text" id="ankets-questions' + last + '" class="form-control" name="Ankets[questions][]">'  +
            '</div>'  +
            '<div class="col-lg-1">'  +
            '<button class="btn btn-danger remove">-</button>'  +
            '</div>'  +
            '</div>'  +
            '<div class="row">'  +
            '<div class="col-lg-12">'  +
            '<div class="help-block"></div>'  +
            '</div>'  +
            '</div>'  +
            '</div>';

        $('#questions').append(html);
        var fields = $('.field-ankets-questions');
        fields.unbind('click');
        fields.on('click', removeField);
        e.preventDefault();
    });


    $('.field-ankets-questions').on('click', removeField );
})();