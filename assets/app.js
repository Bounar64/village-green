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

// Nouislider
import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';

import Typed from 'typed.js';
import { ajax, data } from 'jquery';

// ************************************************************************************************************************************************************************** //

//_____Swiper de sous-catégorie_____//
$(function(){ // ancienne écriture à $(document).ready(function(){

    const swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        loop: true,
            coverflowEffect: {
                rotate: 20,
                stretch: 0,
                depth: 200,
                modifier: 1,
                slideShadows: true,
            },
    });
});


 //_______Afficher au click la card modifier mon adresse de livraison_____//
 $(function(){

    $('#ButtonEditShipping').on("click", function(){ 
        $('#CardEditShipping').slideToggle();
    });
 })

 //_______Afficher au click du boutton description la card description_____//
 $(function(){

    $('#ButtonDescription').on("click", function(){ 
        $('#CardDescription').slideToggle();
    });
 })

 //_______Afficher au click du boutton filtre la card des filtres dans Admin_____//
 $(function(){

    $('#ButtonFilterAdmin').on("click", function(){ 
        $('#CardFilterAdmin').slideToggle();
    });
 })

 //_______Afficher au click le boutton de paiement_____//
 $(function(){

    $('.checkPayment1').on("click", function() {
       
        $('#buttonPayment1').show();
        $('#buttonPayment2').hide();
        $('#buttonPayment3').hide();
        $('#buttonPayment4').hide();
        $('#buttonPayment5').hide();
    });

    $('.checkPayment2').on("click", function() {
       
        $('#buttonPayment1').hide();
        $('#buttonPayment2').show();
        $('#buttonPayment3').hide();
        $('#buttonPayment4').hide();
        $('#buttonPayment5').hide();
    });

    $('.checkPayment3').on("click", function() {
       
        $('#buttonPayment1').hide();
        $('#buttonPayment2').hide();
        $('#buttonPayment3').show();
        
        $('#buttonPayment4').hide();
        $('#buttonPayment5').hide();
    });

    $('.checkPayment4').on("click", function() {
       
        $('#buttonPayment1').hide();
        $('#buttonPayment2').hide();
        $('#buttonPayment3').hide();
        $('#buttonPayment4').show();
        $('#buttonPayment5').hide();
    });

    $('.checkPayment5').on("click", function() {
       
        $('#buttonPayment1').hide();
        $('#buttonPayment2').hide();
        $('#buttonPayment3').hide();
        $('#buttonPayment4').hide();
        $('#buttonPayment5').show();
    });
 })

 //_______Afficher au click du boutton les différents tableau associés (commande : -en cours de livraison, -particulier, -professionnel, toutes)_____//
 $(function(){

    $('#ButtonPartFiltre').on("click", function(){ 
        $('#ListUserPart').slideToggle();
        $('#ListUserPro').hide();
        $('#ListCommandeEnCoursLivraison').hide();
        $('#ListCommandeAll').hide();
    });

    $('#ButtonProFiltre').on("click", function(){ 
        $('#ListUserPro').slideToggle();
        $('#ListUserPart').hide();
        $('#ListCommandeEnCoursLivraison').hide();
        $('#ListCommandeAll').hide();
    });

    $('#ButtonEnCoursLivraison').on("click", function(){ 
        $('#ListCommandeEnCoursLivraison').slideToggle();
        $('#ListUserPro').hide();
        $('#ListUserPart').hide();
        $('#ListCommandeAll').hide();
    });
 

    $('#ButtonCommandeAll').on("click", function(){ 
        $('#ListCommandeAll').slideToggle();
        $('#ListUserPro').hide();
        $('#ListUserPart').hide();
        $('#ListCommandeEnCoursLivraison').hide();
    });
 })

 //_______Afficher au click du boutton filtre la card des filtres dans Admin_____//
 $(function(){

    $('#select2').prop('disabled', true);

    $('#select1').on("change", function(){ 
           
        if($('#select1').val() == null) {
            $('#select2').prop('disabled', false);
        }else {
            $('#select2').prop('disabled', true);
        }

        let form = $(this).closest('form');
        let data = $(this).attr('name') + '=' + $(this).val();

        // écriture jquery compress
        $.post(form.attr('action'), data).then(function (response) 
        {
            $('#select2').replaceWith(
                $(response).find('#select2')
            )
        })

        // // écrire ajax jquery normal
        // $.ajax({
        //     type: "post",
        //     url: form.attr('action'),
        //     data: data,
        //     dataType: "html",
        //     success: function (response) {
        //         $('#select2').replaceWith(
        //             $(response).find('#select2')
        //         )
        //     }
        // });

        //var route = $(location).attr('href'); // la variable chemin reçoit le chemin de l'URL, c'est-à-dire /article/1.
        //var route = $(location).attr(href); // la variable url reçoit l'URL courante, c'est-à-dire http://www.example.com/article/1.   
    });  
 })


 //________Ajout du typing placeholder recherche produit admin_________//
$(function() {
    
    // typing animation script
    var typed = new Typed('#search_fulltext_key', {
        strings: ['Rechercher par Label', 'Rechercher par Label court', 'Rechercher par Marque', 'Rechercher par Référence'],
        typeSpeed: 50,
        backSpeed: 20,
        attr: 'placeholder',
        //fadeOut: true,
        bindInputFocusEvents: true,
        loop: true
      });
})
 

//_____Slider de prix min et max_____//
var slider = document.getElementById('priceSlider');

if(slider) {
    const min = document.getElementById('min')
    const max = document.getElementById('max')
    const range = noUiSlider.create(slider, {
        start: [min.values | 0, max.values | 5000],
        connect: true,
        step: 100,
        range: {
            'min': 0,
            'max': 5000
        }

    })
    
    range.on('slide', function(values, handle) {
        if(handle === 0) {
            min.value = Math.round(values[0])
        }
        if(handle === 1) {
            max.value = Math.round(values[1])
        }

    })
};


// //_______Afficher la sous-catégorie si catégorie sélectionnée dans Admin_____// 
// window.onload = () => {

//     // on récupère la categorie
//     let cat = document.querySelector('#select1');
    
//     cat.addEventListener('change', function() {
//         let form = this.closest('form'); // récupère le formulaire complet, (closest récupère la balise 'form' la plus proche de mon élément donc son parent)
//         let data = this.name + '=' + this.value;

//         // ajax
//         fetch(form.action, { // j'envoi à mon action de mon formulaire 
//             method: form.getAttribute('method'), // je récupère ma methode
//             body: data, // on envoi data en donnée
//             headers: { 
//                 'Content-Type': 'application/x-www-form-urlencoded; charset:utf-8' // envoi nos données sous forme de query string clé -> valeur
//             }
//         })
//         .then(response => response.text()) // je traite ma response 
//         .then(html => {  // on traite le contenu de ma reponse html
//            let content = document.createElement('html'); // je crée un élément html
//            content.innerHTML = html; // je met en innerHTML ce que j'ai reçu (pour pouvoir faire un querySelector dessus)
//            let newSelect = content.querySelector('#select2'); // je créer un nouveau select2 (vide) et l'implemente avec les nouvelles données
//            document.querySelector('#select2').replaceWith(newSelect); // on remplace le select2 par le nouveau select2
//         })
//         .catch(error => {
//             console.log(error);
//         })
//     });
//  }

