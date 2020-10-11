<template>
  <div class="the-navbar__user-meta flex items-center" v-if="hotelDetails.name">
    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{hotelDetails.name }}</p>
      <small>Available</small>
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
      <div class="con-img ml-3">
        <img
          v-if="activeUserInfo.photoURL"
          key="onlineImg"
          :src="activeUserInfo.photoURL"
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
    return {};
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser;
    },
    ...mapGetters(["isLogged"]),
    ...mapGetters({ hotelDetails: "getHotelDetails" }),
  },
  methods: {
    logout() {
      // This is just for demo Purpose. If user clicks on logout -> redirect
      this.$store.dispatch("logout").then(() => {
        this.$router.push({ name: "login" }).catch(() => {});
      });
    },
  },
};
</script>
