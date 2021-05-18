<template>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="400"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="warning"
          dark
          v-bind="attrs"
          v-on="on"
          small
        >
            Angsuran
        </v-btn>
      </template>
      <v-card>
        <v-card-title class="headline">
            Angsuran {{data.nama_anggota}}
            <v-simple-table width="400">
                <template v-slot:default>
                    <thead>
                        <tr align="center">
                            <td>Tanggal</td>
                            <td>Jumlah</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in angsuran" :key="item.id_angsuran">
                            <td>{{ item.tanggal }}</td>
                            <td>{{ item.jumlah_bayar }}</td>
                            <td><v-btn color="success" @click="bayar(item.id_angsuran,item.id_pinjaman,item.jumlah_bayar)">Bayar</v-btn></td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-card-title>
        <v-card-text></v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            text
            @click="dialog = false"
          >
            Tutup
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>
<script>
import axios from 'axios'
export default {
    mounted(){
        this.$watch('data',function(){
            this.id = this.data.id_pinjaman
            axios.get(`api/getAngsuran?id=${this.id}`).then(res=>{
                this.angsuran = res.data.data
            })
        })
        this.id = this.data.id_pinjaman
        axios.get(`api/getAngsuran?id=${this.id}`).then(res=>{
            this.angsuran = res.data.data
        })
            console.log(this.data)
    },
    data(){
        return {
            dialog : false,
            angsuran : [],
            id : ''
        }
    },
    methods : {
        bayar(id_angsuran,id_pinjaman,jumlah){
            this.$fire({
                title : "Peringatan",
                type : "warning",
                text : `Konfirmasi pembayaran angsuran ini`,
                showCancelButton : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then(res=>{
                if(res.value){
                    axios.post('api/bayarAngsuran',{id_angsuran : id_angsuran,id_pinjaman:id_pinjaman,jumlah:jumlah,id_user:localStorage.getItem('adnajdnajdajdasjdadajnj'),kode_anggota : this.data.kode_anggota}).then(res=>{
                        if(res.data.dialog == "buka"){
                            this.angsuran = res.data.angsuran
                            this.$fire({
                                title : "Berhasil",
                                text : "Pembayaran berhasil",
                                type : "success"
                            })
                        }else{
                            
                            this.$fire({
                                title : "Berhasil",
                                text : "Pembayaran berhasil",
                                type : "success"
                            })
                            this.dialog = false
                            this.$emit('update')
                        }
                    })
                }
            })
        }
    },
    props: ['data']
}
</script>