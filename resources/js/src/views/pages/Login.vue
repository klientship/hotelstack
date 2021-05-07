<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div
    class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center"
    id="page-login"
  >
    <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
      <vx-card>
        <div slot="no-body" class="full-page-bg-color">
          <div class="vx-row no-gutter justify-center items-center">
            <div class="vx-col hidden lg:block lg:w-1/2">
              <img
                src="@assets/images/pages/login.png"
                alt="login"
                class="mx-auto"
              />
            </div>

            <div class="vx-col sm:w-full md:w-full lg:w-1/2 d-theme-dark-bg">
              <div class="p-8 login-tabs-container">
                <div class="vx-card__title mb-4">
                  <h4 class="mb-4">Login</h4>

                  <vs-alert
                    :active.sync="isError"
                    closable
                    close-icon="close"
                    color="danger"
                    >Oops..Make sure you have entered correct email and
                    password</vs-alert
                  >

                  <p class="mt-4 mb-4">
                    Welcome back, please login to your account.
                  </p>
                </div>

                <div>
                  <vs-input
                    name="email"
                    icon-no-border
                    icon="icon icon-user"
                    icon-pack="feather"
                    label-placeholder="Email"
                    v-model="email"
                    s
                    class="w-full"
                  />

                  <vs-input
                    type="password"
                    name="password"
                    icon-no-border
                    icon="icon icon-lock"
                    icon-pack="feather"
                    label-placeholder="Password"
                    v-model="password"
                    class="w-full mt-6"
                  />

                  <div class="flex flex-wrap justify-between my-5">
                    <vs-checkbox v-model="checkbox_remember_me" class="mb-3"
                      >Remember Me</vs-checkbox
                    >
                    <!-- <router-link to>Forgot Password?</router-link> -->
                  </div>
                  <!-- <vs-button type="border">Register</vs-button> -->
                  <vs-button
                    class="float-left"
                    color="success"
                    type="border"
                    @click="demoLogin"
                    >Demo Login</vs-button
                  >
                  <vs-button class="float-right" @click="login"
                    >Login</vs-button
                  >

                  <vs-divider>HotelStack</vs-divider>
                </div>
              </div>
            </div>
          </div>
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
// import axios from "axios";
export default {
  data() {
    return {
      email: "",
      password: "",
      errorMsg: "",
      isError: false,
      checkbox_remember_me: false,
    };
  },
  methods: {
    async login() {
      await this.$http.get("/sanctum/csrf-cookie");
      this.$store
        .dispatch("login", {
          email: this.email,
          password: this.password,
        })
        .then(() => {
          this.email = "";
          this.password = "";
          const userInfo = this.$store.getters.getUserData;
          // if (userInfo.user.role == "admin") {
          this.$router.push("/admin");
          // } else if (userInfo.user.role == "employee") {
          // window.location = "/admin";
          // } else if (userInfo.user.role == "customer") {
          //   window.location = "/customer";
          // }
        })
        .catch((err) => {
          this.isError = true;
          // this.errorMsg = err.message;
        });
    },
    demoLogin() {
      this.email = "demo@hotelstack.in";
      this.password = "demo123@";
      this.login();
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
    showPassword() {
      const x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    },
  },
};
</script>

<style lang="scss">
#page-login {
  .social-login-buttons {
    .bg-facebook {
      background-color: #1551b1;
    }
    .bg-twitter {
      background-color: #00aaff;
    }
    .bg-google {
      background-color: #4285f4;
    }
    .bg-github {
      background-color: #333;
    }
  }
}
</style>
