<template>
  <div>
      <div class="row container ">
          <div v-if='!loading' class="loading">
           <div class="spinner-border text-danger" role="status"></div>
          </div>
          <div class="col-12 col-md-4 mt-3">
              <i style="font-size:160px" class="fa fa-newspaper-o"></i>
          </div>
          <div class="col-12 col-md-7 mt-3">
              <h3>{{post.title}}</h3>
              <small  class="text-muted float-right"><strong>Posted By</strong> : {{user.name}}</small><br>
              <p>{{post.body}}</p>
              <p class="float-right">{{moment(post.created_at).fromNow()}}</p>
          </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import Vue from 'vue';
Vue.prototype.moment = moment;
export default {
    data(){
        return {
            post:{},
            user:{},
            loading:false,
        }
    },
    methods:{
        async getPost(){
            const id = this.$route.params.id;
            const token = localStorage.getItem('userToken');
            try{
                const response = await axios.get(`/api/post/${id}`, {
                    headers:{'Authorization': `Bearer ${token}`}
                })
                this.post = response.data['post'];
                this.user = response.data['post'].users;
                this.loading = true;
            }catch(e){
                // console.log(e.response.data);
            }
        }
    },
     mounted(){
         this.getPost();
    }
}
</script>

<style>

</style>