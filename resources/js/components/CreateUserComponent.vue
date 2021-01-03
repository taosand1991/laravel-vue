<template>
  <div class="container">
      <div  v-show="loading" class="loading">
          <div class="spinner-border text-danger" role="status"></div>
      </div>
        <div class="jumbotron w-50 mt-5 col-6 offset-3">
            <h5 class="text-center mb-2">CREATE YOUR ACCOUNT</h5>
            <form @submit.prevent="submitUser">
                <div class="form-group">
                    <input  v-model='userAccount.name' type="text" class="form-control mb-2" placeholder="Full Name"/>
                    <input v-model='userAccount.email' type="text" class="form-control mb-2" placeholder="Enter email"/>
                    <input v-model='userAccount.password' type="password" class="form-control mb-2" placeholder="Enter Password"/>
                    <div  v-if="errors.password"><small class="text-danger mb-2">{{errors.password}}</small></div>
                    <input @input="changePassword" v-model='userAccount.password2' type="password" class="form-control mb-2" placeholder="Confirm password"/>
                </div>
                <button type="submit" class="btn btn-success btn-block">Create</button><br>
                <p class="text-center">Already user? <router-link to='/login'>Login</router-link></p>

            </form>
        </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
    data(){
        return {
            userAccount:{
                name:'',
                email:'',
                password:'',
                password2:'',
            },
            errors: {},
            loading:false,
        }
    },
    methods:{
        async submitUser(){
            this.loading = true;
            const userObject = {
                name : this.userAccount.name,
                email: this.userAccount.email,
                password: this.userAccount.password,
                password2: this.userAccount.password2,
            };
            try {
            const response = await axios.post('/api/create', userObject);
            setTimeout(() => {
                this.loading = false;
                localStorage.setItem('userToken', response.data['token'])
                localStorage.setItem('userProfile', JSON.stringify(response.data['user']))
                this.$router.push('/')
            }, 1500)
            } catch (e) {
                this.loading = false;
                console.log(e.response.data)
            }
        },
        changePassword(){
            if(this.userAccount.password2 !== this.userAccount.password){
                this.errors['password'] = 'password does not match'
            }else delete this.errors['password']
        }
    }
}
</script>

<style>

</style>