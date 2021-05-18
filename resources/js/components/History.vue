<template>
    <v-container>
        <h1>History transaksi</h1>
        <v-divider class="mt-5 mb-5"></v-divider>
        <v-data-table :headers="headers" :loading="loader" :items="items" no-data-text="Anda belum melakukan transaksi apapun">
            <template v-slot:item="row">
                <tr align="center">
                    <td>{{ row.index+1 }}</td>
                    <td>{{ row.item.tanggal }}</td>
                    <td>{{ row.item.jenis_pembayaran }}</td>
                    <td>{{ row.item.jumlah  }}</td>
                    <td>{{ row.item.nama  }}</td>
                </tr>
            </template>
        </v-data-table>
    </v-container>
</template>
<script>
import axios from 'axios'
export default {
    mounted(){
        axios.get(`api/getHistory?id=${localStorage.getItem('kode_anggota')}`).then(res=>{
            this.loader = false
            this.items = res.data.data
        })
    },
    data(){
        return {
            loader : true,
            items : [],
            headers : [
                {text:"No",align:"center",value:""},
                {text:"Tanggal",align:"center",value:"tanggal"},
                {text:"Jenis pembayaran",align:"center",value:"jenis_pembayaran"},
                {text:"Jumlah",align:"center",value:"jumlah"},
                {text:"Petugas",align:"center",value:"nama"},
            ]
        }
    }
}
</script>