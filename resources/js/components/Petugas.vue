<template>
    <v-container>
        <h1>Petugas</h1>
        <v-divider class="mt-5 mb-5"></v-divider>
        <InputPetugas @update="handleUpdate"/>
        <v-divider class="mt-5 mb-5"></v-divider>
        <v-data-table :headers="headers" :loading="loader" :items="anggota" loading-text="Sedang memuat data..." no-data-text="Tidak ada data">
            <template v-slot:item="row">
                <tr align="center">
                    <td>{{ row.index+1 }}</td>
                    <td>{{ row.item.nama }}</td>
                    <td>{{ row.item.username }}</td>
                    <td>{{ row.item.level }}</td>
                    <td><EditUser :user="row.item" @update="handleUpdate"/>
                        <v-btn color="error" small @click="hapus(row.item.id_user,row.item.nama)">Hapus</v-btn>
                    </td>
                </tr>
            </template>
        </v-data-table>
    </v-container>
</template>
<script>
import InputPetugas from './plugins/InputPetugas'
import EditUser from './plugins/EditUser'
import axios from 'axios'
export default {
    mounted(){ 
        axios.get('api/userGet').then(res=>{
            this.loader = false
            this.anggota = res.data.data
        })

    },
    components : {
        InputPetugas,
        EditUser
    },
    data(){
        return {
            anggota : [],
            loader : true,
            headers : [
                {text:"No",align:"center",value:""},
                {text:"Nama",align:"center",value:"nama"},
                {text:"Username",align:"center",value:"username"},
                {text:"Level",align:"center",value:"level"},
                {text:"Aksi",align:"center",value:""}
            ]
        }
    },
    methods : {
        handleUpdate(v){
            this.anggota = v
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
                    axios.get(`api/hapusUser?id=${id}`).then(res=>{
                        if(res.data.message == "berhasil"){
                            this.$fire({
                                title : "Berhasil",
                                type : "success",
                                text : "User berhasil dihapus"
                            })
                            this.handleUpdate(res.data.data)
                        }
                    })
                }
            })
        }
    }
}
</script>