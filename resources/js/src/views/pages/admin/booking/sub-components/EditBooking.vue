<template>
  <vs-tabs v-if="mounted">
    <vs-tab :label="label">
      <!-- ERRORS -->
      <display-error :form="data"></display-error>
      <!-- end Errors -->

      <form @keydown="data.errors.clear()">
        <div class="p-4">
          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              Room Type
              <v-select
                label="label"
                :options="options"
                @input="selectType($event)"
                :dir="$vs.rtl ? 'rtl' : 'ltr'"
              />
              <br />
            </div>
            <div class="vx-col w-1/2">
              <vs-input
                :danger="data.errors.has('oyo_id')"
                class="w-full"
                label-placeholder="Oyo ID"
                v-model="data.oyo_id"
                v-show="display_oyo_id"
              />
            </div>
          </div>
          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <flat-pickr
                :config="configdateTimePicker"
                v-model="check_in"
                placeholder="Check in"
                class="w-full"
                @input="getAvailableRooms"
              />
            </div>
            <div class="vx-col w-1/2">
              <flat-pickr
                :config="configdateTimePicker"
                v-model="check_out"
                placeholder="Check out"
                class="w-full"
                @input="getAvailableRooms"
              />
            </div>
          </div>

          <div class="contained-example-container">
            <div id="div-with-loading" class="vs-con-loading__container">
              <div
                v-if="
                  availableRoomTypes &&
                  availableRoomTypes.length &&
                  check_in &&
                  check_out
                "
              >
                <p class="mb-4">Select Room</p>

                <div class="vx-row mb-4">
                  <div
                    class="vx-col w-full mb-4"
                    v-for="roomtype in availableRoomTypes"
                    :key="roomtype.id"
                  >
                    <p>{{ roomtype.title }}</p>
                    <div class="mt-2">
                      <button
                        type="button"
                        class="mr-2 pl-2 pr-2 pt-1 pb-1 small room-button"
                        :class="
                          selectedRooms.some((el) => el.id == room.id)
                            ? 'room-selected'
                            : ''
                        "
                        v-for="room in roomtype.rooms"
                        @click.prevent="selectRoom(room, roomtype)"
                        :key="room.id"
                      >
                        {{ room.number }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <vs-input
                class="w-full"
                label-placeholder="Adults"
                v-model="data.adults"
              />
            </div>
            <div class="vx-col w-1/2">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Kids"
                v-model="data.kids"
              />
            </div>
          </div>

          <p>Guest Details</p>

          <div class="vx-row mb-4">
            <div class="vx-col w-1/3">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Name"
                v-model="data.name"
              />
            </div>
            <div class="vx-col w-1/3">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Phone"
                v-model="data.phone"
              />
            </div>
            <div class="vx-col w-1/3">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Email"
                v-model="data.email"
              />
            </div>
          </div>
          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Company Name"
                v-model="data.company_name"
              />
            </div>
            <div class="vx-col w-1/2">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="GST No"
                v-model="data.gst_no"
              />
            </div>
          </div>

          <div class="vx-row mb-4">
            <div class="vx-col w-full">
              <vs-textarea label="Address" v-model="data.address" />
            </div>
          </div>

          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="UID"
                v-model="data.uid"
              />
            </div>
            <!-- <div class="vx-col w-1/2">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Discount"
                v-model="data.discount"
              />
            </div> -->
          </div>

          <div class="vx-row mt-4">
            <div class="vx-col w-full">
              <ul class="switch-container">
                <li>
                  <label>Status</label>
                  <vs-switch v-model="data.status" class="mb-4 mt-1" />
                </li>
              </ul>
            </div>
          </div>

          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <vs-button
                class="mr-3 mb-4"
                @click.prevent="onUpdate"
                :disabled="data.errors.any()"
                >Update</vs-button
              >
              <vs-button
                color="warning"
                type="border"
                class="mb-4"
                @click="reset"
                >Reset</vs-button
              >
            </div>
            <div class="vx-col">
              <div class="mt-4">
                <h5>
                  Total: &#8377; {{ total }} |&nbsp;&nbsp;Balance: &#8377;
                  {{ balance }}
                </h5>
              </div>
            </div>
          </div>
        </div>
      </form>
    </vs-tab>
    <vs-tab label="Selected Rooms">
      <div class="tab-text">
        <EditRooms :title="title"></EditRooms>
      </div>
    </vs-tab>
    <vs-tab label="Payments">
      <div class="tab-text">
        <Payments></Payments>
      </div>
    </vs-tab>
    <vs-tab label="Add Payment">
      <div class="tab-text">
        <AddPayment :id="data.id" :title="title"></AddPayment>
      </div>
    </vs-tab>
  </vs-tabs>
</template>

<script>
import EditRooms from "./EditRooms";
import Payments from "./Payments";
import AddPayment from "./AddPayment";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import vSelect from "vue-select";

import { mapGetters } from "vuex";

export default {
  data() {
    return {
      display_oyo_id: false,
      configdateTimePicker: {
        enableTime: true,
        dateFormat: "d-m-Y H:i",
      },
      mounted: false,
      discount: 0,
      check_in: "",
      check_out: "",
      type: "price",

      options: [
        { label: "AC", value: "ac_price" },
        { label: "NON AC", value: "price" },
        { label: "OYO", value: "oyo_price" },
        { label: "OTHER", value: "other_price" },
      ],
    };
  },
  components: {
    flatPickr,
    EditRooms,
    Payments,
    AddPayment,
    "v-select": vSelect,
  },
  props: ["title", "data"],
  computed: {
    type() {
      return this.$store.getters.getType;
    },
    label() {
      return `${this.title} Details`;
    },
    ...mapGetters({ selectedRooms: "getSelectedRooms" }),
    ...mapGetters({ selectedPayments: "getSelectedPayments" }),
    total() {
      let nights;
      if (this.selectedRooms && this.selectedRooms.length) {
        if (this.check_in && this.check_out) {
          nights = this.getNights(this.check_in, this.check_out);
        } else {
          nights = this.data.nights;
        }

        let total = 0;
        for (let i = 0; i < this.selectedRooms.length; i++) {
          if (nights) {
            total += +this.selectedRooms[i][this.type] * nights;
          } else {
            total += +this.selectedRooms[i][this.type];
          }
        }
        return total;
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
    balance() {
      return +this.total - +this.data.discount - this.payments;
    },
    availableRoomTypes() {
      return this.$store.getters.getAllAvailableRoomTypes;
    },
  },

  methods: {
    selectType(data) {
      this.type = data.value;
      if (data.value === "oyo_price") {
        this.display_oyo_id = true;
        this.data.oyo = true;
      } else {
        this.display_oyo_id = false;
        this.data.oyo = false;
      }
      this.$store.dispatch("selectRoomType", data.value);
    },
    reset() {
      this.check_in = this.check_out = this.data.adults = this.data.kids = this.data.name = this.data.phone = this.data.email = this.data.oyo_id;
      ("");
      this.data.status = true;
      this.data.rooms = [];
      this.data.total = this.data.balance = this.data.discount = 0;
      this.$store.dispatch("deleteAllSelectedRoom");
    },

    onUpdate() {
      this.data.rooms = this.selectedRooms;
      this.data.payments = this.selectedPayments;
      this.data.total = this.total;
      this.data.balance = this.balance;
      if (this.check_in !== "" && this.check_out !== "") {
        this.data.check_in = this.check_in;
        this.data.check_out = this.check_out;
      }

      this.data
        .submit("patch", `/api/reservations/${this.data.id}`)
        .then(() => {
          if (this.title === "Reservation") {
            this.$store.dispatch("retrieveReservations");
          } else {
            this.$store.dispatch("retrieveCheckIns");
          }

          this.$vs.notify({
            color: "success",
            title: "Created",
            text: `${this.title} Updated Successfully.`,
          });
        })
        .catch();
    },
    getAvailableRooms() {
      if (this.check_in && this.check_out) {
        if (this.selectedRooms.length > 0) {
          this.$vs.notify({
            color: "danger",
            title: "Alert",
            text: `Please delete selected rooms`,
          });
        } else {
          this.$vs.loading({
            container: "#div-with-loading",
            scale: 0.6,
          });
          setTimeout(() => {
            this.$vs.loading.close("#div-with-loading > .con-vs-loading");
          }, 1000);

          this.$store.dispatch("retrieveAvailableRooms", {
            check_in: this.check_in,
            check_out: this.check_out,
          });
        }
      }
    },
    selectRoom(room, roomtype) {
      if (this.selectedRooms.some((el) => el.id == room.id)) {
        this.$store.dispatch("deleteSelectedRoom", room.id);
      } else {
        //  store room
        room.price = room[this.type];
        this.$store.dispatch("storeSelectedRoom", room);
      }
    },
    getNights(check_in, check_out) {
      const check_in_date = moment(check_in, "DD-MM-YYYY HH:mm");
      const check_out_date = moment(check_out, "DD-MM-YYYY HH:mm");

      let hours = check_out_date.diff(check_in_date, "hours");
      let quotient = Math.floor(hours / 24);
      let remainder = hours % 24;
      let nights = quotient;
      // if greater than or equal to 26 hours add +1
      if (remainder >= 2) {
        nights += 1;
      } else if (nights < 1) {
        nights = 1;
      }
      return nights;
    },
  },
  mounted() {
    this.mounted = true;
  },
};
</script>