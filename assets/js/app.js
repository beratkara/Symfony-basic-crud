require('./bootstrap');

import Vue from 'vue'
import Router from 'vue-router'
import Main from './Application/Main.vue'
import Login from './Application/Login.vue'
import Register from './Application/Register.vue'
import Profile from './Application/Profile.vue'
import Contacts from './Application/Contacts.vue'
import ContactsEdit from "./Application/ContactsEdit";
import ContactsCreate from "./Application/ContactsCreate";
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueCookie from 'vue-cookie'

Vue.use(VueAxios, axios);
Vue.use(Router);
Vue.use(VueCookie);
Vue.config.productionTip = false

export const router = new Router({
    mode: "history",
    base: "/",
    routes: [
        {path: "/",name: "main",component: Main},
        {path: "/login",name: "login",component: Login},
        {path: "/register",name: "register",component: Register},
        {path: "/profile",name: "profile",component: Profile},
        {path: "/contacts",name: "contacts",component: Contacts},
        {path: "/contacts/edit/:contactId",name: "contacts-edit",component: ContactsEdit},
        {path: "/contacts/create",name: "contacts-create",component: ContactsCreate},
    ]

});

new Vue({
    router,
    render: h => h(Main),
}).$mount('#app');
