/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 // Add Allergen in allergen index blade
const allergenNeu = document.getElementById('addAllergen');
const formAllergen = document.getElementById('allergen_form');

allergenNeu.addEventListener('click', event => {

    formAllergen.className = formAllergen.className.replace(/\bhidden\b/g, '');

});
