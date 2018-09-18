/*
--------------------------------
Ajax Contact Form
--------------------------------
+ https://github.com/mehedidb/Ajax_Contact_Form
+ A Simple Ajax Contact Form developed in PHP with HTML5 Form validation.
+ Has a fallback in jQuery for browsers that do not support HTML5 form validation.
+ version 1.0.1
+ Copyright 2016 Mehedi Hasan Nahid
+ Licensed under the MIT license
+ https://github.com/mehedidb/Ajax_Contact_Form
*/

(function ($, window, document, undefined) {
    'use strict';

  var $reservationForm = $('#reservation-form');
  
    $reservationForm.submit(function (e) {
        // remove the error class
        $('.form-group').removeClass('has-error');
        $('.help-block').remove();

        // get the form data
        var formData = {
            'telephone' : $('input[name="telephone"]').val(),
            'date' : $('input[name="date"]').val(),
            'time' : $('input[name="time"]').val(),
            'person' : $('select[name="person"]').val()
        };
      
        // process the form
        $.ajax({
            type : 'POST',
            url  : 'process-reservation-form.php',
            data : formData,
            dataType : 'json',
            encode : true
        }).done(function (data) {
            // handle errors
            if (!data.success) {
                if (data.errors.telephone) {
                    $('#field-telephone').addClass('has-error');
                    $('#field-telephone').find('.form-input').append('<span class="help-block">' + data.errors.telephone + '</span>');
                }

                if (data.errors.date) {
                    $('#field-date').addClass('has-error');
                    $('#field-date').find('.form-input').append('<span class="help-block">' + data.errors.date + '</span>');
                }

                if (data.errors.time) {
                    $('#field-time').addClass('has-error');
                    $('#field-time').find('.form-input').append('<span class="help-block">' + data.errors.time + '</span>');
                }

                if (data.errors.person) {
                    $('#field-person').addClass('has-error');
                    $('#field-person').find('.form-input').append('<span class="help-block">' + data.errors.person + '</span>');
                }
            } else {
                // display success message
                $reservationForm.html('<div class="alert alert-light">' + data.message + '</div>');
            }
        }).fail(function (data) {
            // for debug
            console.log(data)
        });

        e.preventDefault();
    });
}(jQuery, window, document));
