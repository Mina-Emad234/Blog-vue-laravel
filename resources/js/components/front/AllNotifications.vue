<template>
    <div>
        <div class="card">
            <div class="card-header" v-if="notifications.length">
                <h3>Notifications : {{ notifications.length }}</h3>
            </div>
            <div class="card-body" v-if="notifications.length">
                <div class="media p-2" v-for="(n, i) in notifications" :key="i">
                    <img
                        class="mr-2"
                        style="height: 60px; width: 60px"
                        :src="n.data.comment_owner.profile_img"
                        alt="commenter image"
                    />
                    <div class="media-body">
                        <div class="mt-0">
                            <strong>{{ n.data.comment_owner.name }}</strong>
                            added a comment on your post
                        </div>
                        <i
                            class="fa fa-check float-right"
                            :class="n.read_at ? 'text-success' : 'text-danger'"
                            @click="markAsRead(n, $event)"
                        ></i>
                        <router-link
                            :to="`/post/${n.data.post.slug}`"
                            class="p-0"
                            target="_blank"
                            >{{ n.data.post.title }}</router-link
                        >
                        <p class="m-0">
                            <i class="fa fa-clock-o mr-1"></i
                            >{{n.data.commented_at}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    emits: ["updateUnreadNotification"],
    data() {
        return {
            notifications: [],
        };
    },
    mounted() {
        this.getAllNotifications();
    },
    methods: {
        getAllNotifications() {
            axios
                .get(`api/notifications`)
                .then((res) => {
                    if (!res.data.msg||res.data.msg!=undefined) {
                            this.notifications = res.data;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        // formatTime(date) {
        //     let d = new Date(date);
        //     return `${d.getFullYear()}/${d.getMonth()}/${d.getDate()}`;
        // },
        markAsRead(n, event) {
            axios
                .post(`api/markNotificationAsRead`, { id: n.id })
                .then((res) => {
                    // console.log(res);
                    if (res.data.msg == "ok") {
                        event.target.classList.remove("text-danger");
                        event.target.classList.add("text-success");
                         this.$store.dispatch('unreadNotifications')


                        }
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
<style scoped>
.media {
    border-bottom: 1px solid #999;
    padding: 5px;
}
.fa-check {
    cursor: pointer;
}
</style>
