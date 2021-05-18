<template>
    <v-container>
        <h1>Simpanan</h1>
        <v-divider class="mb-5"></v-divider>
        <InputSimpanan @update="handleUpdate"/>
        <v-divider class="mb-5"></v-divider>
        <h3 class="mb-3">History simpanan</h3>
        <v-divider class="mb-5 mt-5"></v-divider>
        <h5 class="mb-3">Petunjuk :</h5>
        <v-chip class="white--text" color="deep-purple">Simpanan pokok</v-chip>
        <v-chip class="white--text" color="green">Simpanan wajib</v-chip>
        <v-chip color="warning">Simpanan sukarela</v-chip>
        <v-divider class="mb-5 mt-5"></v-divider>
        <v-data-table :headers="headers" :items="dataSimpanan" :loading="loader" no-data-text="Belum data apapun" loading-text="Sedang memuat data..">
            <template v-slot:item="row">
                <tr align="center">
                    <td>{{ row.item.id_simpanan }}</td>
                    <td>{{ row.item.nama }}</td>
                    <td>{{ row.item.tanggal }}</td>
                    <td><v-chip class="white--text" :color="warna(row.item.jenis_simpanan)">{{ row.item.jenis_simpanan }}</v-chip></td>
                    <td>{{ row.item.jumlah }}</td>
                    <td>{{ row.item.nama_petugas }}</td>
                    <td><v-btn color="primary" small link :to="'/detailSimpanan/'+row.item.id_simpanan">Detail</v-btn></td>
                </tr>
            </template>
        </v-data-table>
    </v-container>
</template>
<script>
import axios from 'axios'
import InputSimpanan from './plugins/InputSimpanan'
export default {
    mounted(){
        axios.get('api/dataSimpanan').then(res=>{
            this.loader = false
            this.dataSimpanan = res.data.data
            if(this.dataSimpanan.length == 0){
                this.dataSimpanan = []
            }
        }).catch(err=>{
            console.log(err)
        })
    },
    data(){
        return{
            loader : true,
            dataSimpanan : [],
            headers : [
                {text:"Id simpanan",align:"center",value:"id_simpanan"},
                {text:"Nama anggota",align:"center",value:"nama"},
                {text:"Tanggal",align:"center",value:"tanggal"},
                {text:"Jenis",align:"center",value:"jenis_simpanan"},
                {text:"Jumlah",align:"center",value:"jumlah"},
                {text:"Nama petugas",align:"center",value:"nama_petugas"},
                {text:"Aksi",align:"center",value:""},
            ]
        }
    },
    components:{
        InputSimpanan
    },
    methods:{
        handleUpdate(v){
            axios.get('api/dataSimpanan').then(res=>{
                this.dataSimpanan = res.data.data
            })
        },
        warna(js){
            if(js == "simpanan pokok"){
                return "deep-purple"
            }else if(js == "simpanan wajib"){
                return "success"
            }else if(js == "simpanan sukarela"){
                return "warning"
            }
        }
    }

}
</script>