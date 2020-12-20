<template>
  <div class="container">
      <div  v-show="loading" class="loading">
          <div class="spinner-border text-danger" role="status"></div>
      </div>
        <div class="jumbotron w-50 mt-5 col-6 offset-3">
            <div v-if="$route.params.success">
          <p class="text-danger text-center">{{$route.params.success}}</p>
      </div>
            <h5 class="text-center mb-2">SIGN IN TO YOUR ACCOUNT</h5>
            <p v-if="error" style="color:red;" class="text-center mb-2">{{error}}</p>
            <form @submit.prevent="onSubmit">
                <div class="form-group">
                    <input v-model='form.email' type="text" class="form-control mb-2" placeholder="Enter email"/>
                    <input v-model='form.password' type="password" class="form-control" placeholder="Enter Password"/>
                </div>
                <button type="submit" class="btn btn-success btn-block">LOGIN</button><br>
                <p class="text-center">New user? <router-link to='/create/user'>Register</router-link></p>
                 <div class="text-center">
                 <router-link to='/forgot' >Forgot password?</router-link>
                 </div>
            </form>
        </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    data:() => {
        return {
            form:{
                email:'',
                password:'',
            },
             loading:false,
             error:''
        } 
    },
    methods:{
        async onSubmit(){
            const loginObject = {
                email:this.form.email,
                password:this.form.password,
            };
            console.log(loginObject)
            this.loading = true;
            try {
             const response = await axios.post('/api/login', loginObject)
             await localStorage.setItem('userToken', response.data['token'])
             JSON.stringify(localStorage.setItem('userProfile', response.data['user']))
             setTimeout(() => {
                 this.loading = false;
                 window.location.href = '/'
             }, 2000)
          
            } catch (e) {
                this.loading = false;
                this.error = e.response.data['errors']
                console.log(e.response.data)
            }
        }
    },
    mounted(){
        console.log(this.$router)
    }
}
</script>

<style>

</style>