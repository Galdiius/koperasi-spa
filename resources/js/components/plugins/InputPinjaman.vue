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
          >Input pinjaman</v-btn>
        </template>
        <template v-slot:default="dialog">
          <v-card>
            <v-toolbar
              color="primary"
              dark
            >Input pinjaman</v-toolbar>
            <v-card-text class="mb-3">
                <v-form ref="formPinjam">
                    <v-text-field type="date" label="tanggal pinjam" v-model="now" disabled></v-text-field>
                    <v-autocomplete v-model="kode_anggota" :rules="kdRule" :items="anggota" item-text="namaId" dense filled label="Kode anggota"></v-autocomplete>
                    <v-text-field type="number" :hint="`Jumlah simpanan : ${jumlahSimpanan}`" min="0" persistent-hint :rules="jumlahRule" label="jumlah" v-model="jumlah" @mouseup="jmlhByr" @keyup="jmlhByr"></v-text-field>
                    <v-text-field label="bunga" v-model="bunga" disabled></v-text-field>
                    <v-select :items="lamaPinjam" v-model="lama_pinjam" label="Lama pinjam" @change="jmlhByr"></v-select>
                    <v-text-field label="Jumlah bayar" disabled v-model="jumlahBayar"></v-text-field>
                </v-form>
                <v-card-actions class="justify-end">
                <v-btn color="success" @click="submit" :loading="loader">Submit</v-btn>
                <v-btn
                    color="error"
                    @click="dialog.value = false"
                >Close</v-btn>
                </v-card-actions>
            </v-card-text>
          </v-card>
        </template>
      </v-dialog>
</template>
<script>
import axios from 'axios'
export default {
    created(){
        axios.get('api/getAnggotaNamaIdFilter').then(res=>{
            this.anggota = res.data.data
        })
        axios.get('api/getJumlahSimpanan').then(res=>{
            this.jumlahSimpanan = res.data.data
        })
        var utc = new Date().toJSON().slice(0,10).replace(/-/g,'-');
        this.now = utc
    },
    data(){
        return {
            kode_anggota:'',
            loader : false,
            jumlah : '',
            now : '',
            lama_pinjam : '1 bulan',
            jumlahSimpanan : 0,
            anggota : [],
            jumlahBayar:'0',
            bunga : '2%',
            lamaPinjam : ["1 bulan","2 bulan","3 bulan","4 bulan","5 bulan","6 bulan","7 bulan","8 bulan","9 bulan","10 bulan","11 bulan","12 bulan"],
            jumlahRule : [
                v => v <= this.jumlahSimpanan || "Jumlah melebihi jumlah simpanan",
                v => !!v || "Jumlah tidak boleh kosong"
            ],
            kdRule : [
                v => !!v || "Field tidak boleh kosong"
            ],

        }
    },
    methods : {
        jmlhByr(){
            let lamaPinjam = this.lama_pinjam
            let lp = parseInt(lamaPinjam.substring(0,2))
            let bunga = this.percentage(this.jumlah,2)
            let jml = Math.round(( parseInt(this.jumlah) + bunga) / lp)
            if(isNaN(jml)){
                this.jumlahBayar = '0'
            }else{
                this.jumlahBayar = "Rp." + jml
            }
        },
        percentage(num,per){
            return (num/100)*per
        },
        submit(){
            this.loader = true
            if(this.$refs.formPinjam.validate()){
                let data = {
                    tanggal : this.now,
                    kode_anggota : this.kode_anggota,
                    jumlah : this.jumlah,
                    bunga : this.bunga,
                    lama_pinjam : this.lama_pinjam,
                    jumlah_bayar : this.jumlahBayar,
                    id_user : localStorage.getItem('adnajdnajdajdasjdadajnj')
                }
                axios.post('api/inputPinjaman',data).then(res=>{
                    console.log(res.data)
                    if(res.data.message == "berhasil"){
                        this.$emit('update',res.data.data)
                        this.loader = false
                        this.$fire({
                            title : "Berhasil",
                            text : "Peminjaman berhasil",
                            type : "success"
                        })
                    }
                }).catch(err=>{
                    this.loader = false
                    this.$fire({
                        title : "Upps!!",
                        text : "Terjadi kesalahan silahkan coba lagi",
                        type : "warning"
                    })
                })
            }else {
                this.loader = false
            }
        }
    }
}
</script>
<style scoped>
input[type='number'] {
    -moz-appearance:textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
</style>