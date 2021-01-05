<template>
  <div class="container">
       <div  v-show="loading" class="loading">
          <div class="spinner-border text-danger" role="status"></div>
      </div>
      <div class="row">
          <div class="flex justify-content-center mt-5">
              <p class="text-danger" v-if="error">{{error}}</p>
              <form @submit.prevent="submitEmail" class="form-inline mx-3 my-3">
                  <label class="mr-4" for="email">Email</label>
                  <input v-model="email" id="email" type="text" class="form-control mr-2" placeholder="email"/>
                  <button type="submit" class="btn btn-success btn-lg mt-md-0 mt-2">send mail</button>
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
            email:'',
            error:'',
            loading:false,
        }
    },
    methods:{
        async submitEmail(){
            this.loading = true;
            const emailObject = {
                email:this.email,
            };
         try {
            const response = await axios.post('/api/forgot', emailObject);
            setTimeout(() => {
                this.$router.push({
                    name:'Login',
                    params:{success: response.data['status']}
                });
            }, 2000)
         } catch (e) {
         if(e){
             this.loading = false;
             console.log(e.response.data)
         this.error = e.response.data['message']['email'][0]
         }
         }

        }   
    }
}
</script>

<style>

</style>