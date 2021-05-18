<template>
    <v-dialog
        transition="dialog-bottom-transition"
        max-width="600"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            color="success"
            v-bind="attrs"
            v-on="on"
            class="mb-5"
          >Tambah anggota</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="primary"
              dark
              class="justify-center"
            >
                <h3 class="text-center">Tambah anggota</h3>
            </v-toolbar>
            <v-card-text class="mt-5">
                <v-form ref="formTambah">
                    <v-text-field label="Nama" outlined v-model="nama" :rules="namaRule"></v-text-field>
                    <v-select outlined v-model="jk" :items="jenisKelamin" label="Jenis kelamin" :rules="jkRule"></v-select>
                    <v-text-field outlined type="date" :max="now" label="Tanggal lahir" v-model="tgl_lahir" :rules="tglRule"></v-text-field>
                    <v-textarea label="Alamat" outlined v-model="alamat" :rules="alamatRule"></v-textarea>
                    <v-text-field outlined label="Kontak" type="number" v-model="kontak" :rules="kontakRule"></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn color="success" @click="submit" :loading="loader">
                    Tambah
                </v-btn>
                <v-btn
                    color="red"
                    @click="dialog.value = false"
                >Close</v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
</template>
<script>
import axios from 'axios'
export default {
    created(){
        var utc = new Date().toJSON().slice(0,10).replace(/-/g,'-');
        this.now = utc
    },
    data(){
        return {
            nama : '',
            jk : '',
            tgl_lahir : '',
            now : '',
            loader : false,
            alamat : '',
            kontak : '',
            namaRule : [v=>!!v || "Nama tidak boleh kosong"],
            jkRule : [v=>  !!v || "field tidak boleh kosong"],
            tglRule : [v=>!!v || "field tidak boleh kosong"],
            alamatRule : [v=>!!v || "Alamat tidak boleh kosong"],
            kontakRule : [
                        v => !!v || "Kontak tidak boleh kosong",
                        v => this.onlyNumber(v) || "Kontak harus berupa number",
                        v => v.length>=12 || "Kontak tidak valid"
                        ],
            jenisKelamin : ['Laki-laki','Perempuan']
        }
    },
    methods:{
        submit(){
            if(this.$refs.formTambah.validate()){
                this.loader = true,
                axios.post('api/tambahAnggota',{
                    nama: this.nama,
                    jenisKelamin : this.jk,
                    tgl_lahir : this.tgl_lahir,
                    alamat : this.alamat,
                    kontak : this.kontak 
                }).then(res=>{
                    this.loader = false
                    if(res.data.message == "berhasil"){
                        this.$fire({
                            title : "Berhasil",
                            text : 'Data berhasil ditambahkan',
                            type : 'success'
                        })
                        this.$emit('update',res.data.data)
                    }
                }).then(err=>console.log(err))
            }
        },
        onlyNumber(v){
            if(isNaN(v)){
                return false
            }else{
                return true
            }
        }
    }
}
</script>