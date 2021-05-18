<template>
    <v-dialog
        transition="dialog-top-transition"
        max-width="600"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            color="success"
            v-bind="attrs"
            v-on="on"
          >Edit</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="primary"
              dark
            >Edit</v-toolbar>
            <v-card-text>
                <v-form>
                    <v-text-field label="Jenis simpanan" v-model="jenisSimpanan" :rules="jenisSimpananRule"></v-text-field>
                    <v-text-field label="Jumlah" type="number" v-model="jumlah" :rules="jumlahRule"></v-text-field>
                    <v-card-actions class="justify-end">
                        <v-btn color="success" @click="submit">Submit</v-btn>
                        <v-btn
                            color="error"
                            @click="dialog.value = false"
                        >Close</v-btn>
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
        this.$watch('jSimpanan',function(){
            this.jenisSimpanan = this.jSimpanan.jenis_simpanan
            this.jumlah = this.jSimpanan.jumlah
        })
    },
    props : ['jSimpanan'],
    data(){
        return {
            jenisSimpanan : this.jSimpanan.jenis_simpanan,
            jumlah : this.jSimpanan.jumlah,
            jenisSimpananRule : [
                v=>!!v || "Field tidak boleh kosong"
            ],
            jumlahRule : [
                v=>!!v || "Jumlah tidak boleh kosong"
            ]
        }
    },
    methods:{
        submit(){
            axios.post('api/editJenisSimpanan',{
                id_jenis : this.jSimpanan.id_jenis,
                jenis_simpanan : this.jenisSimpanan,
                jumlah : this.jumlah,
            }).then(res=>{
                if(res.data.message == "berhasil"){
                    this.$fire({
                        title : "Berhasil",
                        text: "Data berhasil diubah",
                        type : "success"
                    })
                    this.$emit('update',res.data.data)
                }
            })
        }
    }
}
</script>