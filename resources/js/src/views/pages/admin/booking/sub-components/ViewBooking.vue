<template>
  <vs-tabs v-if="mounted">
    <vs-tab :label="label">
      <form @keydown="data.errors.clear()">
        <div class="p-4">
          <div class="vx-row">
            <div class="vx-col w-full">
              <vs-button
                v-show="!data.checked_out && data.checked_in"
                color="danger"
                type="filled"
                size="small"
                @click="check_out(data.id)"
                >Check out</vs-button
              >
              <vs-button
                color="success"
                type="filled"
                size="small"
                v-print="'#printMe'"
                >Print Checkin</vs-button
              >
              <vs-button
                color="primary"
                type="filled"
                size="small"
                @click="generateInvoice"
              >
                <span v-if="data.invoice">View Invoice</span>
                <span v-else>Generate Invoice</span>
              </vs-button>
              <vs-button
                color="warning"
                type="filled"
                size="small"
                @click="generatePaidServiceBill"
                >Paid Service Bill</vs-button
              >

              <vs-button color="primary" type="filled" size="small" class="mt-2"
                >Edit</vs-button
              >
            </div>
          </div>
          <div id="printMe">
            <div class="only-print">
              <div class="vx-col">
                <h3>{{ hotelDetails.name }}</h3>
                <h5 class="mt-4 mb-4">CHECK IN RECEIPT</h5>
              </div>
            </div>
            <div class="vx-row mb-4 mt-4">
              <div class="vx-col w-1/2">
                <h5 class="mt-2">ID: {{ data.uid }}</h5>

                <p class="mt-2">Check in: {{ data.check_in }}</p>
                <p class="mt-2">Check out: {{ data.check_out }}</p>
              </div>
              <div class="vx-col w-1/2">
                <h6 class="mt-2">People:</h6>
                <p class="mt-2">
                  Adults: {{ data.adults }} &amp; Kids: {{ data.kids }}
                </p>
              </div>
            </div>

            <div class="vx-row">
              <div class="vx-col">
                <p>Room Details</p>
                <vs-chip
                  color="success"
                  class="product-order-status"
                  v-for="room in data.rooms"
                  v-if="data.rooms && data.rooms.length"
                  :key="room.id"
                  >{{ room.number }}</vs-chip
                >
              </div>
            </div>

            <p>Guest Details</p>

            <div class="vx-row mb-4">
              <div class="vx-col w-1/2">
                <p class="mt-2">Name: {{ data.name }}</p>
                <p class="mt-2">Phone: {{ data.phone }}</p>
                <p class="mt-2">Email: {{ data.email }}</p>
              </div>

              <div class="vx-col w-1/2">
                <p class="mt-2">Company Name: {{ data.company_name }}</p>
                <p class="mt-2">Gst: {{ data.gst_no }}</p>
              </div>
            </div>

            <div class="vx-row mb-4">
              <div class="vx-col">
                <div class="mt-4">
                  <h5>
                    Total: &#8377; {{ total }}&nbsp;&nbsp;| Exta: &#8377;
                    {{ extra }}&nbsp;&nbsp;| Cold Drinks: &#8377;
                    {{ cold_drink_total }}&nbsp;&nbsp;| &nbsp;&nbsp;Discount:
                    &#8377; {{ data.discount }} |&nbsp;&nbsp;Balance: &#8377;
                    {{ balance }}
                  </h5>
                </div>
              </div>
            </div>
            <div class="vx-row mt-4">
              <div class="vx-col text-center">
                <p class="text-center">Powered by VAwebsites.</p>
              </div>
            </div>
          </div>
        </div>
      </form>
    </vs-tab>
    <vs-tab label="Booked Rooms">
      <div class="tab-text">
        <EditRooms :title="title" :view="view"></EditRooms>
      </div>
    </vs-tab>
    <vs-tab label="Payments">
      <div class="tab-text">
        <AddPayment :id="data.id" :title="title"></AddPayment>
        <Payments :title="title"></Payments>
      </div>
    </vs-tab>
    <vs-tab label="Paid Services">
      <div class="tab-text">
        <PaidService :title="title" :id="data.id"></PaidService>
      </div>
    </vs-tab>
    <vs-tab label="Cold Drinks">
      <div class="tab-text">
        <ReservationColdDrink :id="data.id"></ReservationColdDrink>
      </div>
    </vs-tab>
  </vs-tabs>
