import Vue from 'vue';
import router from './router';
import App from './components/App';
import Vue2TouchEvents from 'vue2-touch-events';

require('./bootstrap');
Vue.use(require('vue-cookies'));
Vue.use(Vue2TouchEvents);
Vue.prototype.__ = string => _.get(window.i18n.messages, string);

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});
