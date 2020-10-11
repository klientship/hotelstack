<template>
  <quick-menu
    :icon-class="icons"
    :menu-url-list="list"
    :background-color="backgroundColor"
    :color="color"
    :position="position"
  ></quick-menu>
</template>

<script>
import Vue from "vue";
import quickMenu from "vue-quick-menu";

import { mapGetters } from "vuex";

export default {
  components: {
    quickMenu,
  },
  data: () => ({
    activeItem: 0,

    icons: ["fas fa-home", "fas fa-hotel", "fas fa-heart", "fas fa-phone-alt"],
    list: [
      { isLink: true, url: "/home" },

      { isLink: true, url: "/rooms" },
      { isLink: true, url: "/about" },
      { isLink: true, url: "/contact" },
    ],
    backgroundColor: "#070617",
    color: "#ffffff",
    position: "top-left",
  }),
  computed: {
    ...mapGetters({ isLogged: "isLogged" }),
    ...mapGetters({ userDetails: "getUserData" }),
    ...mapGetters({ hotelDetails: "getHotelDetails" }),
  },
  methods: {},
  created() {},
};
</script>
        
<style >
.quick-menu {
  z-index: 1;
}
</style>