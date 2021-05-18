import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state : {
        id_user : ''
    },
    mutations : {
        setIdUser(state,id){
            state.id_user = id 
        }
    }
})

export default store
