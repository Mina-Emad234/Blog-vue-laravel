import { createRouter, createWebHistory } from 'vue-router';
import AllPosts from "../components/front/AllPosts.vue";
import PostDetails from "../components/front/PostDetails.vue";
import CategoryPosts from "../components/front/CategoryPosts.vue";
import Admin from "../components/Admin/Index.vue";
import AllNotifications from "../components/front/AllNotifications.vue";


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
    {
    path: '/Notifications',
    name: 'Notifications',
    component: AllNotifications,
  },
];

const router = createRouter({
  routes,
  mode: 'history',
  history: createWebHistory(),
  linkActiveClass: "active",

});

export default router;
