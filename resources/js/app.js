/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Swiper from 'swiper/bundle';

// import Swiper styles
import 'swiper/swiper-bundle.css';

// init Swiper:
const swiper = new Swiper('.swiper-container', {
    effect: 'fade',
    direction: 'vertical',
    autoplay: {
        delay: 10000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    fadeEffect: {
        crossFade: true
    },
});

if($('#banner').length && $('#banner').css('display') == 'block') {
    $('.forthrow .box').css('margin-top', '-70px');
    
    console.log(window.innerWidth);
    if(window.innerWidth <= 750) {
        $('.banner-container').css('background-size', 'auto');
    }
}