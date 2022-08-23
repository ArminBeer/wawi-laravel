/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(function ($) {
    // Add Einheiten in einheit index blade
    const einheitNeu = document.getElementById('addEinheit');
    const formEinheit = document.getElementById('einheit_form');

    einheitNeu.addEventListener('click', event => {

        formEinheit.className = formEinheit.className.replace(/\bhidden\b/g, '');
        formEinheit.scrollIntoView({
            block: 'center',
            behavior: 'smooth'
        });

    });

    // Add form to edit existing Einheiten
    $('.einheit_edit').click(function(){

        einheitName = $(this).find('.einheit_name').text();
        einheitID = $(this).find('.einheit_id').text();
        einheitGrundeinheit = $(this).find('.einheit_grundeinheit').text();
        einheitConversion = $(this).find('.einheit_conversion').text();
        einheitKuerzel = $(this).find('.einheit_kuerzel').text();

        $('#einheit_form').find('.e_name').val(einheitName);
        $('#einheit_form').find('.e_kuerzel').val(einheitKuerzel);
        if (einheitGrundeinheit == 1)
            $('#einheit_form').find('.e_grundeinheit').prop('checked', true);
        else
            $('#einheit_form').find('.e_grundeinheit').prop('checked', false);

        if (einheitConversion == 1)
            $('#einheit_form').find('.e_conversion').prop('checked', true);
        else
            $('#einheit_form').find('.e_conversion').prop('checked', false);

        $('#einheit_form').find('.e_id').val(einheitID);

        formEinheit.className = formEinheit.className.replace(/\bhidden\b/g, '');
        formEinheit.scrollIntoView({
            block: 'center',
            behavior: 'smooth'
        });

    });

    //Close Function
    $('#einheit_close').click(function(){
        $('#einheit_form').addClass('hidden');
    });



    // Add Umrechnungen in einheit index blade
    const umrechnungNeu = document.getElementById('addUmrechnung');
    const formUmrechnung = document.getElementById('umrechnung_form');

    umrechnungNeu.addEventListener('click', event => {

        formUmrechnung.className = formUmrechnung.className.replace(/\bhidden\b/g, '');
        formUmrechnung.scrollIntoView({
            block: 'center',
            behavior: 'smooth'
        });

    });

    // Add form to edit existing Umrechnungen
    $('.umrechnung_edit').click(function(){

        umrechnungFaktor = $(this).find('.umrechnung_faktor').text();
        umrechnungID = $(this).find('.umrechnung_id').text();
        umrechnungIst = $(this).find('.umrechnung_ist').text();
        umrechnungSoll = $(this).find('.umrechnung_soll').text();

        $('#umrechnung_form').find('.u_faktor').val(umrechnungFaktor);
        $('#umrechnung_form').find('.u_id').val(umrechnungID);
        $('#umrechnung_form').find('.u_ist').val(umrechnungIst);
        $('#umrechnung_form').find('.u_soll').val(umrechnungSoll);

        formUmrechnung.className = formUmrechnung.className.replace(/\bhidden\b/g, '');
        formUmrechnung.scrollIntoView({
            block: 'center',
            behavior: 'smooth'
        });

    });


    //Close Function
    $('#umrechnung_close').click(function(){
        $('#umrechnung_form').addClass('hidden');
    });
});
