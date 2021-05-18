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
            small
          >Edit</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="primary"
              dark
              class="mb-3"
            >
                <h3>Edit profile {{ user.nama }}</h3>
            </v-toolbar>
            <v-card-text>
                <v-form ref="formEdit">
                    <v-text-field v-model="id" disabled></v-text-field>
                    <v-text-field label="Nama" outlined v-model="txtNama" :rules="namaRule"></v-text-field>
                    <v-select outlined :items="jenisKelamin" label="Jenis kelamin" v-model="jk" :rules="jkRule"></v-select>
                    <v-text-field outlined type="date" label="Tanggal lahir" v-model="tgl_lahir" :rules="tglRule"></v-text-field>
                    <v-textarea label="Alamat" outlined v-model="alamat" :rules="alamatRule"></v-textarea>
                    <v-text-field outlined label="Kontak" v-model="kontak" :rules="kontakRule"></v-text-field>
                    <v-select outlined :items="statusItem" label="status" v-model="status"></v-select>
                </v-form>
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn @click="submit" color="success" :loading="loader">submit</v-btn>
              <v-btn
                @click="dialog.value = false"
              color="error">Close</v-btn>
            </v-card-actions>
          </v-card>
        </template>
      </v-dialog>
</template>
<script>
import axios from 'axios'
export default {
    props : ['user'],
    mounted(){
        this.$watch('user',function(){
            this.id = this.user.kode_anggota
            this.txtNama = this.user.nama
            this.jk = this.user.jenis_kelamin
            this.tgl_lahir = this.user.tanggal_lahir
            this.alamat = this.user.alamat
            this.kontak = this.user.kontak
            this.status = this.user.status_anggota
        })
    },
    data(){
        return {
            loader : false,
            id : this.user.kode_anggota,
            txtNama : this.user.nama,
            jk : this.user.jenis_kelamin,
            tgl_lahir : this.user.tanggal_lahir,
            alamat : this.user.alamat,
            kontak : this.user.kontak,
            status : this.user.status_anggota,
            jenisKelamin : ['Laki-laki','Perempuan'],
            statusItem : ['Aktif','Tidak aktif'],
            namaRule : [
                v=>!!v || "Nama tidak boleh kosong"
            ],
            alamatRule : [
                v=>!!v || "Alamat tidak boleh kosong"
            ],
            kontakRule : [
                v => !!v || "Kontak tidak boleh kosong",
                v => this.onlyNumber(v) || "Kontak harus berupa number",
                v => v.length>=12 || "Kontak tidak valid"
            ],
        }
    },
    methods:{
        submit(){
            if(this.$refs.formEdit.validate()){
                this.loader = true
                axios.post('api/updateAnggota',{
                    kode_anggota : this.id,
                    nama : this.txtNama,
                    jk : this.jk,
                    tgl_lahir : this.tgl_lahir,
                    alamat : this.alamat,
                    kontak : this.kontak,
                    status : this.status
                }).then(res=>{
                    if(res.data.message == "berhasil"){
                        this.loader = false
                        this.$fire({
                            title : "Berhasil",
                            text : "Data berhasil diubah",
                            type : "success"
                        })
                        this.$emit('update',res.data.data)
                    }
                })
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