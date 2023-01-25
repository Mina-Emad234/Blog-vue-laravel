<template>
    <!--register-->
    <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="login-form">
                        <form @submit="submitRegister" enctype="multipart/form-data" novalidate>
                            <h2 class="text-center">Create New Account</h2>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="name" v-model="name" />
                                <div v-show="nameError" class="text-danger">
                                    ...Invalid name
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="email" v-model="email" />
                                <div v-show="emailError" class="text-danger">
                                    ...Invalid email
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" v-model="password" />
                                <div v-show="passwordError" class="text-danger">
                                    ...Invalid password
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="file" id="file" class="form-control-file" @change="image_upload()"/>
                                <div v-show="imageError" class="text-danger">
                                    ...Not allowed extension
                                </div>
                                <div v-show="!imageError && imageSizeError" class="text-danger">
                                    ...size must be less than 2 m
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block"
                                    :disabled="!isValidForm">
                                    Create Account
                                </button>
                            </div>
                            <div class="clearfix">
                                <a href="#" class="pull-right">Forgot Password?</a>
                            </div>
                        </form>
                        <p class="text-center">
                            having account ?
                            <strong class="switch-tologin-modal"><a href="#">Login</a></strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            profile_img: '',
            imageError:false,
            imageSizeError:false,
        };
    },
    computed: {
        nameError() {
            return this.name.length > 0 && this.name.length < 4;
        },
        emailError() {
            return !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) && this.email.length > 0;
        },
        passwordError() {
            return this.password.length > 0 && this.password.length < 7;
        },
        isValidForm() {
            return this.name.length >= 4 && this.password.length > 7 &&
                (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) && !this.imageError && !this.imageSizeError;
        },

    },
    methods: {
        image_upload(){
            var size = 0;
           this.profile_img = document.getElementById('file').files[0];
           var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if(this.profile_img != null){
                var ext = allowedExtensions.exec(this.profile_img.name);
                this.imageError = !ext;
                size = parseFloat(this.profile_img.size / (1024 * 1024)).toFixed(2);
                this.imageSizeError = size > 2;
            }
        },
        submitRegister() {

            let Data = new FormData();
            Data.append('name', this.name);
            Data.append('email', this.email);
            Data.append('password', this.password);
            Data.append('profile_img', this.profile_img);
            this.$store.dispatch('registerUser',Data);
        },
    },
};
</script>

<style>

</style>
