<template>
  <v-container>
    <v-progress-linear
                              buffer-value="0"
                              color="success"
                              indeterminate
                              value="0"
                              v-show="progress"
                            ></v-progress-linear>
      <v-row>
        <v-col lg="12">
          <h1>SELAMAT DATANG  {{user.level | upper}} {{ user.username | upper }}</h1>
          <v-divider></v-divider>
        </v-col>
        <!-- Performa penambahan anggota -->
        <!-- <v-col lg="6" v-show="user.level != 'Anggota'">
          <SparklineAnggota />
        </v-col> -->
      <!-- Akhir performa penambahan anggota -->

      <!-- Kalender -->
        <v-col lg="6">
          <Calender/>
        </v-col>
        <v-col lg="6" v-show="admin">
          <v-card shaped :loading="loaderSaldoKoperasi">
            <v-card-subtitle class="text-center success white--text">
              <h4><b>Jumlah saldo koperasi</b></h4>
            </v-card-subtitle>  
            <v-divider></v-divider>
            <v-card-text class="text-center">
              <h3>Rp. {{ saldoKoperasi }}</h3>
            </v-card-text>
          </v-card>
        </v-col>
      <!-- Akhir Kalender -->
        <v-col lg="6" v-show="anggota">
          <v-row>
              <v-col lg="6">
                <v-card shaped :loading="loaderSaldo">
                  <v-card-subtitle class="text-center success white--text">
                    <h4><b>Jumlah saldo</b></h4>
                  </v-card-subtitle>  
                  <v-divider></v-divider>
                  <v-card-text class="text-center">
                    <h3>Rp. {{ saldo }}</h3>
                  </v-card-text>
                </v-card>
              </v-col>

              <v-col lg="6">
                <v-card shaped :loading="loaderAngsuran">
                  <v-card-subtitle class="text-center primary white--text">
                    <h4><b>Jumlah Angsuran</b></h4>
                  </v-card-subtitle>
                  <v-divider></v-divider>
                  <v-card-text class="text-center">
                    <h3>Rp.{{ angsuran }}</h3>
                  </v-card-text>
                </v-card>
              </v-col>
          </v-row>
        </v-col>

      </v-row>
  </v-container>
</template>

<script>
import Calender from './plugins/Calender'
import SparklineAnggota from './plugins/SparklinesAnggota'
import axios from 'axios'

export default {
  beforeMount(){
    if(localStorage.getItem('kode_anggota')){
      axios.get(`api/getAnggotaById?id=${localStorage.getItem('kode_anggota')}`).then(res=>{
        this.progress = false
        this.user = {
          username : res.data.data.nama,
          level : "Anggota"
        }
      })
      axios.get(`api/getSaldoById?id=${localStorage.getItem('kode_anggota')}`).then(res=>{
        this.loaderSaldo = false
        this.saldo = res.data.data.jumlah
      })
      axios.get(`api/getJumlahAngsuranById?id=${localStorage.getItem('kode_anggota')}`).then(res=>{
        this.loaderAngsuran = false
        this.angsuran = res.data.data
      })
    }else{
      let id = localStorage.getItem('adnajdnajdajdasjdadajnj')
      axios.get(`api/getUser?id=${id}`).then((res)=>{
        this.progress = false
        this.user = res.data.data
      })
      axios.get('api/getJumlahSimpanan').then(res=>{
            this.loaderSaldoKoperasi = false
            this.saldoKoperasi = res.data.data
        })
    }

  },
  data(){
    return {
      loaderSaldoKoperasi : true,
      admin : localStorage.getItem('level') == "Admin" ? true : false,
      loaderSaldo : true,
      loaderAngsuran : true,
      anggota : localStorage.getItem('kode_anggota') ? true : false,
      angsuran : '',
      saldo : '',
      saldoKoperasi : '',
      progress : true,
      user : {},
    }
  },
  components : {
    Calender,
    SparklineAnggota
  },
  filters : {
    upper(value){
      if(!value) return ''
      value = value.toString()
      return value.toUpperCase()
    }
  }
  
};
</script>

