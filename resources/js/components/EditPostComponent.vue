<template>
  <div :class="[showEdit ? 'overlay show' : 'overlay']">
          <div class="form-box bg-danger p-5">
              <i @click="closePost" style="font-size:25px" class="fa fa-times-circle"></i>
              <h3 class="text-white text-center">Edit Post</h3>
              <form @submit.prevent="update" class="form-group w-150">
                  <input v-model="post.title" class="form-control mb-3" type="text" placeholder="Title"/>
                  <textarea v-model="post.body" class="form-control mb-3" rows="2" cols="3" placeholder="Title"/>
                  <button type="submit" class="btn btn-warning btn-block">Update post</button>
              </form>
          </div>
  </div>
</template>

<script>
export default {
    props:{
        showEdit:Boolean,
        post:Object,
        closePost:Function,
        update:Function,
    }
}
</script>

<style>

</style>