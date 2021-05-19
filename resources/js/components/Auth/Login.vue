<template>
  <v-app>
    <v-container fill-height fluid>
      <v-row justify="center" align="center" no-gutters>
        <v-col lg="3">
          <v-card color="success text-center pt-5" height="300px">
            <h1 class="white--text">Login</h1>
            <v-card-text class="pt-5">
              <v-img src="../../../images/PowerMoves.png"></v-img>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col lg="4">
          <v-card height="300px" class="pa-5">
            <v-form ref="form">
              <v-text-field
                label="Username"
                :rules="usernameRule"
                v-model="username"
              ></v-text-field>
              <v-text-field
                label="Password"
                :rules="passwordRule"
                v-model="password"
                :append-icon="value ? 'visibility' : 'visibility_off'"
                @click:append="() => (value = !value)"
                :type="value ? 'password' : 'text'" 
              ></v-text-field>
              <div class="text-center mt-5">
                <v-btn class="success" @click="login" :loading="loader">Login</v-btn>
              </div>
            </v-form>
            <!-- <div class="mt-5 text-center">
              <router-link to="/register" style="text-decoration: none"
                >Belum mempunyai akun?klik untuk daftar</router-link
              >
            </div> -->
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    loader : false,
    username: "",
    password: "",
    value : true,
    usernameRule: [(v) => !!v || "Username tidak boleh kosong"],
    passwordRule: [(v) => !!v || "Password tidak boleh kosong"],
  }),
  methods: {
    login() {
      if (this.$refs.form.validate()) {
        this.loader = true
        axios
          .post("/api/login", {
            username: this.username,
            password: this.password,
          })
          .then((res) => {
            //this.$router.push({ path: "/" });
              this.loader = false
            if (res.data.data == "berhasil") {
              localStorage.setItem('login',true)
              localStorage.setItem('adnajdnajdajdasjdadajnj',res.data.id_user)
              localStorage.setItem('level',res.data.level)
              // sessionStorage.setItem("login", true);
              // sessionStorage.setItem('adnajdnajdajdasjdadajnj',res.data.id_user)
              this.$router.push({ path: "/" });
            } else {
              this.loader = false
              this.$fire({
                title: "Gagal",
                text: "Username atau password tidak sesuai",
                type: "error",
              });
            }
          });
      }
    },
  },
};
</script>
<style scoped>
</style>
