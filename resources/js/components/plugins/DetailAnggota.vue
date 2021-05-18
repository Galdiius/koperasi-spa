<template>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="290"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
          small
        >
            Detail
        </v-btn>
      </template>
      <v-card>
        <v-card-title class="headline">
            Profil {{ nama }}
        </v-card-title>
        <v-card-text>Kode anggota : {{ kode_anggota }}</v-card-text>
        <v-card-text>Nama : {{ nama }}</v-card-text>
        <v-card-text>Jenis kelamin : {{ jk }}</v-card-text>
        <v-card-text>Tanggal lahir : {{ tgl }}</v-card-text>
        <v-card-text>Alamat : {{ alamat }}</v-card-text>
        <v-card-text>Kontak : {{ kontak }}</v-card-text>
        <v-card-text>Bergabung pada : {{ tglGabung }}</v-card-text>
        <v-card-text>Saldo : {{ saldo != null ? saldo : '0'  }}</v-card-text>
        <v-card-text>Status : {{ status}}</v-card-text>
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
export default {
    mounted(){
      console.log(this.saldo)
    },
    data(){
        return {
            dialog : false
        }
    },
    props: ['nama','kode_anggota','jk','tgl','alamat','kontak','tglGabung','status','saldo']
}
</script>