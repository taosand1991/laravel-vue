<template>
  <div class="container">
      <div v-if="!loading" class="loading">
           <div class="spinner-border text-danger" role="status"></div>
      </div>
      <div class="row mt-5">
          <div class="col-12 col-md-8 offset-md-2 justify-content-center">
              <h4 class="text-center">Create Your Post</h4>
              <form @submit.prevent="submitPost" class="form-group">
                  <input :style="[errors.title ? 'border:1px solid red': null ]" @input='getInput' name="title" v-model="postForm.title" class="form-control mb-2" placeholder="Title"/>
                  <small v-if='errors.title' class="text-danger">{{errors.title}}</small>
                  <textarea name="body" @input="getInput" v-model="postForm.body" class="form-control mb-2" placeholder="Post Description"/>
                    <small v-if='errors.body' class="text-danger">{{errors.body}}</small>
                  <button :disabled="postForm.title === '' || postForm.body === '' || errors['titles'] || errors['body']" type="submit" class="btn btn-success btn-sm btn-block">Create</button>
              </form>
          </div>
  </div>
  </div>
</template>

<script>
import axios from 'axios';


export default {
    data(){
        return {
            postForm:{
                title:'',
                body:''
            },
            loading:true,
            errors:{}
        }
    },
    methods:{
        async submitPost(){
            this.loading = false;
            const token = localStorage.getItem('userToken');
            const postObject = {
                title:this.postForm.title,
                body: this.postForm.body,
            }
            try {
            const response = await axios.post('/api/post/create', postObject, {
                headers:{'Authorization': `Bearer ${token}`}
            })
            setTimeout(() => {
                this.loading = true;
                this.postForm.title = '',
                this.postForm.body = ''
                this.$router.push('/')
            }, 1500)
            } catch (e) {
                this.loading = true;
                console.log(e.response.data)
            }
        },
        getInput(e){
            if(e.target.name === 'title'){
                if(this.postForm.title.trim() < 5){
                    console.log(this.errors)
                    this.$set(this.errors, 'title', 'your title must be more than 15 chars')
                }else delete this.errors['title']
            }
             if(e.target.name === 'body'){
                if(this.postForm.body.trim() < 20){
                    this.$set(this.errors, 'body', 'your body text must be more than 20 chars')
                }else delete this.errors['body']
            }
        }
    }
}
</script>

<style>

</style>