<template>
      <h1 class="my-4">{{category.name}}</h1>
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- Blog Post -->
            <div class="media simple-post" v-for="post in posts" :key="post.id">
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
                                <strong class="text-primary">{{
                                    post.user.name
                                }}</strong>
                            </span>
                        </li>
                        <li>|</li>
                        <li>
                            <span
                                ><i class="fa fa-calendar"></i
                                >{{ post.created_at }}</span
                            >
                        </li>
                        <li>|</li>
                        <span
                            ><i class="fa fa-comment"></i
                            >{{ post.comments_count }}</span
                        >
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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
            category: {},
            slug: this.$route.params.slug,
        };
    },
    created() {
        this.getPosts();
        this.getCategory();
    },
    watch: {
        $route(from,to){
            this.slug = this.$route.params.slug;
            this.getPosts();
            this.getCategory();
        }
    },
    methods: {
        getPosts() {
            axios.get(`/api/categories/${this.slug}/posts`)
                .then((res) => (this.posts=res.data))
                .catch((err) => console.log(err));
        },
        getCategory() {
            axios.get(`/api/categories/${this.slug}`)
                .then((res) => (this.category = res.data))
                .catch((err) => console.log(err));
        },
    },

};
</script>

<style></style>
