<template>
  <div id="dashboard-analytics">
    <!-- add new -->
    <div class="demo-alignment">
      <vs-popup
        classContent="popup-example"
        title="Create Checkin"
        :active.sync="isAddNewPopup"
      >
        <CreateBooking title="Checkin"></CreateBooking>
      </vs-popup>
    </div>

    <!-- view booking -->
    <div class="demo-alignment">
      <vs-popup
        classContent="popup-example"
        title="View Checkin"
        :active.sync="isViewPopup"
      >
        <ViewBooking title="Checkin" :data="data"></ViewBooking>
      </vs-popup>
    </div>
    <!-- end view booking -->

    <div class="vx-row">
      <!-- CARD 1: CONGRATS -->
      <div class="vx-col w-full lg:w-1/2 mb-base">
        <vx-card
          slot="no-body"
          class="text-center bg-primary-gradient greet-user"
        >
          <img
            src="@assets/images/elements/decore-left.png"
            class="decore-left"
            alt="Decore Left"
            width="200"
          />
          <img
            src="@assets/images/elements/decore-right.png"
            class="decore-right"
            alt="Decore Right"
            width="175"
          />
          <feather-icon
            icon="AwardIcon"
            class="p-6 mb-8 bg-primary inline-flex rounded-full text-white shadow"
            svgClasses="h-8 w-8"
          ></feather-icon>
          <h1 class="mb-6 text-white">
            {{ greeting }} {{ hotelDetails.name }},
          </h1>
          <p class="xl:w-3/4 lg:w-4/5 md:w-2/3 w-4/5 mx-auto text-white">
            You have gained
            <strong>{{ dashboardDetails.gain_percentage }}%</strong>
            income compared to yesterday. Today's total expense is &#8377;{{
              dashboardDetails.total_expense
            }}.
          </p>
        </vx-card>
      </div>

      <!-- Total of all bookings and other payment received -->
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.todays_business"
          statisticTitle="Todays Business"
          :chartData="dashboardDetails.business.series"
          type="area"
        ></statistics-card-line>
      </div>

      <!-- total expense -->
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChart2Icon"
          :statistic="dashboardDetails.total_expense"
          statisticTitle="Todays Expense"
          :chartData="dashboardDetails.expenses.series"
          color="danger"
          type="area"
        ></statistics-card-line>
      </div>
    </div>

    <!-- end add new -->
    <vx-card title="All Rooms" title-color="primary" subtitle-color="warning">
      <div
        class="vx-row mt-2"
        v-for="type in roomTypes"
        :key="type.id"
        v-if="roomTypes && roomTypes.length"
      >
        <div class="vx-col">
          <h5 class="mb-2 ml-2">{{ type.title }}</h5>
          <vs-button
            v-for="room in type.rooms"
            :color="getColor(room.id)"
            class="ml-2 mt-2"
            :key="room.id"
            @click="clicked(room)"
            >{{ room.number }}</vs-button
          >
        </div>
      </div>
    </vx-card>

    <div class="vx-row mt-4">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_payment"
          statisticTitle="Payments Received"
          :chartData="dashboardDetails.payments.series"
          type="area"
          color="success"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.todays_pending_payment"
          statisticTitle="Pending Payments"
          :chartData="dashboardDetails.pending_payments.series"
          type="area"
          color="danger"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.todays_walkin_business"
          statisticTitle="Walkin Business"
          :chartData="dashboardDetails.walkin_business.series"
          type="area"
          color="warning"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.todays_oyo_business"
          statisticTitle="Oyo Business"
          :chartData="dashboardDetails.oyo_business.series"
          type="area"
          color="dark"
        ></statistics-card-line>
      </div>
    </div>

    <!-- numbers -->
    <div class="vx-row mt-4">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_cold_drinks"
          statisticTitle="Soft drinks"
          :chartData="dashboardDetails.cold_drinks.series"
          type="area"
          color="success"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_paid_services"
          statisticTitle="Paid Services"
          :chartData="dashboardDetails.paid_services.series"
          type="area"
          color="danger"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_walkin_business"
          statisticTitle="Total Walkins"
          :chartData="dashboardDetails.walkin_business.series"
          type="area"
          color="warning"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_oyo_business"
          statisticTitle="Oyo Bookings"
          :chartData="dashboardDetails.oyo_business.series"
          type="area"
          color="dark"
        ></statistics-card-line>
      </div>
    </div>

    <div class="vx-row mt-4">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.income"
          statisticTitle="Profit"
          :chartData="dashboardDetails.payments.series"
          type="area"
          color="success"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_total_checkin"
          statisticTitle="Total Checkin"
          :chartData="dashboardDetails.checkin_business.series"
          type="area"
          color="danger"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_total_checkout"
          statisticTitle="Total Checkout"
          :chartData="dashboardDetails.checkout_business.series"
          type="area"
          color="warning"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_future_bookings"
          statisticTitle="Future Bookings"
          :chartData="dashboardDetails.future_bookings_business.series"
          type="area"
          color="dark"
        ></statistics-card-line>
      </div>
    </div>

    <vx-card title="RECENT CHECKIN'S" title-color="primary" class="mt-4">
      <template>
        <vs-table :data="recent_checkins">
          <template slot="thead">
            <vs-th>ID</vs-th>
            <vs-th>GUEST NAME</vs-th>
            <vs-th>PEOPLE</vs-th>
            <vs-th>ROOMS COUNT</vs-th>
            <vs-th>CHECK OUT</vs-th>
            <vs-th>TOTAL</vs-th>
            <vs-th>STATUS</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :key="indextr" v-for="(tr, indextr) in data">
              <vs-td :data="data[indextr].email">{{ data[indextr].uid }}</vs-td>

              <vs-td :data="data[indextr].username">{{
                data[indextr].name
              }}</vs-td>

              <vs-td :data="data[indextr].id"
                >{{ data[indextr].adults }} Adults &
                {{ data[indextr].kids }} Kids</vs-td
              >
              <vs-td :data="data[indextr].id">{{
                data[indextr].number_of_room
              }}</vs-td>
              <vs-td :data="data[indextr].id">{{
                data[indextr].check_out
              }}</vs-td>
              <vs-td :data="data[indextr].id">{{ data[indextr].total }}</vs-td>
              <vs-td>
                <vs-chip
                  :color="getStatusColor(tr)"
                  class="product-order-status"
                  >{{ getStatus(tr) }}</vs-chip
                >
              </vs-td>
            </vs-tr>
          </template>
        </vs-table>
      </template>
    </vx-card>

    <vx-card title="TODAYS CHECKIN'S" title-color="primary" class="mt-4">
      <template>
        <vs-table :data="todays_checkins">
          <template slot="thead">
            <vs-th>ID</vs-th>
            <vs-th>GUEST NAME</vs-th>
            <vs-th>PEOPLE</vs-th>
            <vs-th>ROOMS COUNT</vs-th>
            <vs-th>CHECK OUT</vs-th>
            <vs-th>TOTAL</vs-th>
            <vs-th>STATUS</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :key="indextr" v-for="(tr, indextr) in data">
              <vs-td :data="data[indextr].email">{{ data[indextr].uid }}</vs-td>

              <vs-td :data="data[indextr].username">{{
                data[indextr].name
              }}</vs-td>

              <vs-td :data="data[indextr].id"
                >{{ data[indextr].adults }} Adults &
                {{ data[indextr].kids }} Kids</vs-td
              >
              <vs-td :data="data[indextr].id">{{
                data[indextr].number_of_room
              }}</vs-td>
              <vs-td :data="data[indextr].id">{{
                data[indextr].check_out
              }}</vs-td>
              <vs-td :data="data[indextr].id">{{ data[indextr].total }}</vs-td>
              <vs-td>
                <vs-chip
                  :color="getStatusColor(tr)"
                  class="product-order-status"
                  >{{ getStatus(tr) }}</vs-chip
                >
              </vs-td>
            </vs-tr>
          </template>
        </vs-table>
      </template>
    </vx-card>

    <!-- TODAYS CHECKOUT -->
    <vx-card title="TODAYS CHECKOUT'S" title-color="primary" class="mt-4">
      <template>
        <vs-table :data="todays_checkouts">
          <template slot="thead">
            <vs-th>ID</vs-th>
            <vs-th>GUEST NAME</vs-th>
            <vs-th>PEOPLE</vs-th>
            <vs-th>ROOMS COUNT</vs-th>
            <vs-th>CHECK IN</vs-th>
            <vs-th>TOTAL</vs-th>
            <vs-th>STATUS</vs-th>
          </template>

          <template slot-scope="{ data }">
            <vs-tr :key="indextr" v-for="(tr, indextr) in data">
              <vs-td :data="data[indextr].email">{{ data[indextr].uid }}</vs-td>

              <vs-td :data="data[indextr].username">{{
                data[indextr].name
              }}</vs-td>

              <vs-td :data="data[indextr].id"
                >{{ data[indextr].adults }} Adults &
                {{ data[indextr].kids }} Kids</vs-td
              >
              <vs-td :data="data[indextr].id">{{
                data[indextr].number_of_room
              }}</vs-td>
              <vs-td :data="data[indextr].id">{{
                data[indextr].check_in
              }}</vs-td>
              <vs-td :data="data[indextr].id">{{ data[indextr].total }}</vs-td>
              <vs-td>
                <vs-chip
                  :color="getStatusColor(tr)"
                  class="product-order-status"
                  >{{ getStatus(tr) }}</vs-chip
                >
              </vs-td>
            </vs-tr>
          </template>
        </vs-table>
      </template>
    </vx-card>
  </div>
