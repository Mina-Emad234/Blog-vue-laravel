<template>
      <!-- Edit Modal HTML -->
      <div id="editPostModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Post</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>title</label>
                                <input type="text" class="form-control" required v-model="postToEdit.title" />
                            </div>
                            <div class="form-group">
                                <label>body</label>
                                <textarea name="" cols="30" class="form-control" v-model="postToEdit.body" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label>category</label>
                                <select name="" class="form-control" v-if="postToEdit.category" v-model="postToEdit.category.id">
                                    <option disabled selected>choose category</option>
                                    <option v-fot="category in categories" :key="category.id">{{category.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>image</label>
                                <img :src="postToEdit.image" height="60" width="60" style="border:1px solid #999" alt="">
                                <input type="file" class="form-control" required @change="onImageChanged()" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                            <input type="submit" class="btn btn-success" value="edit" @click.prevent="updatePost" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    data(){
        return{
            categories:[],
        }
    },
    created(){
        this.getCategories();
    },
    methods:{
        getCategories() {
        axios
            .get(`/api/admin/categories`)
            .then((res) => {
                console.log(res);
                this.categories = res.data;
            })
            .catch((err) => console.log(err));
        },
        onImageChanged(event){
            console.log(event.target.files[0]);
            this.postToEdit.image = event.target.files[0];
        },
        updatePost(){
            let config = {
                headers:{"content-type":"multipart/form-data"}
            }
            let formdata = new FormData();
            formdata.append('title',this.postToEdit.title)
            formdata.append('body',this.postToEdit.body)
            formdata.append('image',this.postToEdit.image)
            formdata.append('category',this.postToEdit.categor.idy)
            formdata.append('id',this.postToEdit.id)
            axios
            .post(`/api/admin/posts/update`,formdata,config)
            .then((res) => {
                console.log(res);
                this.postToEdit.image=res.data.image;
                $("#editPostModal").modal('hide');
                $(".modal-backdrop").css('display',"none");
            })
        },
    },
    computed:{
        postToEdit(){
            return this.$store.getters.postToEdit
        },
    },
};
</script>

<style>

</style>
