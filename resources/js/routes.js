import VueRouter from 'vue-router';
import Dashboard from './components/Dashboard';
import PageNotFound from './components/Errors/PageNotFound.vue';

let routes = [
    {
        name: 'Dashboard',
        path: '/',
        component: Dashboard
    },
    {
        name:'PageNotFound',
        path: '*',
        component: PageNotFound
    }
];

export default new VueRouter({
    routes,
    mode: 'history'
});
