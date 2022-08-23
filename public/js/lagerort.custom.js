/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 // Add Lagerorte in lagerort index blade
const lagerorttNeu = document.getElementById('addLagerort');
const formLagerort = document.getElementById('lagerort_form');

lagerorttNeu.addEventListener('click', event => {

    formLagerort.className = formLagerort.className.replace(/\bhidden\b/g, '');

});

