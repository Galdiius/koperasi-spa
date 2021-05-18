<template>
    <v-dialog
        transition="dialog-top-transition"
        max-width="600"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            color="primary"
            v-bind="attrs"
            v-on="on"
          >Penarikan</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="primary"
              dark
            >Penarikan</v-toolbar>
            <v-card-text>
              <v-form ref="formPenarikan">
                <v-autocomplete @change="getJumlah" :rules="anggotaRule" :items="anggota" v-model="kode_anggota" label="Kode anggota" item-text="namaId"></v-autocomplete>
                <v-text-field type="date" label="Tanggal" v-model="tanggal" :rules="tanggalRule"></v-text-field>
                <v-text-field label="Jumlah" v-model="jumlah" :loading="loader" disabled ></v-text-field>
                <v-text-field label="Keterangan" v-model="keterangan" :rules="keteranganRule"></v-text-field>
                <v-card-actions class="justify-end">
                <v-btn
                    color="error"
                    @click="dialog.value = false"
                >Cancel</v-btn>
                <v-btn color="success" @click="submit">Submit</v-btn>
                </v-card-actions>
              </v-form>
            </v-card-text>
          </v-card>
        </template>
      </v-dialog>
</template>
<script>
import axios from 'axios'
export default {
    mounted(){
        axios.get('api/getAnggotaNamaIdFilter').then(res=>{
            this.anggota = res.data.data
        })
    },
    data(){
        return {
            loader : false,
            anggota : [],
            tanggal : '',
            jumlah : '',
            keterangan : '',
            kode_anggota : '',
            anggotaRule : [
                v => !!v || "Kode anggota tidak boleh kosong"
            ],
            tanggalRule : [
                v => !!v || "Tanggal tidak boleh kosong"
            ],
            keteranganRule : [
                v => !!v || "Keterangan tidak boleh kosong"
            ]
        }
    },
    methods:{
        getJumlah(e){
            let kode_anggota = e.split("#")[1]
            this.loader = true
            axios.get(`api/getSaldo?id=${kode_anggota}`).then(res=>{
                this.loader = false
                this.jumlah = res.data.data.jumlah
            })
        },
        submit(){
            if(this.$refs.formPenarikan.validate()){
                let kd = this.kode_anggota.split("#")[1]
                axios.post('api/penarikan',{
                    kode_anggota : kd,
                    tanggal : this.tanggal,
                    jumlah : this.jumlah,
                    keterangan : this.keterangan,
                    id_user : localStorage.getItem('adnajdnajdajdasjdadajnj')
                }).then(res=>{
                    if(res.data.message == "berhasil"){
                        this.$fire({
                            title : "Berhasil",
                            text : "Penarikan berhasil",
                            type : "success"
                        })
                        this.$emit('update',res.data.data)
                    }else if(res.data.message == "masih ada tagihan"){
                        this.$fire({
                            title : "Peringatan",
                            text : "Anggota masih memiliki pinjaman yang belum dilunasi",
                            type : "warning"
                        })
                    }
                })
            }
        }
    }
}
</script>