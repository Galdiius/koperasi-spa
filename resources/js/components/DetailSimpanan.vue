<template>
   <v-container>
        <h1>Detail simpanan</h1>
        <v-divider class="mt-5 mb-5"></v-divider>
        <v-progress-linear indeterminate v-show="loader"></v-progress-linear>
        <div id="printMe">
            <div class="card">
                <div class="card-header text-center">
                    <h1>Koperasi</h1>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Nama : </h5>
                    <p class="card-text"><pre>  {{ simpanan.anggota }}</pre></p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Tanggal : </h5>
                    <p class="card-text"><pre>  {{ simpanan.tanggal }}</pre></p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Jumlah : </h5>
                    <p class="card-text"><pre>  {{ simpanan.jumlah }}</pre></p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Jenis simpanan : </h5>
                    <p class="card-text"><pre>  {{ simpanan.jenis_simpanan }}</pre></p>
                </div>
                <div class="card-body">
                    <h5 class="card-title">petugas : </h5>
                    <p class="card-text"><pre>  {{ simpanan.petugas }}</pre></p>
                </div>
                <div class="card-footer text-muted">
                    <VueQrcode :value="`koperasi.com/detailSimpanan/${this.$route.params.id}`"/>
                </div>
            </div>
        </div>
            <v-btn color="success" link to="/simpanan">Kembali</v-btn>
            <v-btn color="primary" @click="print">print</v-btn>
    </v-container> 
</template>
<script>
import axios from 'axios'
import VueQrcode from 'vue-qrcode'
export default {
    components : {
        VueQrcode
    },
    mounted(){
        axios.get(`api/detailSimpanan?id=${this.$route.params.id}`).then(res=>{
            this.loader = false
            this.simpanan = res.data.data
        })

    },
    data(){
        return {
            simpanan : [],
            loader : true
        }
    },
    methods : {
        print(){
            this.$htmlToPaper('printMe')
        }
    }
}
</script>