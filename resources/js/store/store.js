import { createStore } from 'vuex'
import axios from "axios";


const types = {
    SET_USER_TOKEN:'SET_USER_TOKEN',
    REMOVE_USER_TOKEN:'REMOVE_USER_TOKEN',
    SET_USER:'SET_USER',
    LOGOUT:'LOGOUT',
    EDIT_POST:'EDIT_POST',
    SET_UNREAD_NOTIFICATIONS:'SET_UNREAD_NOTIFICATIONS',
};

const mutations = {
    [types.SET_USER_TOKEN](state,userToken){
        state.userToken = userToken;
        localStorage.setItem('userToken',JSON.stringify(userToken));
        axios.defaults.headers.common.Authorization = `Bearer ${userToken}`;
    },
    [types.REMOVE_USER_TOKEN](state){
        state.userToken = null;
        localStorage.removeItem('userToken');
    },
    [types.SET_USER](state,user){
        state.user = user;
        var user_id = state.user.id;
        Echo.connector.options.auth.headers.Authorization = `Bearer ${state.userToken}`;

        // Subscribe to a private channel
        const channel = Echo.private(`users.${user_id}`);

        // Handle incoming notifications
        channel.notification(handleNotification);

        // Define a function for handling notifications
        function handleNotification(notification) {
        // Log the notification to the console
        console.log(notification);

        // Add the notification to the state
        state.notifications.unshift(notification);
        }

        // Handle errors
        channel.error((error) => {
        // Log the error to the console
        console.error(error);
        });
        // Echo.private(`App.Models.User.${user_id}`)
        // .notification(function(notification) {
        //     console.log(notification);
        //     state.notifications.unshift(notification)
        // });
    },
    [types.LOGOUT](state){
        state.userToken = null;
        localStorage.removeItem('userToken');
        window.location.pathname="/";
    },
    [types.EDIT_POST](state,post){
        state.editedPost = post;
    },

    [types.SET_UNREAD_NOTIFICATIONS](state,notifications){
        state.notifications = notifications;
    },

};

const actions = {
    registerUser({commit},payload){
        axios.post(`/api/register`,payload)
        .then((res)=>{

            commit([types.SET_USER_TOKEN],res.data.token);
        })
        .catch((err)=>{
            console.log(err);
        })
    },

    unreadNotifications({commit}){
        axios
        .get(`api/unread-notifications`)
        .then((res) => {
            // this.$store.state.notifications = res.data;
            commit([types.SET_UNREAD_NOTIFICATIONS],res.data);

        })
        .catch((err) => {
        console.log(err);
        });
    },
    loginUser({commit},payload){
        axios.post(`/api/login`,payload)
        .then((res)=>{
            commit([types.SET_USER_TOKEN],res.data.token);
            axios.get('/api/user')
            .then((res)=>{
                commit([types.SET_USER],res.data.user);
                // console.log(res.data.user);
            })
        })
        .catch((err)=>{
            console.log(err);
        })
    },
};

const store = createStore({
    state: {
        userToken: null,
        user:null,
        editedPost:{},
        notifications:[],
    },

    mutations,
    actions,
    getters: {
        isLogged(state){
            if (state.user!=null) {
                return !!state.userToken;
            }else{
                return false;
            }
        },
        isAdmin(state){
            if (state.user!=null) {
                return state.user!=null && state.user.is_admin?true:false;
            }else{
                return false;
            }
        },
        postToEdit(state){
            return state.editedPost;
        },
    },
});
export default store;
