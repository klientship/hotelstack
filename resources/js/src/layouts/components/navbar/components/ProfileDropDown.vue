<template>
  <div
    class="the-navbar__user-meta flex items-center"
    v-if="activeUserInfo.user.name"
  >
    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ activeUserInfo.user.name }}</p>
      <!-- <small v-if="this.$online">Online</small> -->
      <!-- <small v-else>Offline</small> -->
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
      <div class="con-img ml-3">
        <img
          v-if="activeUserInfo.user.profile_img"
          key="onlineImg"
          :src="activeUserInfo.user.profile_img"
          alt="user-img"
          width="40"
          height="40"
          class="rounded-full shadow-md cursor-pointer block"
        />
      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">
          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push({ name: 'profile' })"
            v-if="isLogged"
          >
            <feather-icon icon="UserIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Profile</span>
          </li>

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logout"
            v-if="isLogged"
          >
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Logout</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      photoURL: require("@assets/images/portrait/small/favicon.png"), // From Auth
    };
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser;
    },
    ...mapGetters(["isLogged"]),
    ...mapGetters({ activeUserInfo: "getUserData" }),
  },
  methods: {
    logout() {
      // This is just for demo Purpose. If user clicks on logout -> redirect
      this.$store.dispatch("logout").then(() => {
        this.$router.push({ name: "login" }).catch(() => {});
      });
    },
  },
  created() {
    // this.$store.dispatch("RETRIEVE_ACTIVE_USER_DETAILS");
  },
};
</script>
