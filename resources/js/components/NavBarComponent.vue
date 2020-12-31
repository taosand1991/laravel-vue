<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Laravel</a>
    <button class='navbar-toggler' type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li @click="close" class="nav-item"  >
          <router-link to='/'  class="nav-link active">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/profile">Profile</router-link>
        </li>
        <li v-if='user !== null' class="nav-item">
          <a @click.prevent='deleteUser' class="nav-link" href="#">Logout ({{profile.name}})</a>
        </li>
        <li v-else class="nav-item">
          <router-link to='/login' class="nav-link">login</router-link>
        </li>
      </ul>
      <ul v-if="user !== null" class="navbar-nav mx-auto">
          <li class="nav-item">
              <router-link to='/create' class="nav-link"><i class="fa fa-plus"/> Create Post</router-link>
          </li>
      </ul>
    </div>
  </div>
</nav>
</template>

<script>
import VueRouter from 'vue-router';
import store from '../store';
const { isNavigationFailure, NavigationFailureType } = VueRouter
export default {
    data(){
        return {
            user:'',
            loading:false,
            profile:{},
            disabled:false,
        }
    },
    mounted(){
        this.user = localStorage.getItem('userToken')
        const userName = localStorage.getItem('userProfile')
        const userProfile = JSON.parse(userName);
        this.profile = userProfile;
        const getLink = document.querySelectorAll('.nav-link');
      const navBar = document.querySelector('.navbar-collapse')
      getLink.forEach(link => {
        link.addEventListener('click', function(){
          navBar.classList.add('collapse');
          navBar.classList.remove('show');
          
        })
      })
    },
    methods:{
        async deleteUser(){
            this.loading = true;
            await localStorage.clear();
            store.commit('setToken')
            console.log(store.state.token);
               window.location.replace('/login')
        },
        close(){
          // $('.nav-link').on('click',function() {
          // $('.navbar-collapse').collapse('hide');
          // });
        }
    },
}
</script>

<style>

</style>