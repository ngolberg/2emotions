import Vue from 'vue';
import VueRouter from 'vue-router';
import WordsList from "./components/WordsList";
import WordShow from "./components/WordShow";
import Logout from "./Actions/Logout";
import Login from "./Actions/Login";

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path: '/', component: WordsList,
            meta: { title: 'Love or hate?' }
        },
        {
            path: '/toplaved', component: WordsList,
            meta: { title: 'Beloved' }
        },
        {
            path: '/tophated', component: WordsList,
            meta: { title: 'Top hated' }
        },
        {
            path: '/mylist', component: WordsList,
            meta: { title: 'My list' }
        },
        {
            path: '/word/:id', component: WordShow,
            meta: { title: '' }
        },
        {
            path: '/logout', component: Logout
        },
        {
            path: '/login', component: Login
        }
    ],
    mode: 'history'
});
