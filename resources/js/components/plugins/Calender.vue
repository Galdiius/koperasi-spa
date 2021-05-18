<template>
    <div>
      <!-- <v-toolbar flat outlined>
        <v-btn outlined class="mr-4" color="grey-darken-2" @click="setToday">Today</v-btn>
        <v-btn fab small text color="grey-darken-2" @click="prev">
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
        <v-btn fab small text color="grey-darken-2" @click="next">
          <v-icon>mdi-chevron-right</v-icon>
        </v-btn>
      </v-toolbar> -->
      <v-toolbar flat>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-subtitle>{{ today }}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-toolbar>
      <v-calendar :events="events2" type="month" v-model="focus" color="primary" ref="calendar"></v-calendar>
    </div>
</template>
<script>
import axios from 'axios'
export default {
  mounted(){
    this.$refs.calendar.checkChange()
    if(localStorage.getItem('kode_anggota')){
      axios.get(`api/getAngsuranById?id=${localStorage.getItem('kode_anggota')}`).then(res=>{
        res.data.data.forEach(v => {
          let obj = {
            name : "Tagihan",
            start : v.start,
            end : v.end,
            color : "red"
          }
          this.events2.push(obj)
        });
      })

    }
  },
  data(){
    return {
        today: `${String(new Date().getDate()).padStart(2,'0')}-${String(new Date().getMonth() + 1).padStart(2,'0')}-${new Date().getFullYear()}`,
        focus: '',
        events2: [
          // {name: 'Tagihan', start: '2021-03-21', end: '2021-03-21'},
          // {name: 'Tagihan2', start: '2021-03-21', end: '2021-03-21'},
        ]
      }
  },
  methods : {
    setToday(){
      this.focus = ''
    },
    prev(){
      this.$refs.calendar.prev()
    },
    next(){
      this.$refs.calendar.prev()
    },
  }
}
</script>