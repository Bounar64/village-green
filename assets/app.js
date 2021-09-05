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


$(function(){ // équivaut à $(document).ready()

    //_____Swiper de sous-catégorie_____//
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


