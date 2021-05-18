<template>
    <v-container>
        <h1>Jenis simpanan</h1>
        <v-divider class="mt-5 mb-5"></v-divider>
        <!-- <IjenisSimpanan @update="handleUpdate"/> -->
        <v-divider class="mt-5 mb-5"></v-divider>
        <v-data-table :headers="header" :items="jenisSimpanan" :loading="loader" loading-text="Sedang memuat data">
            <template v-slot:item="row">
                <tr align="center">
                    <td>{{ row.index+1 }}</td>
                    <td>{{ row.item.jenis_simpanan }}</td>
                    <td>{{ row.item.jumlah }}</td>
                    <td><EjenisSimpanan :jSimpanan="row.item" @update="handleUpdate" /></td>
                </tr>
            </template>
        </v-data-table>
    </v-container>
</template>
<script>
import IjenisSimpanan from './plugins/InputJenisSimpanan'
import EjenisSimpanan from './plugins/EditJenisSimpanan'
import axios from 'axios'
export default {
    mounted(){
        axios.get('api/jenisSimpanan').then(res=>{
            this.loader = false
            this.jenisSimpanan = res.data.data
        })
    },
    components:{
        IjenisSimpanan,
        EjenisSimpanan
    },
    data(){
        return {
            loader : true,
            jenisSimpanan : [],
            header : [
                {text : "No",align:"center",value:""},
                {text : "Jenis simpanan",align:"center",value:"jenis_simpanan"},
                {text : "Jumlah",align:"center",value:"jumlah"},
                {text : "Aksi",align:"center",value:""}
            ]
        }
    },
    methods:{
        handleUpdate(v){
            this.jenisSimpanan = v
        }
    }
}
</script>