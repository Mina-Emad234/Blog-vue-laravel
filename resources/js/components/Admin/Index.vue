<template>
    <div id="cont">
        <div class="">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Posts</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addPostModal" class="btn btn-success" data-toggle="modal"><i
                                    class="material-icons">&#xE147;</i>
                                <span>Add New Post</span></a>

                            <a href="#deletePostModal" v-if="selectedPosts?.length" class="btn btn-danger"
                                data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                            <a href="#deletePostModalnopost" v-if="!selectedPosts?.length" class="btn btn-danger"
                                data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll" @click="selectAll"/>
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="posts.data?.length">
                        <tr v-for="(post,index) in posts.data" :key="index">
                            <td>
                                <span class="custom-checkbox">
                                    <input type="checkbox" :id="'checkbox' + index" @click.stop="selectPost(post,$event)"
                                     name="options[]" value="1" />
                                    <label :for="'checkbox1' + index"></label>
                                </span>
                            </td>
                            <td>{{post.title}}</td>
                            <td>{{post.body.substr(0,150)}}</td>
                            <td>
                                <span class="badge badge-info p-1 mb-1">{{(post.category.name)}}</span>
                            </td>
                            <td>
                                <img :src="post.image" style="width: 100px; height: 60px; border: 1px solid #e7e7e7" alt="" />
                            </td>
                            <td>{{post.user.name}}</td>
                            <td>
                                <a href='#editPostModal' class="edit" @click="editPost(post,$event)"
                                data-toggle="modal"><i class="material-icons" title="Edit">&#xE254;</i></a>
                                <a href="#deleteOnePostModal" class="delete" @click="getPost(post,$event)"
                                 data-toggle="modal"><i class="material-icons"
                                        data-toggle="tooltip" title="Delete">&#xE872;</i></a>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="clearfix">
                    <Bootstrap4Pagination :data="posts" @pagination-change-page="getPosts"></Bootstrap4Pagination>
                </div>
            </div>
        </div>
        <!-- Edit Modal HTML -->
        <div id="addPostModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Post</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>title</label>
                                <input type="text" class="form-control" required v-model="title" />
                            </div>
                            <div class="form-group">
                                <label>body</label>
                                <textarea name="" cols="30" class="form-control" v-model="body" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label>category</label>
                                <select name="" class="form-control" v-model="category">
                                    <option disabled selected>choose category</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>image</label>
                                <input type="file" id="add_file" :key="Math.random()" class="form-control" required @change="onImageChanged()" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                            <input type="button" class="btn btn-success" value="Add" @click.prevent="addPost" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <EditPost></EditPost>

        <!-- Delete Modal HTML -->
        <div id="deletePostModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Post</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete these Records?</p>
                            <p class="text-warning">
                                <small>Selected Posts : <strong>{{ selectedPosts?.length }}</strong></small>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                            <input type="button" class="btn btn-danger" @click="deletePosts" value="Delete" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Modal HTML -->
        <div id="deleteOnePostModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Post</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this post?</p>
                            <p class="text-warning">
                                <small><strong>{{ postToDelete.title }}</strong></small>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                            <input type="button" class="btn btn-danger" @click="deletePost" value="Delete" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Delete Modal HTML -->
        <div id="deletePostModalnopost" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Post</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>No post selected !</p>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel" />
                            <input type="submit" class="btn btn-danger" value="Delete" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import EditPost from "./EditPost.vue"
