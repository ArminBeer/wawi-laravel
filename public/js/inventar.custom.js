/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(function ($) {


    // Api to Check if Einheit needs conversion
    $('#zutat_einheit').on('change', function(){
        var conversionForm = $('#conversionForm');

        checkConversionNeeded($('#zutat_einheit').val(), conversionForm);
    });

    //Check if in Edit Blade
    if ($('#zutat_einheit').val()){
        $('#conversionForm').removeClass('hidden');
        $('#conversionForm').prop('required',true);
    }



    // Img Upload Preview
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


    // Ajax function
    function checkConversionNeeded(id, html){
        var checkConversionUrl = "/einheiten/" + id + "/check";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: checkConversionUrl,
            success: function (data) {
                if (data){
                    html.removeClass('hidden');
                    html.find('input, select').each(function(){
                        $(this).prop('required',true);
                    });
                }
                else {
                    html.addClass('hidden');
                    html.find('input, select').each(function(){
                        $(this).prop('required',false);
                    });
                }

            },
            error: function() {
                    console.log('ERROR');
            }
        }); //end of ajax
    }
});

