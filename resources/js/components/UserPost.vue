<template>
  <div class="container">
      <div class="row d-flex">
          <div class="col-12 col-md-4">
              <div class="text-center">
                <div class="image-fram">
                    <div class="round-about">
                        <i class="fa fa-user"></i>
                    </div>
                </div>
              </div>
              <div class="text-center">
                  <h6><i>E-mail</i></h6>
                  <h4>{{user.email}}</h4><br>
                  <hr>
                  <h6><i>Name</i></h6>
                  <h4>{{user.name}}</h4>
              </div>
          </div>
          <div class="col-12 col-md-7">
              <div class="text-center">
              <h5>Posts associated with User</h5>
              <ul v-for="post in posts" :key='post.id' class="list-group">
                    <li class="list-group-item mb-2">
                       <router-link :to='`/post/${post.id}`'>{{post.title}}</router-link>
                    </li>
              </ul>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    data(){
        return {
            posts:[],
            user:{},
            loading:true,
        }
    },
    methods:{
       async  getUserPost(){
           const name = this.$route.params.name;
           const token = localStorage.getItem('userToken');
           try {
               const response = await axios.get(`/api/posts/${name}`, {
                   headers:{'Authorization': `Bearer ${token}`}
               })
               this.loading = false;
               this.posts = response.data['posts'];
               this.user = response.data['user'];
           } catch (error) {
               console.log(error.response.data)
           }
        }
    },
    async mounted(){
        await this.getUserPost();
    }
}
</script>

<style>

</style>