import { Bootstrap4Pagination } from 'laravel-vue-pagination';
export default {
    components: { EditPost,Bootstrap4Pagination },
    data(){
        return{
            posts:[],
            title:"",
            body:"",
            image:"",
            category:"",
            postToDelete:"",
            categories:[],
            selectedPosts : [],
        }
    },
    created(){
        this.checkAdmin();
        this.getPosts();
        this.getCategories();
    },
    methods:{
        getPosts(page = 1) {
        axios
            .get(`/api/admin/posts?page=${page}`)
            .then((res) => {
                // console.log(res);
                this.posts = res.data;
                localStorage.setItem("posts",JSON.stringify(this.posts));
            })
            .catch((err) => console.log(err));
        },
        getCategories() {
        axios
            .get(`/api/admin/categories`)
            .then((res) => {
                // console.log(res);
                this.categories = res.data;
            })
            .catch((err) => console.log(err));
        },
        onImageChanged(){
            this.image = document.getElementById('add_file').files[0];
        },
        addPost(){
            let config = {
                headers:{"content-type":"multipart/form-data"}
            }
            let formdata = new FormData();
            formdata.append('title',this.title)
            formdata.append('body',this.body)
            formdata.append('image',this.image)
            formdata.append('category',this.category)
            axios
            .post(`/api/admin/posts/add`,formdata,config)
            .then((res) => {
                console.log(res);
                this.title='';
                this.body='';
                this.image='';
                this.category='';
                this.getPosts();
                $("#addPostModal").modal('hide');
                $(".modal-backdrop").css('display',"none");
            })
        },
        editPost(post){
            this.$store.commit("EDIT_POST",post)
        },
        selectPost(post,event){
            let index = this.selectedPosts.indexOf(post.id)
            if (index > -1) {
                this.selectedPosts.splice(index,1)
                event.target.checked = false; //unchecked
            } else {
                this.selectedPosts.push(post.id)
                event.target.checked = true; //checked
            }
        },
        selectAll(event){
            if (event.target.checked) {
                $('input[type="checkbox"]').prop('checked',true);
                this.posts.data.forEach(p => {
                    this.selectedPosts.push(p.id)
                });
            } else {
                $('input[type="checkbox"]').prop('checked',false);
                this.selectedPosts = [];
            }
        },
        deletePosts(){
            axios.post(`/api/admin/posts/delete`,{posts_ids:this.selectedPosts})
                .then((res) => {
                    this.getPosts();
                    $('#deletePostModal').modal('hide')
                    $(".modal-backdrop").css('display',"none");
                    $('input[type="checkbox"]').prop('checked',false);
                })
                .catch((err) => console.log(err));
        },
        getPost(post){
            this.postToDelete=post
        },
        deletePost(){
            axios.post(`/api/admin/post/delete`,{slug:this.postToDelete.slug})
                .then((res) => {
                    this.getPosts();
                    $('#deleteOnePostModal').modal('hide')
                    $(".modal-backdrop").css('display',"none");
                })
                .catch((err) => console.log(err));
        },
        checkAdmin(){
             if(!this.$store.getters.isAdmin){
                this.$router.push('/')
             }
        },
    },

};
$(document).ready(function () {
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Select/Deselect checkboxes
    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function () {
        if (this.checked) {
            checkbox.each(function () {
                this.checked = true;
            });
        } else {
            checkbox.each(function () {
                this.checked = false;
            });
        }
    });
    checkbox.click(function () {
        if (!this.checked) {
            $("#selectAll").prop("checked", false);
        }
    });
});
</script>

<style scoped>
#cont {
    color: #566787;
    background: #f5f5f5;
    font-family: "Varela Round", sans-serif;
    font-size: 13px;
}

.table-wrapper {
    background: #fff;
    padding: 20px 25px;
    margin: 30px 0;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
}

.table-title {
    padding-bottom: 15px;
    background: #435d7d;
    color: #fff;
    padding: 16px 30px;
    margin: -20px -25px 10px;
    border-radius: 3px 3px 0 0;
}

.table-title h2 {
    margin: 5px 0 0;
    font-size: 24px;
}

.table-title .btn-group {
    float: right;
}

.table-title .btn {
    color: #fff;
    float: right;
    font-size: 13px;
    border: none;
    min-width: 50px;
    border-radius: 2px;
    border: none;
    outline: none !important;
    margin-left: 10px;
}

.table-title .btn i {
    float: left;
    font-size: 21px;
    margin-right: 5px;
}

