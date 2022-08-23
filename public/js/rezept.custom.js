/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(function ($) {
    // Add Zutaten
    const zutatNeu = document.getElementById('zutat_neu');
    const formZutat = document.getElementById('zutat_form').outerHTML
    const zutatDelete = document.getElementById('zutat_loeschen');
    const insertZutat = document.getElementById('zutaten')

    var InsertFields = [];
    $.each($('.rezept_zutat').parent().parent(), function(){
        var parent = $(this);
        var child = parent.find('.rezept_zutat');
        var selected = parent.find('.rezept_einheiten').val();

        InsertFields.push(parent);

        child.change(function(){
            getNewEinheitenAjax(parent, child.val());
        });

        if(child.val() != "") {
            getNewEinheitenAjax(parent, child.val(), selected);
        }
    })

    zutatNeu.addEventListener('click', event => {

        insertZutat.insertAdjacentHTML("beforeBegin", formZutat);

        InsertFields = [];
        $.each($('.rezept_zutat').parent().parent(), function(){
            InsertFields.push($(this));
        })

        $.each(InsertFields, function (){
            var parent = $(this);
            var child = parent.find('.rezept_zutat');
            child.change(function(){
                getNewEinheitenAjax(parent, child.val());
            })
        });

        $('.select-2').select2();

    });


    zutatDelete.addEventListener('click', event => {

            var zutatElement = document.querySelectorAll('.zutat-delete');

            var lastZutatElement = zutatElement[zutatElement.length-1];
            lastZutatElement.parentNode.removeChild(lastZutatElement);

    });

    function getNewEinheitenAjax(html, id, selected = ""){
        var einheitenUrl = "/einheiten/" + id + "/get";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: einheitenUrl,
            success: function (data) {
                var selectField = html.find('.rezept_einheiten');

                selectField
                    .find('option')
                    .remove()
                    .end();
                if(selected != "") {
                    selectField.append('<option value>Bitte wählen</option>');
                } else {
                    selectField.append('<option value selected>Bitte wählen</option>');
                }

                $.each(data, function (id, name) {
                    if(selected == id) {
                        selectField.append("<option value='" + id + "' selected>" + name + "</option>");
                    } else {
                        selectField.append("<option value='" + id + "'>" + name + "</option>");
                    }
                });
            },
            error: function() {
                    console.log('ERROR');
            }
        }); //end of ajax
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
});
