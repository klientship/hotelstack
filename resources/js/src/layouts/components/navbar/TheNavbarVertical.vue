


<template>
  <div class="relative">
    <div class="vx-navbar-wrapper" :class="classObj">
      <vs-navbar
        class="vx-navbar navbar-custom navbar-skelton"
        :color="navbarColorLocal"
        :class="textColor"
      >
        <!-- SM - OPEN SIDEBAR BUTTON -->
        <feather-icon
          class="sm:inline-flex xl:hidden cursor-pointer p-2"
          icon="MenuIcon"
          @click.stop="showSidebar"
        />

        <bookmarks :navbarColor="navbarColor" v-if="windowWidth >= 992" />
        <p class="ml-4">{{ todays_date }}</p>

        <vs-spacer />

        <search-bar />

        <!-- <notification-drop-down /> -->

        <profile-drop-down />
      </vs-navbar>
    </div>
  </div>
</template>


<script>
import Bookmarks from "./components/Bookmarks.vue";
import SearchBar from "./components/SearchBar.vue";
import NotificationDropDown from "./components/NotificationDropDown.vue";
import ProfileDropDown from "./components/ProfileDropDown.vue";
import { mapGetters } from "vuex";

export default {
  name: "the-navbar-vertical",
  props: {
    navbarColor: {
      type: String,
      default: "#fff",
    },
  },
  components: {
    Bookmarks,
    SearchBar,
    NotificationDropDown,
    ProfileDropDown,
  },
  computed: {
    todays_date() {
      var objToday = new Date(),
        weekday = new Array(
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday"
        ),
        dayOfWeek = weekday[objToday.getDay()],
        domEnder = (function () {
          var a = objToday;
          if (/1/.test(parseInt((a + "").charAt(0)))) return "th";
          a = parseInt((a + "").charAt(1));
          return 1 == a ? "st" : 2 == a ? "nd" : 3 == a ? "rd" : "th";
        })(),
        dayOfMonth =
          today + (objToday.getDate() < 10)
            ? "0" + objToday.getDate() + domEnder
            : objToday.getDate() + domEnder,
        months = new Array(
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December"
        ),
        curMonth = months[objToday.getMonth()],
        curYear = objToday.getFullYear(),
        curHour =
          objToday.getHours() > 12
            ? objToday.getHours() - 12
            : objToday.getHours() < 10
            ? "0" + objToday.getHours()
            : objToday.getHours(),
        curMinute =
          objToday.getMinutes() < 10
            ? "0" + objToday.getMinutes()
            : objToday.getMinutes(),
        curSeconds =
          objToday.getSeconds() < 10
            ? "0" + objToday.getSeconds()
            : objToday.getSeconds(),
        curMeridiem = objToday.getHours() > 12 ? "PM" : "AM";
      var today =
        curHour +
        ":" +
        curMinute +
        "." +
        curSeconds +
        curMeridiem +
        " " +
        dayOfWeek +
        " " +
        dayOfMonth +
        " of " +
        curMonth +
        ", " +
        curYear;
      return today;
    },
    navbarColorLocal() {
      return this.$store.state.theme === "dark" && this.navbarColor === "#fff"
        ? "#10163a"
        : this.navbarColor;
    },
    verticalNavMenuWidth() {
      return this.$store.state.verticalNavMenuWidth;
    },
    textColor() {
      return {
        "text-white":
          (this.navbarColor !== "#10163a" &&
            this.$store.state.theme === "dark") ||
          (this.navbarColor !== "#fff" && this.$store.state.theme !== "dark"),
      };
    },
    windowWidth() {
      return this.$store.state.windowWidth;
    },

    // NAVBAR STYLE
    classObj() {
      if (this.verticalNavMenuWidth === "default") return "navbar-default";
      else if (this.verticalNavMenuWidth === "reduced") return "navbar-reduced";
      else if (this.verticalNavMenuWidth) return "navbar-full";
    },
  },
  methods: {
    showSidebar() {
      this.$store.commit("TOGGLE_IS_VERTICAL_NAV_MENU_ACTIVE", true);
    },
  },
  created() {},
};
</script>

