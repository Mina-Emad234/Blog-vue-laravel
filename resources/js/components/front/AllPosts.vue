<template>
  <div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-8">
      <!-- Blog Post -->
      <h3 v-if="isSearching">Search Results: {{searchPost}}</h3>
      <div class="media simple-post" v-for="post in posts.data" :key="post.id">
        <img class="mr-3" :src="post.image" :alt="post.title" />
        <div class="media-body">
          <h4 class="mt-0">
            <router-link :to="`/post/${post.slug}`">{{
              post.title
            }}</router-link>
          </h4>
          {{ post.body.substr(0, 200) }}
          <ul class="list-inline list-unstyled d-flex post-info">
            <li>
              <span
                ><i class="fa fa-user"></i> posted by :
                <strong class="text-primary">{{ post.user.name }}</strong>
              </span>
            </li>
            <li>|</li>
            <li>
              <span><i class="fa fa-calendar"></i>{{ post.created_at }}</span>
            </li>
            <li>|</li>
            <span><i class="fa fa-comment"></i>{{ post.comments_count }}</span>
          </ul>
        </div>
      </div>
      <Pagination :data="posts" @pagination-change-page="getPosts"></Pagination>
    </div>

    <div class="col-md-4">
      <!-- Search Widget -->
      <div class="card my-4">
        <h5 class="card-header">Search</h5>
        <div class="card-body">
          <div class="input-group">
            <input
              type="text"
              class="form-control"
              placeholder="Search for..."
              v-model="searchPost"
            />
            <span class="input-group-btn">
              <button class="btn btn-secondary" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div>

      <categories></categories>
    </div>
  </div>
</template>

<script>
import Categories from "./Categories.vue";

export default {
  components: { Categories },
  data() {
    return {
      posts: {},
      searchPost: "",
      isSearching: false,
    };
  },
  watch: {
    searchPost(query, old) {
      if (query.length > 0) {
        this.isSearching = true,
        axios
          .get(`/api/search_posts/${query}?page=1`)
          .then((res) => {
            this.posts = res.data
          })
          .catch((err) => {
            console.log(err);
          });

      } else {
        this.getPosts();
        this.isSearching = false;
      }
    },
  },
  mounted() {
    this.getPosts();
  },
  methods: {
    getPosts(page = 1) {
      axios
        .get(`/api/posts?page=${page}`)
        .then((res) => {
          this.posts = res.data;
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>

<style></style>
