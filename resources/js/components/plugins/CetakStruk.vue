<template>
    <v-container>
        <v-progress-linear v-show="loaderStruk" indeterminate></v-progress-linear>
        <div id="printMe">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Koperasi</h1>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Nama : </h5>
                    <p class="card-text"><pre>  {{ data[0].nama_anggota }}</pre></p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Tanggal : </h5>
                    <p class="card-text"><pre>  {{ data[0].tanggal }}</pre></p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Jumlah : </h5>
                    <p class="card-text"><pre>  {{ data[0].jumlah }}</pre></p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Lama pinjam : </h5>
                    <p class="card-text"><pre>  {{ data[0].lama_pinjam }}</pre></p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Jumlah bayar : </h5>
                    <p class="card-text"><pre>  {{ data[0].jumlah_bayar }}</pre></p>
                </div>
                <div class="card-footer text-muted">
                    <VueQrcode :value="`https://koperasi-spa.herokuapp.com/print/${this.$route.params.id}`"/>
                </div>
            </div>
        </div>
            <v-btn color="success" link to="/pinjaman">Kembali</v-btn>
            <v-btn color="primary" @click="print">print</v-btn>
    </v-container>
</template>
<script>
import axios from 'axios'
import VueQrcode from 'vue-qrcode'
axios.defaults.baseURL = 'https://koperasi-spa.herokuapp.com/';
export default {
    components : {
        VueQrcode
    },
    mounted(){
        axios.get(`api/printPinjaman?id=${this.$route.params.id}`)
            .then(res=>{
                this.loaderStruk = false
                this.data = res.data.data
            })
    },
    data(){
        return {
            dialog : false,
            data : [],
            loaderStruk : true,
        }
    },
    methods:{
        print(){
            this.$htmlToPaper('printMe')
        }
    }
}
</script>