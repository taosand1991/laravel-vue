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
import NotFound from '../js/components/NotFound';
import ProfileComponent from '../js/components/ProfileComponent';
import ChangePassword from '../js/components/ChangePassword';
import UserPost from '../js/components/UserPost';


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
    {path:'/profile', name:'Profile', component:ProfileComponent, meta:{requiresAuth:true}},
    {path:'/:name/posts', name:'UserPost', component:UserPost, meta:{requiresAuth:true}},
    {path:'/user/password/change', name:'Change', component:ChangePassword, meta:{requiresAuth:true}},
    {path:'/404', name:'Error', component:NotFound},
    {path:'/home', name:'Home',  component:HomeComponent, meta:{requiresAuth: true}},
    {path:'/create/user', name:'User',  component:CreateUserComponent},
    {path:'/forgot', name:'Forgot',  component:ForgotPassword},
    {path:'/reset', name:'Reset',  component:ResetPassword},
    {path:'/post/:id', name:'Detail',  component:PostDetailComponent, meta:{requiresAuth: true}},
    {path:'/create', name:'Create',  component:CreatePostComponent, meta:{requiresAuth: true}},
    {path:'/login', name:'Login', component:LoginComponent},
    {path:'/*', redirect : '/404'},
]

const router = new VueRouter({
    routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('userToken');
    if(to.matched.some(record => record.meta.requiresAuth)){
        if(!token){
            next({
                path:'/login',
            })
        }else next();
    
    }else {
        if (to.path === '404' || token !== null){
            next({
                path:"/"
            })
        }else{
            next();
        }
    }
    
})


export default router;