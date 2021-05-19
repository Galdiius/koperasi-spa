<template>
    <v-container>
        <h1>History transaksi</h1>
        <v-divider class="mt-5 mb-5"></v-divider>
        <v-data-table :headers="headers" mobile-breakpoint="true"  :items="history" no-data-text="Belum ada data history..." :loading="loader" loading-text="Sedang memuat data..."></v-data-table>
    </v-container>
</template>
<script>
import axios from 'axios'
export default {
    mounted(){
        axios.get('api/historyTransaksi').then(res=>{
            this.loader = false
            this.history = res.data.data
        })
    },
    data(){
        return {
            loader : true,
            history : [],
            headers : [
                {text:"Nama",align:"center",value:"namaAnggota"},
                {text:"tanggal",align:"center",value:"tanggal"},
                {text:"Jenis pembayaran",align:"center",value:"jenis_pembayaran"},
                {text:"Jumlah",align:"center",value:"jumlah"},
                {text:"Petugas",align:"center",value:"petugas"},
            ]
        }
    }
}
</script>