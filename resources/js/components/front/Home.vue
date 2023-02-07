<template>
    <front-layout>
        <template v-slot:pageContent>
            <div class="container intro-container">
                <router-view></router-view>
                <!-- <div class="row"> -->
                <!-- Blog Entries Column -->
                <!-- <div class="col-md-8">
            <h1 class="my-4">
              Page Heading
              <small>Secondary Text</small>
            </h1> -->

                <!-- Pagination -->
                <!-- <nav aria-label="...">
              <ul class="pagination float-right">
                <li class="page-item disabled">
                  <span class="page-link">Previous</span>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active">
                  <span class="page-link">
                    2
                    <span class="sr-only">(current)</span>
                  </span>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav>
          </div> -->
                <!-- Sidebar Widgets Column -->

                <!-- </div> -->
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </template>
    </front-layout>
</template>

<script>
import FrontLayout from "../layouts/FrontLayout.vue";
export default {
    components: { FrontLayout },
    created() {
        this.updateToken();
        this.setUser();
    },
    methods: {
        updateToken() {
            var token = JSON.parse(localStorage.getItem("userToken"));
            this.$store.commit("SET_USER_TOKEN", token);
        },
        setUser() {
            if (this.$store.state.user == null) {
                axios.get("/api/user").then((res) => {
                    this.$store.commit("SET_USER", res.data.user);
                })
            }else{
                this.$store.commit("SET_USER", null);
            }

        },
    },
};

</script>

<style></style>
