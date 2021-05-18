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
                                <v-text-field outlined label="Kontak" :loading="loader" v-model="kontak" :rules="kontakRule"></v-text-field>
                                <v-text-field outlined type="date" v-model="tanggal" :loading="loader" label="Tanggal lahir(Untuk password login)"></v-text-field>
                                <v-btn color="success" @click="submit" :loading="loading">Submit</v-btn>
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
                        <v-card-subtitle class="text-center">{{ user.status_anggota }}</v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    mounted(){
        if(localStorage.getItem("kode_anggota")){
            axios.get(`api/getAnggotaById?id=${localStorage.getItem("kode_anggota")}`).then(res=>{
                this.loader = false
                this.user = res.data.data
                this.nama = res.data.data.nama
                this.kontak = res.data.data.kontak
                this.tanggal = res.data.data.tanggal_lahir
            })
        }
    },
    data(){
        return {
            loader : true,
            loading : false,
            user : [],
            nama : '',
            kontak : '',
            tanggal : '',
            namaRule : [
                v=>!!v || "Nama tidak boleh kosong"
            ],
            kontakRule : [
                v=>!!v || "Kontak tidak boleh kosong"
            ],
        }
    },
    methods:{
        submit(){
            if(this.$refs.form.validate()){
                this.loading = true
                axios.post('api/editAnggota',{
                    kode_anggota : localStorage.getItem('kode_anggota'),
                    nama : this.nama,
                    kontak : this.kontak,
                    tanggal : this.tanggal
                }).then(res=>{
                    this.loading = false
                    if(res.data.message == "berhasil"){
                        this.$fire({
                            title : "Berhasil",
                            type : "success",
                            text : "Data berhasil diubah"
                        })
                        axios.get(`api/getAnggotaById?id=${localStorage.getItem("kode_anggota")}`).then(res=>{
                            this.user = res.data.data
                            this.nama = res.data.data.nama
                            this.kontak = res.data.data.kontak
                            this.tanggal = res.data.data.tanggal_lahir
                        })
                    }
                })
            }
        }
    }
}
</script>