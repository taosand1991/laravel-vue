<template>
    <div class="container mx-auto m-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Home Component</div>

                    <div class="card-body">
                        <h5>Hello Home component</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted(){
        console.log('home mounted')
    }
}
</script>