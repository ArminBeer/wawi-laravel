/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(function ($) {

    // Add Kategorie in kategorie index blade
    const kategorieNeu = document.getElementById('addKategorie');
    const formKategorie = document.getElementById('kategorie_form');
    // const editKategorie = document.getElementById('category_edit');

    // Add new Kategorie
    kategorieNeu.addEventListener('click', event => {

        formKategorie.className = formKategorie.className.replace(/\bhidden\b/g, '');
        formKategorie.scrollIntoView({
            block: 'center',
            behavior: 'smooth'
        });

    });

    // Add form to edit existing Kategorie
    $('.category_edit').click(function(){

        categoryName = $(this).find('.cat_name').text();
        categoryID = $(this).find('.cat_id').text();
        categoryBereiche = $(this).find('.cat_bereiche').text().split(';');

        categoryBereiche.splice(-1,1);

        $('#kategorie_form').find('.k_name').val(categoryName);
        $('#kategorie_form').find('.k_id').val(categoryID);
        $('#kategorie_form').find('.k_bereiche').val(categoryBereiche).trigger('change');

        formKategorie.className = formKategorie.className.replace(/\bhidden\b/g, '');
        formKategorie.scrollIntoView({
            block: 'center',
            behavior: 'smooth'
        });

    });

    //Close Function
    $('#cat_close').click(function(){
        $('#kategorie_form').addClass('hidden');
    });


    // Add Umrechnungen in einheit index blade
    const tagNeu = document.getElementById('addTag');
    const formTag = document.getElementById('tag_form');

    tagNeu.addEventListener('click', event => {

        formTag.className = formTag.className.replace(/\bhidden\b/g, '');
        formTag.scrollIntoView({
            block: 'center',
            behavior: 'smooth'
        });

    });

    // Add form to edit existing Kategorie
    $('.tag_edit').click(function(){

        tagName = $(this).find('.tag_name').text();
        tagID = $(this).find('.tag_id').text();

        $('#tag_form').find('.t_name').val(tagName);
        $('#tag_form').find('.t_id').val(tagID);

        formTag.className = formTag.className.replace(/\bhidden\b/g, '');
        formTag.scrollIntoView({
            block: 'center',
            behavior: 'smooth'
        });

    });

        //Close Function
        $('#tag_close').click(function(){
            $('#tag_form').addClass('hidden');
        });
});