</template>

<script>
import ReservationColdDrink from "./ReservationColdDrink";
import EditRooms from "./EditRooms";
import Payments from "./Payments";
import AddPayment from "./AddPayment";
import PaidService from "./PaidService";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import vSelect from "vue-select";

import { mapGetters } from "vuex";

export default {
  data() {
    return {
      configdateTimePicker: {
        enableTime: true,
        dateFormat: "d-m-Y H:i",
      },
      mounted: false,
      discount: 0,

      view: true,
    };
  },
  components: {
    flatPickr,
    EditRooms,
    Payments,
    AddPayment,
    "v-select": vSelect,
    PaidService,
    ReservationColdDrink,
  },
  props: ["title", "data"],
  computed: {
    type() {
      return this.$store.getters.getType;
    },
    label() {
      return `${this.title} Details`;
    },
    ...mapGetters({ paidServices: "getReservationPaidServices" }),
    ...mapGetters({ selectedRooms: "getSelectedRooms" }),
    ...mapGetters({ selectedPayments: "getSelectedPayments" }),
    ...mapGetters({ hotelDetails: "getHotelDetails" }),
    ...mapGetters({ cold_drinks: "getReservationColdDrinks" }),
    total() {
      // return this.selectedRooms.reduce(
      //   (prev, next) => prev + +next[this.type],
      //   0
      // );

      if (this.selectedRooms && this.selectedRooms.length) {
        let total = 0;
        for (let i = 0; i < this.selectedRooms.length; i++) {
          if (this.data.nights) {
            total += +this.selectedRooms[i][this.type] * this.data.nights;
          } else {
            total += +this.selectedRooms[i][this.type];
          }
        }
        return total;
      } else {
        return 0;
      }
    },
    extra() {
      if (this.paidServices && this.paidServices.length) {
        return this.paidServices.reduce((prev, next) => prev + +next.price, 0);
      } else {
        return 0;
      }
    },
    payments() {
      return this.selectedPayments.reduce(
        (prev, next) => prev + +next.amount,
        0
      );
    },
    cold_drink_total() {
      if (this.cold_drinks && this.cold_drinks.length) {
        return this.cold_drinks.reduce((prev, next) => prev + +next.total, 0);
      } else {
        return 0;
      }
    },
    balance() {
      return (
        +this.cold_drink_total +
        +this.extra +
        +this.total -
        +this.data.discount -
        this.payments
      );
    },
    availableRoomTypes() {
      return this.$store.getters.getAllAvailableRoomTypes;
    },
  },

  methods: {
    check_out(id) {
      this.$store.dispatch("CHECK_OUT", id).then((res) => {
        if (this.title === "Reservation") {
          this.$store.dispatch("retrieveReservations");
        } else {
          this.$store.dispatch("retrieveCheckIns");
        }
        this.$store.dispatch("retrieveAvailableRoomsToday");
        this.$store.dispatch("retrieveHouseKeepingRooms");
        this.$store.dispatch("retrieveRoomTypesWithRooms");
        this.$store.dispatch("retrieveRecentCheckins");
        this.$store.dispatch("retrieveTodaysCheckins");
        this.$store.dispatch("retrieveTodaysCheckouts");
        this.$vs.notify({
          color: "success",
          title: "Checked Out",
          text: "Successfully checked out",
        });
        // reload window
        window.location.reload();
      });
    },
    generateInvoice(event, con) {
      let routeData = this.$router.resolve({
        name: "generate-invoice",
        params: { id: this.data.id },
      });
      window.open(routeData.href, "_blank");
    },
    generatePaidServiceBill() {
      let routeData = this.$router.resolve({
        name: "generate-paid-service-bill",
        params: { id: this.data.id },
      });
      window.open(routeData.href, "_blank");
    },
  },
  mounted() {
    this.mounted = true;
  },
  created() {},
};
</script>

<style>
.only-print {
  display: none;
}

@media print {
  .only-print {
    display: block;
  }
}
</style>