<template>
    <v-container>
        <h1>Generate Laporan</h1>
        <v-divider class="mt-5 mb-5"></v-divider>
        <v-form ref="form">
            <v-text-field @change="akhir = false" type="date" label="Mulai" v-model="tanggalMulai" :rules="rule"></v-text-field>
            <v-text-field @change="preview" :disabled="akhir" type="date" label="Akhir" :min="tanggalMulai" v-model="tanggalAkhir" :rules="rule"></v-text-field>
            
            <div id="laporan" v-show="laporan">
                <v-divider class="mt-3 mb-3"></v-divider>
                <h3>Laporan</h3>
                <v-divider class="mt-3 mb-3"></v-divider>
                <h4>Simpanan</h4>
                <v-data-table :headers="headerSimpanan" :items="simpanan"></v-data-table>
                <v-divider class="mt-3 mb-3"></v-divider>
                <h4>Pinjaman</h4>
                <v-data-table :headers="headerPinjaman" :items="pinjaman"></v-data-table>
                <v-divider class="mt-3 mb-3"></v-divider>
                <h4>Penarikan</h4>
                <v-data-table :headers="headerPenarikan" :items="penarikan"></v-data-table>
                <v-divider class="mt-3 mb-3"></v-divider>
            </div>
            <v-progress-linear indeterminate class="mb-3" v-show="loading"></v-progress-linear>
            <v-btn color="success" @click="generate" :loading="loader">Generate</v-btn>
        </v-form>
    </v-container>   
</template>
<script>
import axios from 'axios'
export default {
    components : {
        
    },
    data(){
        return {
            loader : false,
            disable : true,
            laporan : false,
            loading : false,
            akhir : true,
            tanggalMulai : "",
            headerSimpanan : [
                {text:"No",align:"center",value:""},
                {text:"Tanggal",align:"center",value:"tanggal"},
                {text:"Jenis simpanan",align:"center",value:"simpanan"},
                {text:"Jumlah",align:"center",value:"jumlah"},
                {text:"Anggota",align:"center",value:"anggota"},
                {text:"Petugas",align:"center",value:"petugas"},
            ],
            headerPenarikan : [
                {text:"No",align:"center",value:""},
                {text:"Tanggal",align:"center",value:"tanggal"},
                {text:"Anggota",align:"center",value:"anggota"},
                {text:"Jumlah",align:"center",value:"jumlah"},
                {text:"Petugas",align:"center",value:"petugas"},
            ],
            headerPinjaman : [
                {text:"No",align:"center",value:""},
                {text:"Tanggal",align:"center",value:"tanggal"},
                {text:"Anggota",align:"center",value:"anggota"},
                {text:"Jumlah",align:"center",value:"jumlah"},
                {text:"Lama pinjam",align:"center",value:"lama_pinjam"},
                {text:"Jumlah bayar",align:"center",value:"jumlah_bayar"},
                {text:"Petugas",align:"center",value:"petugas"},
            ],
            tanggalAkhir : "",
            simpanan : [],
            pinjaman : [],
            penarikan : [],
            rule : [
                v=>!!v || "Tanggal tidak boleh kosong"
            ]
        }
    },
    methods:{
        generate(){
            if(this.$refs.form.validate()){
                this.loader = true
                axios({
                    url : "api/laporan?m="+this.tanggalMulai+"&&a="+this.tanggalAkhir,
                    method : "GET",
                    responseType : "blob"
                }).then(response=>{
                    this.laporan = false
                    this.loader = false
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', `Laporan ${this.tanggalMulai}-${this.tanggalAkhir}.pdf`);
                    document.body.appendChild(link);
                    link.click();
                })
            }
        },
        preview(){ 
            this.loading = true
            axios.post('api/getLaporanBetween',{
                awal : this.tanggalMulai,
                akhir : this.tanggalAkhir
            }).then(res=>{
                this.loading = false
                this.laporan = true
                this.simpanan = res.data.dataSimpanan
                this.pinjaman = res.data.dataPinjaman
                this.penarikan = res.data.dataPenarikan
            })
        }
    }
}
</script>