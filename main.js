(function ($) {
    'use strict';

    var form = $('.contact__form'),
        message = $('.form__sucess'),
        fail_message=$('.form__fail'),
        form_data;

    // Success function
    function done_func(response) {
        // alert("Sucess");
        message.fadeIn()
        // message.html(response);
        setTimeout(function () {
            message.fadeOut();
        }, 5000);
        
        form.find('input:not([type="submit"]), textarea').val('');
    }

    // fail function
    function fail_func(data) {
        fail_message.fadeIn()
        //message.html(data.responseText);
        setTimeout(function () {
            fail_message.fadeOut(5000);
        }, 5000);
    }
    
    form.submit(function (e) {
        
        e.preventDefault();
        form_data = $(this).serialize();
        console.log("form_data : ",form_data);
        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: form_data
        })
        .done(done_func)
        .fail(fail_func);
        
    });
})(jQuery);