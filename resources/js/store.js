import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex)


const store = new Vuex.Store({
    state:{
        token: localStorage.getItem('userToken'),
    },

    mutations:{
        setToken(state){
            state.token = localStorage.getItem('userToken')
        }
    },

    actions:{
        change({commit}){
            commit('setToken')
        }
    }

})

export default store;