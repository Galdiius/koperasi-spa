<template>
    <v-navigation-drawer
      :mini-variant.sync="mini"
      permanent
      color="success"
      absolute
    >
      <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-img src="https://i.postimg.cc/jdssrd31/koperasi.jpg"></v-img>
        </v-list-item-avatar>

        <v-list-item-title class="white--text"><b>KOPERASI</b></v-list-item-title>

        <v-btn
          icon
          @click="mini = !mini"
        >
          <v-icon color="white">mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>

      <v-divider></v-divider>
      <v-list dense @click="mini = !mini">
        <router-link to="/" style="text-decoration:none" >
            <v-list-item link>
            <v-list-item-icon>
                <v-icon color="white">mdi-home</v-icon>
            </v-list-item-icon>

            <v-list-item-content class="white--text">
                <v-list-item-title>Home</v-list-item-title>
            </v-list-item-content>
            </v-list-item>
        </router-link>
      </v-list>
      <v-list dense @click="mini = !mini">
        <router-link to="/About" style="text-decoration:none" >
            <v-list-item link>
            <v-list-item-icon>
                <v-icon color="white">mdi-home</v-icon>
            </v-list-item-icon>

            <v-list-item-content class="white--text">
                <v-list-item-title>About</v-list-item-title>
            </v-list-item-content>
            </v-list-item>
        </router-link>
      </v-list>
    </v-navigation-drawer>
</template>
<script>
export default {
    data : ()=>({
        drawer : false,
        mini : true
    }),
    props : ['user']
}
</script>
<style scoped>
</style>