</template>



<script>
import { mapGetters } from "vuex";
import axios from "axios";

import CreateBooking from "./booking/sub-components/CreateBooking";
import ViewBooking from "./booking/sub-components/ViewBooking";
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";

export default {
  data() {
    return {
      form: new Form({
        room_id: "",
      }),
      isAddNewPopup: false,
      isViewPopup: false,
      data: {},

      subscribersGained: {
        series: [
          {
            name: "Income",
            data: [28, 40, 36, 52, 38, 60, 55],
          },
        ],
        analyticsData: {
          subscribers: 92600,
        },
      },
      ordersRecevied: {
        series: [
          {
            name: "Expense",
            data: [10, 15, 8, 15, 7, 12, 8],
          },
        ],
        analyticsData: {
          orders: 97500,
        },
      },
    };
  },
  components: {
    CreateBooking,
    ViewBooking,
    StatisticsCardLine,
  },
  methods: {
    getStatusColor(data) {
      // if (status === "on_hold") return "warning";
      if (data.checked_in && !data.checked_out) return "success";
      if (data.checked_out && data.checked_in) return "danger";
      return "primary";
    },
    getStatus(data) {
      if (data.checked_in && !data.checked_out) return "CHECKED IN";
      if (data.checked_out && data.checked_in) return "CHECKED OUT";
      return "Active";
    },
    getData(id) {
      axios
        .get(`/api/reservation_rooms/room/${id}/view`)
        .then((response) => {
          this.data = response.data.data;
          // delete old data from store
          this.$store.dispatch("deleteAllSelectedRoom");
          this.$store.dispatch("deleteAllSelectedPayment");

          this.data.rooms.forEach((element) => {
            this.$store.dispatch("storeSelectedRoom", element);
          });
          this.data.payments.forEach((element) => {
            this.$store.dispatch("storeSelectedPayment", element);
          });

          // // delete paid service
          this.$store.dispatch("deleteAllReservationPaidService");
          this.$store.dispatch("retrieveReservationPaidServices", this.data.id);
          this.$store.dispatch(
            "RETRIEVE_RESERVATION_COLD_DRINKS",
            this.data.id
          );

          this.isViewPopup = true;
        })
        .catch(function (error) {});
    },

    getColor(id) {
      if (this.houseKeepings.length) {
        if (this.houseKeepings.includes(id)) {
          return "warning";
        }
      }
      if (this.availableRooms.length) {
        if (!this.availableRooms.includes(id)) {
          return "danger";
        } else {
          return "success";
        }
      } else {
        return "danger";
      }
    },
    clicked(room) {
      if (this.houseKeepings.includes(room.id)) {
        this.$vs.notify({
          title: "Do you want to remove from house keeping?",
          text: "Click here to remove from house keeping",
          color: "primary",

          click: () => {
            // Secondary function
            this.form.room_id = room.id;
            this.form.patch(`/api/house_keepings/${room.id}`).then(() => {
              this.$store.dispatch("retrieveAvailableRoomsToday");
              this.$store.dispatch("retrieveHouseKeepingRooms");
              this.$store.dispatch("retrieveRoomTypesWithRooms");
              this.$store.dispatch("retrieveRecentCheckins");
              this.$store.dispatch("retrieveTodaysCheckins");
              this.$store.dispatch("retrieveTodaysCheckouts");

              this.$vs.notify({
                title: "Removed from keeping",
                text: "Room is Available for checkin",
                color: "success",
                iconPack: "feather",
                icon: "icon-check",
              });
            });
          },
        });
      } else if (!this.availableRooms.includes(room.id)) {
        this.getData(room.id);
        this.$vs.notify({
          title: "Not Available",
          text: "This room is not available for checkin",
          color: "danger",
          iconPack: "feather",
          icon: "icon-x",
        });
      } else if (this.availableRooms.includes(room.id)) {
        this.isAddNewPopup = true;
        // delete old data from store
        this.$store.dispatch("deleteAllSelectedRoom");
        this.$store.dispatch("deleteAllSelectedPayment");
        // select room
        this.$store.dispatch("storeSelectedRoom", room);
      } else {
        this.$vs.notify({
          title: "Alert",
          text: "Something went wrong",
          color: "danger",
          iconPack: "feather",
          icon: "icon-x",
        });
      }
    },
    openLoadingDiv() {
      this.$vs.loading({ color: this.colorLoading });
      setTimeout(() => {
        this.$vs.loading.close();
      }, 2000);
    },
  },
  computed: {
    ...mapGetters({ roomTypes: "getRoomTypesWithRooms" }),
    ...mapGetters({ recent_checkins: "getRecentCheckins" }),
    ...mapGetters({ todays_checkins: "getTodaysCheckins" }),
    ...mapGetters({ todays_checkouts: "getTodaysCheckouts" }),
    ...mapGetters({ availableRooms: "getAvailableRoomsToday" }),
    ...mapGetters({ houseKeepings: "getHouseKeepings" }),
    ...mapGetters({ hotelDetails: "getHotelDetails" }),
    ...mapGetters({ dashboardDetails: "getDashboardDetails" }),
    greeting() {
      const today = new Date();
      const curHr = today.getHours();

      if (curHr < 12) {
        return "Good Morning";
      } else if (curHr < 16) {
        return "Good Afternoon";
      } else {
        return "Good Evening";
      }
    },
  },

  mounted() {
    this.$store.dispatch("retrieveAvailableRoomsToday");
    this.$store.dispatch("retrieveHouseKeepingRooms");
    this.$store.dispatch("retrieveRoomTypesWithRooms");
    this.$store.dispatch("retrieveRecentCheckins");
    this.$store.dispatch("retrieveTodaysCheckins");
    this.$store.dispatch("retrieveTodaysCheckouts");
    this.$store.dispatch("RETRIEVE_DASHBOARD_DETAILS");
  },
  created() {
    this.openLoadingDiv();
  },
};
</script>


<style lang="scss">
/*! rtl:begin:ignore */
#dashboard-analytics {
  .greet-user {
    position: relative;

    .decore-left {
      position: absolute;
      left: 0;
      top: 0;
    }
    .decore-right {
      position: absolute;
      right: 0;
      top: 0;
    }
  }

  @media (max-width: 576px) {
    .decore-left,
    .decore-right {
      width: 140px;
    }
  }
}
/*! rtl:end:ignore */
</style>
