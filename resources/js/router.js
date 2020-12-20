import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../js/store';
import ExampleComponent from '../js/components/ExampleComponent';
import HomeComponent from '../js/components/HomeComponent';
import LoginComponent from '../js/components/LoginComponent';
import PostDetailComponent from '../js/components/PostDetailComponent';
import CreatePostComponent from '../js/components/CreatePostComponent';
import CreateUserComponent from '../js/components/CreateUserComponent';
import ForgotPassword from '../js/components/ForgotPassword';
import ResetPassword from '../js/components/ResetPassword';

Vue.use(VueRouter)
// const routes = [
//     {path: '/', name:'Root', component: ExampleComponent, beforeEnter: (to, from, next) => {
//         if(to.path !== '/login' && !token){
//             next({path:'/login'})
//         }else next();
//     }},
//     {path: '/home', component: HomeComponent,  beforeEnter: (to, from, next) => {
//         if(to.path !== '/login' && !token){
//             next({path:'/login'})
//         }else next();
//     }},
//     {path: '/login', name:'Login', component: LoginComponent,  beforeEnter: (to, from, next) => {
//         if(to.path === '/login' && token){
//             next({name: 'Root'})
//         }else next({query: { redirect : to.path}})
//     }},
    
// ]
const routes = [
    {path:'/', name:'Root', component:ExampleComponent, meta:{requiresAuth:true}},
    {path:'/home', name:'Home',  component:HomeComponent, meta:{requiresAuth: true}},
    {path:'/create/user', name:'User',  component:CreateUserComponent},
    {path:'/forgot', name:'Forgot',  component:ForgotPassword},
    {path:'/reset', name:'Reset',  component:ResetPassword},
    {path:'/post/:id', name:'Detail',  component:PostDetailComponent, meta:{requiresAuth: true}},
    {path:'/create', name:'Create',  component:CreatePostComponent, meta:{requiresAuth: true}},
    {path:'/login', name:'Login', component:LoginComponent},
]

const router = new VueRouter({
    mode:'history',
    routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('userToken');
    console.log(token);
    if(to.matched.some(record =>record.meta.requiresAuth)){
        if(!token){
            next({
                path:'/login',
            })
        }else next()
    }else next()
    
})


export default router;