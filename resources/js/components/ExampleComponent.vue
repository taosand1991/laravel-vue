<template>
    <div class="container mx-auto m-4">
        <div v-if='!loading' class="loading">
             <div class="spinner-border text-danger" role="status"></div>
        </div>
        <div class="row justify-content-center">
            <div v-for="post of posts" :key="post.id" class="card mb-4 ml-4" style="width:400px">
                <div class="card-header text-center">
                    <h5>{{post.title}}</h5>
                </div>
                <div class="card-body">
                    <router-link class="text-center" :to='`/post/${post.id}`'>{{post.users.name.toUpperCase()}}</router-link>
                    <p>{{post.body}}</p>
                    <small class="float-right">{{moment(post.created_at).fromNow()}}</small>
                    <div v-html="showEdited(post)"></div>
                </div>
                <div class="row container justify-content-center mx-auto py-4 px-4">
                    <button @click='editPost(post)' class="mr-4 btn btn-outline-primary btn-sm">Edit Post</button>
                    <button @click="deletePost(post.id)" type="button" class="btn btn-outline-danger btn-sm">Delete Post</button>
                </div>
            </div>
        </div> 
   <edit-post-component 
    :closePost='closePost'   
    :showEdit='showEdit' 
    :update='updatePost'
    :post='postForm' /> 
    </div>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
import moment, { HTML5_FMT } from 'moment';
import EditPostComponent from '../components/EditPostComponent';
Vue.prototype.moment = moment;

    export default {
        data:() => {
            return {
                posts:[],
                loading:false,
                postForm:{
                    title:'',
                    body:'',
                    id:0
                },
                showEdit:false,
            }
        },
        methods:{
             async getData(){
                 const token = localStorage.getItem('userToken');
                try {
                const response = await axios.get('/api/posts', {
                    headers:{'Authorization': `Bearer ${token}`}
                });
                this.posts = response.data['posts']
                console.log(response)
                this.loading = true;
                } catch (e) {
                console.log(e.response.data)
                }
            },
            goHome(){
                this.$router.push('/home')
            },
            async deletePost(id){
                this.loading = false;
                const token = localStorage.getItem('userToken');
                try {
                const response = await axios.get(`/api/post/delete/${id}`, {
                    headers:{'Authorization': `Bearer ${token}`}
                })
                setTimeout(() => {
                    this.loading = true;
                    this.getData()
                    alert('Your post has been deleted')
                }, 1500)
                } catch (e) {
                    console.log(e.response.data)
                }
            },
            editPost(post){
                this.postForm.title = post.title;
                this.postForm.body = post.body;
                this.postForm.id = post.id;
                this.showEdit = true;
            },
            closePost(){
                this.showEdit = false;
            },
            async updatePost(){
                this.loading = false;
                const token = localStorage.getItem('userToken');
                const postObject = {
                    title: this.postForm.title,
                    body: this.postForm.body,
                }
                try {
                 const response = await axios.put(`/api/post/edit/${this.postForm.id}`, postObject, {
                     headers:{'Authorization':`Bearer ${token}`}
                 })
                setTimeout(() => {
                    this.loading = true;
                    this.showEdit = false;
                    this.getData();
                    alert(response.data['message'])
                }, 2000)
                } catch (e) {
                    console.log(e.response.data)
                }
            },
            showEdited(post){
                if(post.updated_at > post.created_at){
                    return "<i class='fa fa-globe text-muted'>  edited</i>"
                }
            }
        },
        mounted: async function(){
            
            await this.getData()
            console.log('example')
        }
        
    }
</script>
