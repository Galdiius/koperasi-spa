window.Vue = require('vue').default;
import Vuetify from '../plugins/vuetify'
import App from './components/App'
import router from './router'
import vueAlert from 'vue-simple-alert'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import axiosPlugin from 'vue-axios-cors'
import VueHtmlToPaper from 'vue-html-to-paper'

import store from './store'
import Vue from 'vue';
Vue.use(vueAlert)
Vue.use(axiosPlugin)
const opt = {
    specs : [
        "titlebar=no",
        "fullscreen=yes"
    ],
    styles : [
        "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
    ]
}
Vue.use(VueHtmlToPaper,opt)

window.addEventListener('storage',function(e){
    if(e.key == "adnajdnajdajdasjdadajnj"){
      localStorage.setItem('adnajdnajdajdasjdadajnj',e.oldValue)
    }else if(e.key == "level"){
        localStorage.setItem("level",e.oldValue)
    }else if(e.key == "login"){
        localStorage.setItem("login",e.oldValue)
    }else if(e.key == "kode_anggota"){
        localStorage.setItem("kode_anggota",e.oldValue)
    }
  })

const app = new Vue({
    vuetify: Vuetify,
    el: '#app',
    store,
    router: router,
    render: h => h(App)
});
