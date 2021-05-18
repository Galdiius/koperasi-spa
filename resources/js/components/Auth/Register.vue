<template>
  <v-app>
    <v-container class="reg" fill-height fluid>
      <v-row justify="center" align="center" no-gutters>
        <v-col lg="3">
          <v-card height="340px" class="primary justify-center">
            <v-card-text class="text-center">
              <h1 class="white--text">Registrasi</h1>
            </v-card-text>
            <v-card-text class="pt-5">
              <v-img src="../../../images/PowerMoves.png"></v-img>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col lg="4" md="4">
          <v-card class="pa-5" height="340px">
            <v-form ref="formRegis">
              <v-text-field
                label="Nama :"
                :rules="namaRule"
                autocomplete="off"
                v-model="nama"
              ></v-text-field>
              <v-text-field
                label="Username :"
                :rules="usernameRule"
                autocomplete="off"
                v-model="username"
              ></v-text-field>
              <v-row>
                <v-col lg="6">
                  <v-text-field
                    type="password"
                    label="Password :"
                    :rules="passwordRule"
                    v-model="password"
                  ></v-text-field>
                </v-col>
                <v-col lg="6">
                  <v-text-field
                    type="password"
                    label="Confirm password :"
                    :rules="confirmPasswordRule"
                    v-model="confirmPassword"
                  ></v-text-field>
                </v-col>
              </v-row>
              <div class="text-center mt-5">
                <v-btn color="success" @click="validate" :loading="loading"
                  >Submit</v-btn
                >
              </div>
              <div class="mt-4 text-center">
                <router-link to="/login" style="text-decoration: none"
                  >Sudah memiliki akun?klik untuk login</router-link
                >
              </div>
            </v-form>
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
    loading: false,
    nama: "",
    username: "",
    password: "",
    confirmPassword: "",
    namaRule: [(v) => !!v || "Nama tidak boleh kosong"],
    usernameRule: [(v) => !!v || "Username tidak boleh kosong"],
    passwordRule: [
      (v) => !!v || "Password tidak boleh kosong",
      (v) => v.length >= 8 || "Password terlalu pendek",
    ],
    confirmPasswordRule: [(va) => !!va || " tidak boleh kosong"],
  }),
  methods: {
    validate() {
      if (this.confirmPassword != this.password) {
        this.$fire({
          title: "Gagal",
          text: "Confirm Password tidak sesuai",
          type: "error",
        });
      } else {
        this.loading = true;
        if (this.$refs.formRegis.validate()) {
          axios
            .post("http://127.0.0.1:8000/api/tambahUser", {
              nama: this.nama,
              username: this.username,
              password: this.password,
            })
            .then((res) => {
              this.$fire({
                title: "Sukses",
                text: "Register berhasil",
                type: "success",
              });
              this.loading = false;
            })
            .catch((err) => console.log(err));
        }
      }
    },
  },
  components: {},
};
</script>
<style scoped>
.image {
  background: url("https://blush.design/api/download?shareUri=RPZzTGHPs&w=800&h=800&fm=png");
  height: 20px;
  width: 20px;
}
.card-regis {
  background: rgba(255, 255, 255, 0.84) !important;
}
.link-login {
  text-decoration: none;
}
</style>
