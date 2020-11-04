<template>
  <div>
    <!-- ERRORS -->
    <display-error :form="form"></display-error>
    <!-- end Errors -->

    <form @keydown="form.errors.clear()">
      <div class="p-4">
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <vs-input
              class="w-full"
              label-placeholder="Amount"
              v-model="form.amount"
            />
          </div>
        </div>
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            Payment Type
            <v-select
              v-model="form.type"
              :options="options"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <br />
          </div>
        </div>
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            Advance
            <vs-switch v-model="form.advance" class="mb-4 mt-1" />
          </div>
        </div>

        <div class="vx-row mb-4">
          <div class="vx-col w-1/2">
            <vs-button
              class="mr-3 mb-4"
              @click.prevent="onSubmit"
              :disabled="!form.amount && form.amount < 1"
              >Submit</vs-button
            >
            <vs-button color="warning" type="border" class="mb-4" @click="reset"
              >Reset</vs-button
            >
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import vSelect from "vue-select";

export default {
  props: ["id", "title"],
  components: {
    "v-select": vSelect,
  },
  data() {
    return {
      form: new Form({
        amount: 0,
        reservation_id: "",
        advance: false,
        type: "CASH",
        created_at: moment().format("DD-MM-YYYY h:mm a"),
      }),

      options: ["CASH", "CARD", "UPI", "ONLINE", "OTHER"],
    };
  },
  methods: {
    getDateFormat(date, format) {
      return moment(date).format(format);
    },
    reset() {
      this.form.amount = 0;
      this.form.advance = false;
      this.form.reservation_id = this.id;
      this.form.type = "CASH";
    },
    onSubmit() {
      this.form.reservation_id = this.id;

      this.form
        .submit("post", "/api/payments")
        .then(() => {
          if (this.title === "Reservation") {
            this.$store.dispatch("retrieveReservations");
          } else {
            this.$store.dispatch("retrieveCheckIns");
          }
          this.$store.dispatch("retrieveAllReservationPayments", this.id);
          this.$store.dispatch("retrieveAvailableRoomsToday");
          this.$store.dispatch("retrieveHouseKeepingRooms");
          this.$store.dispatch("retrieveRoomTypesWithRooms");
          this.$store.dispatch("RETRIEVE_AWAITING_CHECKOUTS");
          this.$store.dispatch("RETRIEVE_OYO_BOOKINGS_ID");
          this.$store.dispatch("retrieveRecentCheckins");
          this.$store.dispatch("retrieveTodaysCheckins");
          this.$store.dispatch("retrieveTodaysCheckouts");
          this.$store.dispatch("RETRIEVE_DASHBOARD_DETAILS");
          this.$store.dispatch("RETRIEVE_TOTAL_ROOMS");
          this.$store.dispatch("RETRIEVE_WALKIN_BOOKINGS_ROOMS_ID");

          this.$vs.notify({
            color: "success",
            title: "Created",
            text: "Payment added successfully.",
          });
        })
        .catch();
    },
  },
};
</script>