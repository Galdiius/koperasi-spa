<template>
    <div>
        <v-container>
            <v-row>
                <v-col lg="8">
                    <v-card>
                        <v-card-title>
                            Edit profile
                        </v-card-title>
                        <v-card-text>
                            <v-form ref="form">
                                <v-text-field outlined label="Nama" :loading="loader" v-model="nama" :rules="namaRule"></v-text-field>
                                <v-text-field outlined label="Username" :loading="loader" v-model="username" :rules="usernameRule"></v-text-field>
                                <v-row v-if="hide">
                                    <v-col lg="6">
                                        <v-text-field :append-icon="newPassValue ? 'visibility' : 'visibility_off'"
                                                        @click:append="() => (newPassValue = !newPassValue)"
                                                        :type="newPassValue ? 'password' : 'text'"  outlined label="Password baru..." v-model="newPass" :rules="newPassRule"></v-text-field>
                                    </v-col>
                                    <v-col lg="6">
                                        <v-text-field :append-icon="newConPassValue ? 'visibility' : 'visibility_off'"
                                                        @click:append="() => (newConPassValue = !newConPassValue)"
                                                        :type="newConPassValue ? 'password' : 'text'" outlined label="Confirm password baru..." v-model="conNewPass" :rules="conNewPassRule"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-btn :color="iconPass()" class="mb-5" @click="hide = !hide">{{ ubahPass() }}</v-btn>
                                <v-text-field :append-icon="conPass ? 'visibility' : 'visibility_off'"
                                                        @click:append="() => (conPass = !conPass)"
                                                        :type="conPass ? 'password' : 'text'" outlined label="Confirm password" v-model="password" :rules="passwordRule"></v-text-field>
                                <v-btn color="success" @click="submit" :loading="loadingBtn">Submit</v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col lg="4">
                    <v-card class="pa-5" :loading="loader">
                        <v-card-title class="justify-center">
                            <div v-show="!loader">
                                <v-avatar height="100px" width="100px">
                                    <img src="https://i.postimg.cc/bv2CMhqB/anime3.png">
                                </v-avatar>
                            </div>
                        </v-card-title>
                        <v-card-title class="justify-center">{{ user.nama }}</v-card-title>
                        <v-card-subtitle class="text-center">{{ user.level }}</v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script>
import Navbar from './Navbar'
import axios from 'axios'
export default {
    data(){
        return {
            newPassValue : true,
            newConPassValue : true,
            loadingBtn : false,
            conPass : true,
            loader : true,
            user : {},
            hide : false,
            nama : '',
            username : '',
            password : '',
            newPass : '',
            conNewPass : '',
            namaRule : [
                v => !!v || "Nama tidak boleh kosong"
            ],
            usernameRule : [
                v => !!v || "Username tidak boleh kosong"
            ],
            newPassRule : [
                v => !!v || "Field harus di isi",
                v => v.length >= 8 || "Panjang password minimal 8 karakter"
            ],
            conNewPassRule : [
                v => !!v || "Field harus di isi"
            ],
            passwordRule : [
                v => !!v || "Password harus di isi"
            ]
        }
    },
    beforeMount(){
        let id = localStorage.getItem('adnajdnajdajdasjdadajnj')
        axios.get(`api/getUser?id=${id}`).then((res)=>{
            this.loader = false
            this.user = res.data.data
            this.nama = this.user.nama
            this.username = this.user.username
        })
    },
    components : {
        Navbar
    },
    methods:{
        ubahPass(){
            return this.hide ? 'Cancel' : 'Ubah password'
        },
        iconPass(){
            return this.hide ? 'red' : 'warning'
        },
        submit(){
            if(this.$refs.form.validate()){
                this.loadingBtn = true
                if(this.nama == this.user.nama && this.username == this.user.username){
                    this.loadingBtn = false
                    this.$fire({
                        title : "Peringatan",
                                text : 'Anda tidak melakukan perubahan',
                                type : 'warning'
                            })
                }else{
                    if(this.hide){
                        if(this.newPass == this.conNewPass){
                            axios.post('api/updateUser',{
                                id : localStorage.getItem('adnajdnajdajdasjdadajnj'),
                                nama : this.nama,
                                username : this.username,
                                newPassword : this.newPass,
                                password : this.password
                            }).then(res=>{
                                this.loadingBtn = false
                                if(res.data.message == "berhasil"){
                                    this.$fire({
                                        title : "Berhasil",
                                        text : 'Data berhasil diubah',
                                        type : 'success'
                                    })
                                    let id = localStorage.getItem('adnajdnajdajdasjdadajnj')
                                    axios.get(`api/getUser?id=${id}`).then((res)=>{
                                        this.user = res.data.data
                                        this.nama = this.user.nama
                                        this.username = this.user.username
                                    })
                                }else{
                                    this.$fire({
                                        title : "Error",
                                        text : 'Password yang anda masukan salah',
                                        type : 'error'
                                    })
                                }
                            })
                        }else{
                            this.loadingBtn = false
                            this.$fire({
                                title : "Gagal",
                                text : 'Password baru tidak sesuai',
                                type : 'error'
                            })
                        }
                    }else{
                        axios.post('api/updateUser',{
                            id : localStorage.getItem('adnajdnajdajdasjdadajnj'),
                            nama : this.nama,
                            username : this.username,
                            password : this.password
                        }).then(res=>{
                            console.log(res);
                            this.loadingBtn = false
                            if(res.data.message == "berhasil"){
                                this.$fire({
                                    title : "Berhasil",
                                    text : 'Data berhasil diubah',
                                    type : 'success'
                                })
                                let id = localStorage.getItem('adnajdnajdajdasjdadajnj')
                                axios.get(`api/getUser?id=${id}`).then((res)=>{
                                    this.user = res.data.data
                                    this.nama = this.user.nama
                                    this.username = this.user.username
                                })
                            }else{
                                this.$fire({
                                    title : "Error",
                                    text : 'Password yang anda masukan salah',
                                    type : 'error'
                                })
                            }
                        })
                    }
                }
            }
        }
    }
}
</script>