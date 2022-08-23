/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if (document.getElementById('messagebox')){
    const messagebox = document.getElementById('messagebox');

    setTimeout(function(){
        messagebox.parentNode.removeChild(messagebox);
        }, 3000);

}

