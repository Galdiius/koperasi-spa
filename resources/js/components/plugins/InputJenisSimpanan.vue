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
          >Tambah jenis simpanan</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="primary"
              dark
            >Input jenis simpanan</v-toolbar>
            <v-card-text>
                <v-form ref="formTambah">
                    <v-text-field label="Jenis simpanan" v-model="jenisSimpanan" :rules="jeniSimpananRule"></v-text-field>
                    <v-text-field label="Jumlah" type="number" v-model="jumlah" :rules="jumlahRule"></v-text-field>
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
    data(){
        return {
            jenisSimpanan : '',
            jumlah : '',
            jeniSimpananRule : [
                v=> !!v || "Field tidak boleh kosong"
            ],
            jumlahRule : [
                v=> !!v || "Jumlah tidak boleh kosong"
            ]
        }
    },
    methods:{
        submit(){
            if(this.$refs.formTambah.validate()){
                axios.post('api/tambahJenisSimpanan',{
                    jenisSimpanan : this.jenisSimpanan,
                    jumlah : this.jumlah
                }).then(res=>{
                    if(res.data.message == "berhasil"){
                        this.$fire({
                            title : "Berhasil",
                            text : "Data berhasil ditambahkan",
                            type : "success"
                        })
                        this.$emit('update',res.data.data)
                    }
                })
            }
        }
    }
}
</script>