.table-title .btn span {
    float: left;
    margin-top: 2px;
}

table.table tr th,
table.table tr td {
    border-color: #e9e9e9;
    padding: 12px 15px;
    vertical-align: middle;
}

table.table tr th:first-child {
    width: 60px;
}

table.table tr th:last-child {
    width: 100px;
}

table.table-striped tbody tr:nth-of-type(odd) {
    background-color: #fcfcfc;
}

table.table-striped.table-hover tbody tr:hover {
    background: #f5f5f5;
}

table.table th i {
    font-size: 13px;
    margin: 0 5px;
    cursor: pointer;
}

table.table td:last-child i {
    opacity: 0.9;
    font-size: 22px;
    margin: 0 5px;
}

table.table td a {
    font-weight: bold;
    color: #566787;
    display: inline-block;
    text-decoration: none;
    outline: none !important;
}

table.table td a:hover {
    color: #2196f3;
}

table.table td a.edit {
    color: #ffc107;
}

table.table td a.delete {
    color: #f44336;
}

table.table td i {
    font-size: 19px;
}

table.table .avatar {
    border-radius: 50%;
    vertical-align: middle;
    margin-right: 10px;
}

.pagination {
    float: right;
    margin: 0 0 5px;
}

.pagination li a {
    border: none;
    font-size: 13px;
    min-width: 30px;
    min-height: 30px;
    color: #999;
    margin: 0 2px;
    line-height: 30px;
    border-radius: 2px !important;
    text-align: center;
    padding: 0 6px;
}

.pagination li a:hover {
    color: #666;
}

.pagination li.active a,
.pagination li.active a.page-link {
    background: #03a9f4;
}

.pagination li.active a:hover {
    background: #0397d6;
}

.pagination li.disabled i {
    color: #ccc;
}

.pagination li i {
    font-size: 16px;
    padding-top: 6px;
}

.hint-text {
    float: left;
    margin-top: 10px;
    font-size: 13px;
}

/* Custom
    checkbox */

.custom-checkbox {
    position: relative;
}

.custom-checkbox input[type="checkbox"] {
    opacity: 0;
    position: absolute;
    margin: 5px 0 0 3px;
    z-index: 9;
}

.custom-checkbox label:before {
    width: 18px;
    height: 18px;
}

.custom-checkbox label:before {
    content: "";
    margin-right: 10px;
    display: inline-block;
    vertical-align: text-top;
    background: white;
    border: 1px solid #bbb;
    border-radius: 2px;
    box-sizing: border-box;
    z-index: 2;
}

.custom-checkbox input[type="checkbox"]:checked+label:after {
    content: "";
    position: absolute;
    left: 6px;
    top: 3px;
    width: 6px;
    height: 11px;
    border: solid #000;
    border-width: 0 3px 3px 0;
    transform: inherit;
    z-index: 3;
    transform: rotateZ(45deg);
}

.custom-checkbox input[type="checkbox"]:checked+label:before {
    border-color: #03a9f4;
    background: #03a9f4;
}

.custom-checkbox input[type="checkbox"]:checked+label:after {
    border-color: #fff;
}

.custom-checkbox input[type="checkbox"]:disabled+label:before {
    color: #b8b8b8;
    cursor: auto;
    box-shadow: none;
    background: #ddd;
}

/* Modal styles */

.modal .modal-dialog {
    max-width: 400px;
}

.modal .modal-header,
.modal .modal-body,
.modal .modal-footer {
    padding: 20px 30px;
}

.modal .modal-content {
    border-radius: 3px;
}

.modal .modal-footer {
    background: #ecf0f1;
    border-radius: 0 0 3px 3px;
}

.modal .modal-title {
    display: inline-block;
}

.modal .form-control {
    border-radius: 2px;
    box-shadow: none;
    border-color: #dddddd;
}

.modal textarea.form-control {
    resize: vertical;
}

.modal .btn {
    border-radius: 2px;
    min-width: 100px;
}

.modal form label {
    font-weight: normal;
}
</style>
