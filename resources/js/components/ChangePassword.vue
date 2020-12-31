<template>
    <div class="container">
        <div class="row  mt-5">
            <div  v-show="loading" class="loading">
          <div class="spinner-border text-danger" role="status"></div>
      </div>
            <div class="col-12 col-md-8 offset-md-3">
                 <h5 class="text-center">CHANGE YOUR PASSWORD</h5>
                 <div v-if="errors.ext_password" class="alert alert-danger alert-dismissible fade show" role="alert">
                     {{errors.ext_password}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                </div>
                <div v-if="errors.password" class="alert alert-danger alert-dismissible fade show" role="alert">
                     {{errors.password}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                </div>
                
            <form @submit.prevent='submitPassword'>
                <div class="form-group">
                  <label for="old_password">Old password</label>
                  <input v-model="old_password"  type="password"  id="old_password" class="form-control mb-2" placeholder="Old password" />
                  <label for="new_password">New password</label>
                  <input v-model="new_password"  type="password"  id="new_password" class="form-control mb-2" placeholder="New password" />
                  <label for="new_password2">Confirm password</label>
                  <input v-model="new_password2"  type="password"  id="new_password2" class="form-control mb-2" placeholder="Confirm password" />
                    <button type="submit" class="btn btn-primary btn-block">update password</button>
                </div>
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
            old_password:'',
            new_password:'',
            new_password2:'',
            loading: false,
            errors:{}
        }
    },
    methods: {
        async submitPassword(){
            const token = localStorage.getItem('userToken');
            this.loading = true;
            const passwordObject = {
                old_password : this.old_password,
                password : this.new_password,
                password_confirmation : this.new_password2,
            }
            try {
                const response = await axios.post('/api/user/password', passwordObject, {
                    headers:{'Authorization': `Bearer ${token}`}
                })
                console.log(response)
                setTimeout(() => {
                    this.loading = false;
                    this.$router.push({
                        name:'Root',
                        params:{success: response.data['success']}
                    })
                }, 2000)
            } catch (error) {
                this.loading = false;
                // this.errors['ext_password'] = error.response.data['error'];
                this.$set(this.errors, 'ext_password', error.response.data['error'] )
                if(error.response.data['errors']) this.$set(this.errors, 'password', error.response.data['errors']['password'][0]) 
                console.log(this.errors)
            }
        }
    }

}
</script>

<style scoped>

</style>