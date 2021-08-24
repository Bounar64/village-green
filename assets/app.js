/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// You can specify which plugins you need
import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';


// ************************************************************************************************************************************************************************** //

// Activation des popovers des catégories //
$(document).ready(function(){
    
    /* $('.contenu-guitare').hide();
    $('.cat-guitare').click(function(){
        $('.contenu-guitare').toggle();
    });*/

        $(".cat-guitare").click(function(){
            $(this).toggleClass("active");
            $(".contenu-guitare").toggleClass("active");
        })
        $(".contenu-guitare").focusout(function(){
            $(".contenu-guitare").hide();
        })    
        $(".cat-batterie").click(function(){
            $(this).toggleClass("active");
            $(".contenu-batterie").toggleClass("active");
        })     
        $(".cat-clavier").click(function(){
            $(this).toggleClass("active");
            $(".contenu-clavier").toggleClass("active");
        })
        $(".cat-studio").click(function(){
            $(this).toggleClass("active");
            $(".contenu-studio").toggleClass("active");
        })
        $(".cat-sono").click(function(){
            $(this).toggleClass("active");
            $(".contenu-sono").toggleClass("active");
        })
        $(".cat-eclairage").click(function(){
            $(this).toggleClass("active");
            $(".contenu-eclairage").toggleClass("active");
        })
        $(".cat-dj").click(function(){
            $(this).toggleClass("active");
            $(".contenu-dj").toggleClass("active");
        })
        $(".cat-cases").click(function(){
            $(this).toggleClass("active");
            $(".contenu-cases").toggleClass("active");
        })
        $(".cat-access").click(function(){
            $(this).toggleClass("active");
            $(".contenu-access").toggleClass("active");
        })
   });

