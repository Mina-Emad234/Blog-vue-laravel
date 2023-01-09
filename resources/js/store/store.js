import { createStore } from 'vuex'
import axios from "axios";


const types = {
    SET_USER_TOKEN:'SET_USER_TOKEN',
    REMOVE_USER_TOKEN:'REMOVE_USER_TOKEN',
    SET_USER:'SET_USER',
    LOGOUT:'LOGOUT',
    EDIT_POST:'EDIT_POST',
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
    },
    [types.LOGOUT](state){
        state.userToken = null;
        localStorage.removeItem('userToken');
        window.location.pathname="/";
    },
    [types.EDIT_POST](state,post){
        state.editedPost = post;
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
    loginUser({commit},payload){
        axios.post(`/api/login`,payload)
        .then((res)=>{
            commit([types.SET_USER_TOKEN],res.data.token);
            axios.get('api/user')
            .then((res)=>{
                console.log(err.data);
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
    },

    mutations,
    actions,
    getters: {
        isLogged(state){
            return !!state.userToken;
        },
        isAdmin(state){
            return state.user.is_admin;
        },
        postToEdit(state){
            return state.editedPost;
        },
    },
});
export default store;
