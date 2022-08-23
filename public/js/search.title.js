/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(function ($) {
    $('.search-input').on('keyup', function() {
        var input = $(this).val().toLowerCase();

        $('.wun-card-text p').each(function() {
            if(input == '')  {
                $(this).parent().parent().parent().removeClass('hidden');
            } else if($(this).html().toLowerCase().indexOf(input) < 0) {
                $(this).parent().parent().parent().addClass('hidden');
            } else {
                $(this).parent().parent().parent().removeClass('hidden');
            }
        });
    })
});

