<template>
    <v-container>
        <h1>Pinjaman</h1>
        <v-divider class="mb-5"></v-divider>
        <InputPinjaman @update="handleUpdate"/>
        <v-divider class="mt-5"></v-divider>
        <v-data-table mobile-breakpoint="true"  :headers="headers" :items="pinjaman" :loading="loader" no-data-text="Tidak ada data" loading-text="Sedang memuat data..">
            <template v-slot:item="row">
                <tr class="text-center">
                    <td>{{ row.index+1 }}</td>
                    <td>{{ row.item.nama_anggota }}</td>
                    <td>{{ row.item.tanggal }}</td>
                    <td>{{ row.item.jumlah }}</td>
                    <td>{{ row.item.lama_pinjam }}</td>
                    <td>{{ row.item.jumlah_bayar }}</td>
                    <td>{{ row.item.nama }}</td>
                    <td>
                        <v-btn small color="primary" link :to="'/print/'+row.item.id_pinjaman">Detail</v-btn>
                        <!-- <v-btn color="error" small @click="hapus(row.item.id_pinjaman)">Hapus</v-btn> -->
                        <Angsuran :data="row.item" @update="handleUpdate"/>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-container>
</template>
<script>
import InputPinjaman from './plugins/InputPinjaman'
import Angsuran from './plugins/Angsuran'
import axios from 'axios'
export default {
    components:{
        InputPinjaman,
        Angsuran
    },
    data(){
        return {
            loader : true,
            pinjaman : [],
            headers : [
                {text:"No",align:"center",value:""},
                {text:"Nama peminjam",align:"center",value:"nama_anggota"},
                {text:"Tanggal pinjam",align:"center",value:"tanggal"},
                {text:"Jumlah",align:"center",value:"jumlah"},
                {text:"Lama pinjam",align:"center",value:"lama_pinjam"},
                {text:"Jumlah bayar",align:"center",value:"jumlah_bayar"},
                {text:"Nama petugas",align:"center",value:"nama"},
                {text:"Aksi",align:"center",value:""},
            ]
        }
    },
    methods:{
        handleUpdate(v){
            axios.get('api/getPinjaman').then(res=>{
                this.pinjaman = res.data.data
            })
        },
        hapus(id){
            this.$fire({
                title : "Peringatan",
                type : "warning",
                text : `Yakin ingin menghapus pinjaman ini?`,
                showCancelButton : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then(res=>{
                if(res.value){
                    axios.post('api/hapusPinjaman',{id:id}).then(res=>{
                        if(res.data.message == "berhasil"){
                            this.handleUpdate(res.data.data)
                            this.$fire({
                                title : "Berhasil",
                                text : "Data berhasil dihapus",
                                type : "success"
                            })
                        }
                    })
                }
            })
        }
    },
    mounted(){
        axios.get('api/getPinjaman').then(res=>{
            this.loader = false
            this.pinjaman = res.data.data
            if(this.pinjaman.length == 0){
                this.pinjaman = []
            }
        })
    }

}
</script>