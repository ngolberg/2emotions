import Vue from 'vue';
import router from './router';
import App from './components/App';

require('./bootstrap');
Vue.use(require('vue-cookies'))
Vue.prototype.__ = string => _.get(window.i18n.messages, string);

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});
