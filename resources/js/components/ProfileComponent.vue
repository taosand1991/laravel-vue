<template>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7 offset-md-2 mt-5">
            <div class="card">
                <div class="card-header text-white text-center bg-success">
                    <h5>My Profile Header</h5>
                </div>
                <div class="card-body">
                    <h5 class="text-center">Name</h5>
                    <p class="text-center text-bold mb-4">{{user.name}}</p>
                    <h5 class="text-center">Email</h5>
                    <p class="text-center text-bold">{{user.email}}</p>
                    <div class="button-side">
                        <i class="fa fa-unlock"></i>
                        <h5 @click="navigation" class="text-center">change password</h5>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            user:{}
        }
    },
    mounted() {
        this.user = JSON.parse(localStorage.getItem('userProfile'));
    },
    methods: {
        navigation(){
            this.$router.push('/user/password/change')
        }
    }
}

</script>

<style>

</style>