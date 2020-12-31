<template>
    <div class="container">
         <div  v-show="loading" class="loading">
          <div class="spinner-border text-danger" role="status"></div>
      </div>
        <div class="row justify-content-center mt-4">
            <form @submit.prevent='submitPassword' class="form-group col-12 col-md-7">
                <div>
                    <h5 class="text-center">Reset Password</h5>
                    <p class="text-danger text-center" v-if="error">{{error}}</p>
                  <label for="password">Password</label>
                  <input type="password" v-model="passwordInfo.password"
                    class="form-control mb-2"  id="password"  placeholder="Password">
                    <label for="password2">Confirm password</label>
                  <input type="password" v-model="passwordInfo.password2"
                    class="form-control mb-2"  id="password2"  placeholder="confirm password">  
                    <button type="submit" class="btn btn-primary btn-block">update password</button> 
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data(){
        return {
            passwordInfo:{
                password: '',
                password2:'',
            },
            loading:false,
            error:''

        }
    },
    methods:{
        async submitPassword(){
            this.loading = true;
            const passwordObject = {
                password:this.passwordInfo.password,
                password_confirmation:this.passwordInfo.password2,
                token: this.$route.query.token,
                email: this.$route.query.email,
            }
            try {
             const response = await axios.post('/api/reset', passwordObject)
            if(response.status === 200){
                setTimeout(() => {
                    this.loading = false
                    this.$router.push({
                        name:'Login',
                        params:{success: response.data['status']}
                    })
                }, 1500)
            }
            } catch (e) {
                this.loading = false;
                if(e.response.status === 500){
                    this.error = 'something is wrong, please try again later'
                }
                this.error = e.response.data['status'][0]
                console.log(e.response.data)
            }
        }
    },
    mounted(){
        console.log(this.$route.query.token)
        console.log(this.$route.query.email)
    }
}
</script>

<style>

</style>