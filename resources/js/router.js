import Vue from 'vue'
import router from 'vue-router'
import Home from './components/Home'
import Login from './components/Auth/Login'
import Register from './components/Auth/Register'
import About from './components/About'
import Anggota from './components/Anggota'
import Simpanan from './components/Simpanan'
import Pinjaman from './components/Pinjaman'
import Print from './components/plugins/CetakStruk'
import Penarikan from './components/Penarikan'
import Petugas from './components/Petugas'
import LoginAnggota from './components/Auth/LoginAnggota'
import JenisSimpanan from './components/JenisSimpanan'
import History from './components/History'
import EditProfile from './components/EditProfile'
import HistoryTransaksi from './components/HistoryTransaksi'
import GenerateLaporan from './components/GenerateLaporan'
import DetailSimpanan from './components/DetailSimpanan'
import axios from 'axios'
Vue.use(router)

function cekLogin(){
    axios.get('api/cekLogin').then(res=>{
        
    })
}
const routes = new router({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Home,
            name: 'home',
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    next()
                }
            },
        },
        {
            path: '/login',
            component: Login,
            name: 'login',
            beforeEnter: (to, from, next) => {
                if (localStorage.getItem('login')) {
                    next({ name: 'home' })
                } else {
                    next()
                }
            },
        },
        {
            path: '/loginAnggota',
            component: LoginAnggota,
            name: 'login',
            beforeEnter: (to, from, next) => {
                if (localStorage.getItem('login')) {
                    next({ name: 'home' })
                } else {
                    next()
                }
            },
        },
        { path: '/register', component: Register, name: 'register' },
        {
            path:'/about',
            component:About,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin" || localStorage.getItem('level') == "Petugas"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/anggota',
            component : Anggota,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin" || localStorage.getItem('level') == "Petugas"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/simpanan',
            component : Simpanan,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin" || localStorage.getItem('level') == "Petugas"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/detailSimpanan/:id',
            component : DetailSimpanan,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin" || localStorage.getItem('level') == "Petugas"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/pinjaman',
            component : Pinjaman,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin" || localStorage.getItem('level') == "Petugas"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/print/:id',
            component : Print,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin" || localStorage.getItem('level') == "Petugas"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/Penarikan',
            component : Penarikan,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin" || localStorage.getItem('level') == "Petugas"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/petugas',
            component : Petugas,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/generateLaporan',
            component : GenerateLaporan,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/jenisSimpanan',
            component : JenisSimpanan,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/historyTransaksi',
            component : HistoryTransaksi,
            beforeEnter: (to, from, next) => {
                if (!localStorage.getItem('login')) {
                    next({ name: 'login' })
                } else {
                    if(localStorage.getItem('level') == "Admin"){
                        next()
                    }else{
                        next({path:from.path})
                    }
                }
            },
        },
        {
            path : '/history',
            component : History,
            beforeEnter : (to,from,next) =>{
                if(!localStorage.getItem('login')){
                    next({name:'login'})
                }else{
                    next()
                }
            }
        },
        {
            path : '/editProfile',
            component : EditProfile,
            beforeEnter : (to,from,next) =>{
                if(!localStorage.getItem('login')){
                    next({name:'login'})
                }else{
                    next()
                }
            }
        },
    ]
})

export default routes
