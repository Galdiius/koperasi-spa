<template>
    <v-container>
        <h1 class="mb-5">Manage anggota</h1>
        <v-divider class="mb-5"></v-divider>
        <TambahAnggota @update="handleUpdate"/>
        <v-data-table 
        :headers="header"
        :items="anggota"
        item-key="nama"
        class="elevation-1"
        :search="search"
        :custom-filter="filterOnlyCapsText"
        loading-text="Sedang memuat data.."
        :loading="loader"
        >
        <template v-slot:top>
            <v-text-field
            v-model="search"
            label="Search"
            class="mx-4"
            ></v-text-field>
        </template>
        <template v-slot:item="row">
            <tr class="text-center">
                    <td>{{ row.index+1 }}</td>
                    <td>{{ row.item.kode_anggota }}</td>
                    <td>{{ row.item.nama }}</td>
                    <td>{{ row.item.jenis_kelamin }}</td>
                    <td>{{ row.item.tanggal_gabung }}</td>
                    <td>
                        <DetailAnggota :alamat="row.item.alamat" :kontak="row.item.kontak" :tglGabung="row.item.tanggal_gabung" :status="row.item.status_anggota" :tgl="row.item.tanggal_lahir" :nama="row.item.nama" :kode_anggota="row.item.kode_anggota" :saldo="row.item.jumlah" :jk="row.item.jenis_kelamin"/>
                        <v-btn small color="error" @click="hapus(row.item.kode_anggota,row.item.nama)">Hapus</v-btn>
                        <EditAnggota :user="row.item" @update="handleUpdate"/>
                    </td>
                    <td>
                        <v-chip :color="cekStatus(row.item.status_anggota)">{{ row.item.status_anggota }}</v-chip>
                    </td>
                </tr>
        </template>
        </v-data-table>
    </v-container>
</template>
<script>
import TambahAnggota from './plugins/TambahAnggota'
import DetailAnggota from './plugins/DetailAnggota'
import EditAnggota from './plugins/EditAnggota'
import axios from 'axios'
export default {
    beforeMount(){
        axios.get('api/getAnggota').then(res=>{
            this.loader = false
            this.anggota = res.data.data
            console.log(res.data)
        })
    },
    data(){
        return {
            loader : true,
            search : '',
            anggota : [],
            header : [
                {text:"No",align:"center",value:""},
                {text:"Kode_anggota",align:"center",value:"kode_anggota"},
                {text:"Nama",align:"center",value:"nama"},
                {text:"Jenis kelamin",align:"center",value:"jenis_kelamin"},
                {text:"Tanggal_gabung",align:"center",value:"tanggal_gabung"},
                {text:"Action",align:'center',value:""},
                {text:"Status",align:'center',value:"status_anggota"}
            ]
        }
    },
    methods : {
        cekStatus(status){
            if(status == 'Tidak aktif'){
                return 'error'
            }else{
                return 'success'
            }
        },
        handleUpdate(v){
            this.anggota = v
            console.log(v)
        },
        filterOnlyCapsText (value, search, item) {
            return value != null &&
            search != null &&
            typeof value === 'string' &&
            value.toString().toLocaleLowerCase().indexOf(search) !== -1    
        },
        hapus(id,nama){
            this.$fire({
                title : "Peringatan",
                type : "warning",
                text : `Apakah anda akan menghapus ${nama}?`,
                showCancelButton : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then(res=>{
                if(res.value){
                    axios.get(`api/cekTransaksiAnggota?id=${id}`).then(res=>{
                        if(res.data.message == "Masih ada angsuran"){
                            this.$fire({
                                title : "Peringatan",
                                type : "warning",
                                text : "Anggota masih memiliki angsuran"
                            })
                        }else if(res.data.message == "Anggota masih memiliki saldo"){
                            this.$fire({
                                title : "Peringatan",
                                type : "warning",
                                text : "Anggota masih memiliki saldo"
                            })
                        }else if(res.data.message == "Hapus diizinkan"){
                            axios.post('api/deleteAnggota',{id:id}).then(res=>{
                                if(res.data.message == "berhasil"){
                                    this.$fire({
                                        title:"Berhasil",
                                        type : "success",
                                        text : "Anggota berhasil di hapus"
                                    })
                                    this.handleUpdate(res.data.data)
                                }
                            })
                        }
                    })
                }
            })
        }
    },
    components : {
        TambahAnggota,
        DetailAnggota,
        EditAnggota
    }
}
</script>