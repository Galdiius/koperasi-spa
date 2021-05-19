<template>
    <v-container>
        <h1>Penarikan</h1>
        <v-divider class="mb-5 mt-5"></v-divider>
        <Penarikan @update="handleUpdate"/>
        <v-divider class="mb-5 mt-5"></v-divider>
        <h1>History penarikan</h1>
        <v-data-table mobile-breakpoint="true"  :headers="headers" :items="penarikan" :loading="loader"></v-data-table>
    </v-container>
</template>
<script>
import axios from 'axios'
import Penarikan from './plugins/InputPenarikan'
export default {
    mounted(){
        axios.get('api/getPenarikan').then(res=>{
            this.loader = false
            this.penarikan = res.data.data
        })
    },
    components : {
        Penarikan
    },
    data(){
        return {
            loader : true,
            penarikan : [],
            headers:[
                {text:"Nama",align:"center",value:"nama"},
                {text:"Tanggal",align:"center",value:"tanggal"},
                {text:"Jumlah",align:"center",value:"jumlah"},
                {text:"Petugas",align:"center",value:"petugas"},
                {text:"Keterangan",align:"center",value:"ket"}
            ]
        }
    },
    methods : {
        handleUpdate(v){
            this.penarikan  = v
        }
    }
}
</script>