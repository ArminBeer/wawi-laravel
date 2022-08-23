/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Img Upload Preview
jQuery(function ($) {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#uploaded_img').attr('src', e.target.result);
                $('#uploaded_img').removeClass('hidden');
                $('#existing_img').addClass('hidden');
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#InputImg").change(function() {
        readURL(this);
    });
});

