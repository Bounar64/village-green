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

    $('#ButtonEditShipping').on("click", function(){ // ancienne écriture $('#ButtonEdit').click(function(){
        $('#CardEditShipping').slideToggle();
    });
 })

 //_______Afficher au click du boutton description la card description_____//
 $(function(){

    $('#ButtonDescription').on("click", function(){ // ancienne écriture $('#ButtonEdit').click(function(){
        $('#CardDescription').slideToggle();
    });
 })

 //_______Afficher au click du boutton filtre la card des filtres dans Admin_____//
 $(function(){

    $('#ButtonFilterAdmin').on("click", function(){ // ancienne écriture $('#ButtonEdit').click(function(){
        $('#CardFilterAdmin').slideToggle();
    });
 })


 //_______Afficher au check le boutton de paiement_____//
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

// //_______filtre produit catégories Admin_______//

// const FilterForm = document.querySelector('#filters');

// // On boulce sur les inputs
// document.querySelectorAll('#filters input').forEach(input => {
//     input.addEventListener("change", () => {
//         // On intercepte les clics
//         // On récupère les données du formulaire
//         const Form = new FormData(FilterForm);

//         // On fabrique la "queryString" pour notre requête ajax
//         const Params = new URLSearchParams();

//         Form.forEach((value, key) => {
//             Params.append(key, value);
//         });

//         //On récupère l'url active
//         const url = new URL(window.location.href);

//         // On lance la requête ajax
//         fetch(url.pathname + '?' + Params.toString() + '&ajax=1', {
//             headers: {
//                 'x-Requested-With': 'XMLHttpRequest'
//             }
//         }).then(response => {
//             console.log(response)
//         }).catch(e => alert(e));
//     })
// })


