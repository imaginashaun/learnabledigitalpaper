/*=========================================================================================
  File Name: main.js
  Description: main vue(js) file
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import App from './App.vue'

// Vuesax Component Framework
import Vuesax from 'vuesax'

Vue.use(Vuesax)



//user_id
//Vue.prototype.$userApiId = document.querySelector("meta[name='user-id']").getAttribute('content');


// axios
import axios from './axios.js'

axios.interceptors.request.use(function (config) {
    // assume your access token is stored in local storage
    // (it should really be somewhere more secure but I digress for simplicity)
    let token = localStorage.getItem('accessToken')

    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`

        console.log("TOKEN IS"+`Bearer ${token}`);
    }else{
        console.log("NO TOKEN!!");
    }

    return config;
}, function (error) {
    // Do something with request error
    return Promise.reject(error);
});


Vue.prototype.$http = axios
Vue.prototype.$httpz = axios

// API Calls
import './http/requests'

// mock
//import './fake-db/index.js'

// Theme Configurations
import '../themeConfig.js'


// Firebase
//import '@/firebase/firebaseConfig'


// Auth0 Plugin
//import AuthPlugin from './plugins/auth'
//Vue.use(AuthPlugin)


// ACL
//import acl from './acl/acl'


// Globally Registered Components
import './globalComponents.js'


// Vue Router
import router from './router'


// Vuex Store
import store from './store/store'


// i18n
//import i18n from './i18n/i18n'


// Vuexy Admin Filters
//import './filters/filters'


// Clipboard
import VueClipboard from 'vue-clipboard2'
Vue.use(VueClipboard)


// Tour
import VueTour from 'vue-tour'
Vue.use(VueTour)
require('vue-tour/dist/vue-tour.css')


// VeeValidate
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate)


// Google Maps
import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
    load: {
        // Add your API key here
        key: 'AIzaSyB4DDathvvwuwlwnUu7F4Sow3oU22y5T1Y',
        libraries: 'places' // This is required if you use the Auto complete plug-in
    }
})

// Vuejs - Vue wrapper for hammerjs
import { VueHammer } from 'vue2-hammer'
Vue.use(VueHammer)


// PrismJS
import 'prismjs'


// Feather font icon
require('@assets/css/iconfont.css')


// Vue select css
// Note: In latest version you have to add it separately
// import 'vue-select/dist/vue-select.css';


Vue.config.productionTip = false

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
