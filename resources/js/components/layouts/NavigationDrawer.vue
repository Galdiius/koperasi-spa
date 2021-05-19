<template>
    <v-navigation-drawer 
          v-model="sidebarMenu" 
          app
          floating
          :permanent="sidebarMenu"
          :mini-variant="mini()"
          
          :src="img"
          >
                <v-list dense color="" >
                    <v-list-item>
                        <v-list-item-action>
                            <v-icon color="white" @click.stop="sidebarMenu = !sidebarMenu">mdi-chevron-left</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title >
                                <h3 class="font-weight-thin white--text"><b>KOPERASI</b></h3>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <v-list>

                    <v-tooltip right>
                        <template v-slot:activator="{on,attrs}">
                            <v-list-item class="px-2">
                                <v-btn icon  @click="toggleMini = !toggleMini" v-bind="attrs" v-on="on">
                                    <v-icon color="white">{{ arrowIkon() }}</v-icon>
                                </v-btn>
                            </v-list-item>
                        </template>
                        <span>{{tooltip()}}</span>
                    </v-tooltip>

                    <v-divider></v-divider>

                    <!-- <v-tooltip right >
                        <template v-slot:activator="{on,attrs}">
                            <v-list-item link to="/" v-bind="attrs" v-on="on" v-show="user != ''">
                                <v-list-item-icon>
                                    <v-icon color="white">mdi-home-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content class="white--text">
                                    <v-list-item-title class="">Home</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                        <span>Home</span>
                    </v-tooltip> -->

                    <v-tooltip right v-for="item in items" :key="item.title">
                        <template v-slot:activator="{on,attrs}">
                            <v-list-item link :to="item.href" v-bind="attrs" v-on="on" v-show="item.level.indexOf(user.level) > -1">
                                <v-list-item-icon>
                                    <v-icon color="white">{{ item.icon }}</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content class="white--text">
                                    <v-list-item-title class="">{{ item.title }}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                        <span>{{ item.tooltip }}</span>
                    </v-tooltip>

                    <v-tooltip right>
                        <template v-slot:activator="{on,attrs}">
                            <v-list-item v-on="on" v-bind="attrs" class="" link @click="logout">
                                <v-list-item-icon>
                                    <v-icon color="white">mdi-logout</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content class="white--text">
                                    <v-list-item-title>Logout</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                        <span>Logout</span>
                    </v-tooltip>

                    <v-divider></v-divider>

                    <!-- <v-tooltip right>
                        <template v-slot:activator="{on,attrs}">
                            <v-list-item class="px-2" v-on="on" v-bind="attrs">
                                <v-btn color="white" icon @click="toggleMini = !toggleMini">
                                    <v-icon >{{ arrowIkon() }}</v-icon>
                                </v-btn>
                            </v-list-item>
                        </template>
                        <span>{{tooltip()}}</span>
                    </v-tooltip> -->
            </v-list>
        </v-navigation-drawer>
</template>
<script>
import axios from 'axios'
export default {
    mounted(){
        if(localStorage.getItem('kode_anggota')){
            this.user = {level:"Anggota"}
        }else{
            if(this.$route.name != 'login'){
                this.id_user = localStorage.getItem('adnajdnajdajdasjdadajnj')
                axios.get(`https://koperasi-spa.herokuapp.com/api/getUser?id=${this.id_user}`).then((res)=>{
                    this.user = res.data.data
                })
            }
        }
    },
    updated(){
        if(localStorage.getItem('kode_anggota')){
            this.user = {level:"Anggota"}
        }else{
            if(this.$route.name != 'login'){
                this.id_user = localStorage.getItem('adnajdnajdajdasjdadajnj')
                axios.get(`https://koperasi-spa.herokuapp.com/api/getUser?id=${this.id_user}`).then((res)=>{
                    this.user = res.data.data
                })
            }
            this.$watch('id_user',function(){
                this.id_user = localStorage.getItem('adnajdnajdajdasjdadajnj')
                axios.get(`https://koperasi-spa.herokuapp.com/api/getUser?id=${this.id_user}`).then((res)=>{
                    this.user = res.data.data
                })
            })
        }
    },
    data : () => ({
        user : '',
        id_user : '',
        img : 'https://i.postimg.cc/k4qwxbxf/rahul-gupta-y6a-XFoo-Xc-Rs-unsplash.jpg',
        toggleMini: true,
        cekLevel : false,
        items: [
            { title:"Home", href:"/", icon:"mdi-home-outline",tooltip:"Home",level:['Admin','Petugas','Anggota']},
            { title:"Jenis simpanan", href:"/jenisSimpanan", icon:"mdi-file",tooltip:"Jenis Simpanan",level:['Admin']},
            { title:"Petugas", href:"/petugas", icon:"mdi-account-check",tooltip:"Petugas",level:["Admin"]},
            { title:"Profile", href:"/about", icon:"mdi-account",tooltip:"Profile",level:["Admin","Petugas"]},
            { title:"Manage anggota", href:"/anggota", icon:"mdi-account-details",tooltip : "Manage anggota",level:["Admin","Petugas"]},
            { title:"Simpanan", href:"/simpanan", icon:"mdi-cash-multiple",tooltip:"Simpanan",level:["Admin","Petugas"]},
            { title:"Pinjaman", href:"/pinjaman", icon:"mdi-cash-register",tooltip:"Pinjaman",level:["Admin","Petugas"]},
            { title:"Penarikan", href:"/penarikan", icon : "mdi-cash",tooltip:"Penarikan",level:["Admin","Petugas"]},
            { title:"Edit Profile", href:"/editProfile", icon : "mdi-account",tooltip:"Edit Profile",level:["Anggota"]},
            { title:"History transaksi", href:"/history", icon : "mdi-cash-register",tooltip:"History transaksi",level:["Anggota"]},
            { title:"History", href:"/historyTransaksi", icon : "mdi-history",tooltip:"History",level:["Admin"]},
            { title:"Generate laporan", href:"/generateLaporan", icon : "mdi-clipboard",tooltip:"Generate Laporan",level:["Admin"]},
        ],
    }),
    props : ['sidebarMenu'],
    methods : {
        mini() {    
            return (this.$vuetify.breakpoint.smAndDown) || this.toggleMini
        },
        arrowIkon(){
            return this.toggleMini ? 'mdi-chevron-right' : 'mdi-chevron-left'
        },
        tooltip(){
            return this.toggleMini ? 'Maximize' : 'Minimize'
        },
        logout(){
            this.$fire({
                title : 'Apakah anda ingin logout?',
                type : 'question',
                showCancelButton : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((res)=>{
                if(res.value){
                    localStorage.clear()
                    this.$router.push({path:'/login'})
                }
            })
        },
        imgDrawer(){
            return !this.$vuetify.theme.dark ? 'https://i.postimg.cc/L6frGMNG/jeanne.jpg' : 'https://i.postimg.cc/26s0x1Ry/jalter.jpg' 
        },
        imgMount(){
            return !this.$vuetify.theme.dark ? 'https://i.postimg.cc/k496str3/peter-luo-Plx-VMoz-Id4-unsplash.jpg' : 'https://i.postimg.cc/k4qwxbxf/rahul-gupta-y6a-XFoo-Xc-Rs-unsplash.jpg' 
        }
    }
}
</script>
<style>
.v-navigation-drawer__content {
height: 100%;
overflow-y: auto;
overflow-x: hidden;
}
</style>