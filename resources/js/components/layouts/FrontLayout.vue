<template>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#"></a>
      <UnreadNotifications />
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarResponsive"
        aria-controls="navbarResponsive"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item" v-show="isAdmin && isLogged" >
            <router-link class="nav-link" to="/admin">Admin
              <span class="sr-only">(current)</span>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/">Home
              <span class="sr-only">(current)</span>
            </router-link>
          </li>


          <li
            class="nav-item register-btn reg-login-btn"
            data-toggle="modal"
            data-target="#register-modal"
          >
            <a
                v-if="!isLogged"
              class="btn btn-info nav-link"
              href=""
              data-toggle="modal"
              data-target="#register-modal"
              >Register</a
            >
          </li>
          <li
          v-if="!isLogged"
            class="nav-item reg-login-btn"
            data-toggle="modal"
            data-target="#login-modal"
          >
            <a class="btn btn-primary text-weight nav-link" href="#">login</a>
          </li>
          <li
          v-if="isLogged"
            class="nav-item"
            @click.stop="logout"
          >
            <a class="nav-link" href="#">logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <slot name="pageContent"></slot>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">
        Copyright &copy; Your Website 2019
      </p>
    </div>
    <!-- /.container -->
  </footer>
  <!--modals-->
  <Register></Register>
  <Login></Login>
  <!--modals-->
</template>
<script>
import Register from '../front/Register.vue';
import Login from '../front/Login.vue';
import UnreadNotifications from '../front/UnreadNotifications.vue';
export default {
    components: { Register, Login, UnreadNotifications },
    computed:{
    isLogged(){
        return this.$store.getters.isLogged
    },
    isAdmin(){
        return this.$store.getters.isAdmin
    },
  },
  methods:{
    logout(){
        return this.$store.commit("LOGOUT")
    },
  },
};
</script>

<style>
</style>
