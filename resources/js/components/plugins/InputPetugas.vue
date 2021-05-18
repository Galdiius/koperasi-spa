<template>
    <v-dialog
        transition="dialog-top-transition"
        max-width="600"
        class="mb-5"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            color="primary"
            v-bind="attrs"
            v-on="on"
          >Tambah User</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="primary"
              dark
            >Tambah Petugas</v-toolbar>
            <v-card-text>
                <v-form ref="formPetugas">
                    <v-text-field label="Nama" v-model="nama" :rules="namaRule"></v-text-field>
                    <v-text-field label="Username" v-model="username" :rules="usernameRule"></v-text-field>
                    <v-row>
                        <v-col lg="6">
                            <v-text-field label="Password" :append-icon="value ? 'visibility' : 'visibility_off'"
                                        @click:append="() => (value = !value)"
                                        :type="value ? 'password' : 'text'" 
                                        v-model="password" :rules="passwordRule" ></v-text-field>
                        </v-col>
                        <v-col lg="6">
                            <v-text-field label="Ketik ulang password"
                            :append-icon="valueConfirm ? 'visibility' : 'visibility_off'"
                            @click:append="() => (valueConfirm = !valueConfirm)"
                            :type="valueConfirm ? 'password' : 'text'"
                            v-model="confirmPassword" 
                            :rules="confirmPasswordRule"></v-text-field>
                        </v-col>
                    </v-row>
                    
                    <v-select :items="itemlevel" label="Pilih level petugas" v-model="level" :rules="levelRule"></v-select>
                    <v-card-actions class="justify-end">
                        <v-btn
                            color="error"
                            @click="dialog.value = false"
                        >Cancel</v-btn>
                        <v-btn color="success" @click="submit" :loading="loading">Submit</v-btn>
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
    data(){
        return {
            nama : '',
            loading : false,
            username : '',
            value : true,
            valueConfirm : true,
            password : '',
            confirmPassword : '',
            level : '',
            itemlevel : ["Admin","Petugas"],
            namaRule : [
                v=>!!v || "Nama tidak boleh kosong",
            ],
            usernameRule : [
                v=>!!v || "Username tidak boelh kosong"
            ],
            passwordRule : [
                v=>!!v || "Password tidak boleh kosong",
                v=> v.length >= 8 || "Password terlalu pendek"
            ],
            confirmPasswordRule : [
                v=>!!v || "Field tidak boleh kosong"
            ],
            levelRule : [
                v=> !!v || "Level tidak boleh kosong"
            ]

        }
    },
    methods : {
        submit(){
            if(this.$refs.formPetugas.validate()){
                if(this.confirmPassword != this.password){
                    this.$fire({
                        title : "Gagal",
                        type : "error",
                        text : "password tidak sesuai"
                    })
                }else{
                    this.loading = true
                    axios.post('api/tambahUser',{
                        nama: this.nama,
                        username: this.username,
                        password: this.password,
                        level : this.level
                    }).then(res=>{
                        if(res.data.message == "berhasil"){
                            this.loading = false
                            this.$fire({
                                title : "Berhasil",
                                type : "success",
                                text : "User berhasil ditambahkan"
                            })
                            this.$emit('update',res.data.data)
                        }
                    }).catch(err=>{
                        this.loading = false
                        this.$fire({
                                title : "Gagal",
                                type : "error",
                                text : "Terjadi kesalahan silahkan coba lagi"
                            })
                    })
                }
            }
        }
    }
}
</script>