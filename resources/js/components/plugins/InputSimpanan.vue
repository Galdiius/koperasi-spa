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
            class="mb-5"
          >Input simpanan</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="primary"
              dark
            >Input simpanan</v-toolbar>
            <v-card-text>
                <v-form ref="formSimpanan">
                    <v-select :rules="simpanRule" :items="jenis_simpanan" item-text="jenis_simpanan" label="Pilih jenis simpanan" @change="jenisSimpanan"></v-select>
                    <v-text-field :rules="jumlahRule" label="Jumlah" v-model="jumlah" :disabled="disable"></v-text-field>
                    <v-autocomplete :rules="anggotaRule" v-model="kode_anggota" :items="anggota" item-text="namaId" dense filled label="Nama anggota"></v-autocomplete>
                    <v-card-actions class="justify-end">
                        <v-btn color="success" @click="submit" :loading="loader">Submit</v-btn>
                        <v-btn color="error" @click="dialog.value = false">Close</v-btn>
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
    created(){
        axios.get('api/getJenisSimpanan').then(res=>{
            this.jenis_simpanan = res.data.data
        })
        axios.get('api/getAnggotaNamaId').then(res=>{
            this.anggota = res.data.data
        })
    },
    data(){
        return {
            loader : false,
            disable : true,
            anggota : [],
            jumlah : '0',
            jenis_simpan : '',
            kode_anggota:'',
            jenis_simpanan : [],
            simpanRule : [
                v=>!!v || "Pilih jenis simpanan!!"
            ],
            anggotaRule : [
                v=>!!v || "Anggota tidak boleh kosong"
            ],
            jumlahRule : [
                v=>!!v || "Jumlah tidak boleh kosong"
            ]
        }
    },
    methods:{
        jenisSimpanan(e){
            if(e == "simpanan pokok"){
                this.jumlah = this.jenis_simpanan[0].jumlah
                this.disable = true
                this.jenis_simpan = 1
            }else if(e == "simpanan wajib"){
                this.jumlah = this.jenis_simpanan[1].jumlah
                this.disable = true
                this.jenis_simpan = 2
            }else if(e == "simpanan sukarela"){
                this.jumlah = ''
                this.disable = false
                this.jenis_simpan = 3
            }
        },
        submit(){
            if(this.$refs.formSimpanan.validate()){
                this.loader = true
                axios.post('api/inputSimpanan',{
                    id_jenis : this.jenis_simpan,
                    jumlah : this.jumlah,
                    kode_anggota : this.kode_anggota,
                    id_user : localStorage.getItem('adnajdnajdajdasjdadajnj')
                }).then(res=>{
                    this.loader = false
                    if(res.data.message == "berhasil"){
                        this.$fire({
                            title : "Berhasil",
                            text : "Data berhasil disubmit",
                            type : "success"
                        })
                        this.$emit('update',res.data.data)
                    }else if(res.data.message == "sudah"){
                        this.$fire({
                            title : "Peringatan",
                            text : "Anggota sudah membayar simpanan pokok",
                            type : "warning"
                        })
                    }else if(res.data.message == "belum membayara pokok"){
                        this.$fire({
                            title : "Peringatan",
                            text : "Anggota belum membayar simpanan pokok",
                            type : "warning"
                        })
                    }else if(res.data.message == "Anggota tidak aktif"){
                        this.$fire({
                            title : "Peringatan",
                            type : "warning",
                            text : "Anggota tidak aktif"
                        })
                    }
                })
            }
        }
    }
}
</script>