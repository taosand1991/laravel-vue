<template>
  <div class="container">
      <div class="row">
          <div class="flex justify-content-center mt-5">
              <p class="text-danger" v-if="error">{{error}}</p>
              <form @submit.prevent="submitEmail" class="form-inline">
                  <label class="mr-4" for="email">Email</label>
                  <input v-model="email" id="email" type="text" class="form-control mr-2" placeholder="email"/>
                  <button type="submit" class="btn btn-success btn-lg">send mail</button>
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
            error:''
        }
    },
    methods:{
        async submitEmail(){
            const emailObject = {
                email:this.email,
            };
         try {
            const response = await axios.post('/api/forgot', emailObject);
            console.log(response)
         } catch (e) {
         if(e){
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