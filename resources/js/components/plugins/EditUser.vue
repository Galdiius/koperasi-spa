<template>
  <v-dialog
        transition="dialog-top-transition"
        max-width="600"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            color="success"
            small
            v-bind="attrs"
            v-on="on"
          >Edit</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="primary"
              dark
            >Edit {{ user.nama }}</v-toolbar>
            <v-card-text>
                <v-form ref="formEdit">
                    <v-text-field v-model="nama" label="nama"></v-text-field>
                    <v-text-field v-model="username" label="username"></v-text-field>
                    <v-text-field label="Password(optional)" 
                                    v-model="password"
                                    :append-icon="value ? 'visibility' : 'visibility_off'"
                                    @click:append="() => (value = !value)"
                                    :type="value ? 'password' : 'text'" >
                    </v-text-field>
                    <v-select :items="itemLevel" v-model="level" label="Pilih level"></v-select>
                    <v-card-actions class="justify-end">
                        <v-btn color="success" @click="submit">Submit</v-btn>
                        <v-btn
                            color="error"
                            @click="dialog.value = false"
                        >Cancel</v-btn>
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
      this.$watch('user',function(){
        this.nama = this.user.nama
        this.value = true
        this.level = this.user.level
        this.username = this.user.username
      })
    },
    props : ['user'],
    data(){
        return {
            itemLevel : ["Admin","Petugas"],
            nama : this.user.nama,
            value : true,
            level : this.user.level,
            username : this.user.username,
            password : ""
        }
    },
    methods:{
        submit(){
            if(this.$refs.formEdit.validate()){
                axios.post('api/editUser',{
                  id : this.user.id_user,
                  nama : this.nama,
                  username : this.username,
                  level : this.level,
                  password : this.password
                }).then(res=>{
                  if(res.data.message == "berhasil"){
                    this.$fire({
                      title : "Berhasil",
                      text : "Data berhasil diubah",
                      type : "success"
                    });
                    this.$emit('update',res.data.data)
                  }
                })
            }
        }
    }
}
</script>