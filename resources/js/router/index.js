import { createRouter, createWebHistory } from 'vue-router';
import AllPosts from "../components/front/AllPosts.vue";
import PostDetails from "../components/front/PostDetails.vue";
import CategoryPosts from "../components/front/CategoryPosts.vue";
import Admin from "../components/Admin/Index.vue";


const routes = [
  {
    path: '/',
    name: 'AllPosts',
    component: AllPosts,
  },
  {
    path: '/post/:slug',
    name: 'PostDetails',
    component: PostDetails,
  },
  {
    path: '/categories/:slug/posts',
    name: 'CategoryPosts',
    component: CategoryPosts,
  },
  {
    path: '/admin',
    name: 'Admin',
    component: Admin,
  },
];

const router = createRouter({
  routes,
  mode: 'history',
  history: createWebHistory(),
});

export default router;
