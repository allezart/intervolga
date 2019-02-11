$(function(){
    
    $('.btn-add').click(function(){
        $('#text').fadeToggle('fast', 'linear');
    });

    $('.form').validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 50,
            },
            population: {
                required: true,
                digits: true
            },
            currency: {
                required: true,
                maxlength: 30
            }
            
        },
        messages: {
            name: {
                required: "Заполните поле",
                minlength: "Минимум 3 символа",
                maxlength: "Очень длинное название"
            },
            population: {
                required: "Заполните поле",
                digits: "Введите число"
            },
            currency: {
                required: "Заполните поле",
                maxlength: "Очень длинное название"
            }
        }
    });
    
});