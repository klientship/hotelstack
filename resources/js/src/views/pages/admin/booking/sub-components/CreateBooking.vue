<template>
  <vs-tabs>
    <vs-tab :label="label">
      <form @keydown="form.errors.clear()">
        <div class="p-4">
          <div class="vx-row">
            <div class="vx-col w-1/2">
              <p>Room Type</p>
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
                :danger="form.errors.has('oyo_id')"
                class="w-full"
                label-placeholder="Oyo ID"
                v-model="form.oyo_id"
                v-show="display_oyo_id"
              />
            </div>
          </div>

          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <flat-pickr
                :config="configdateTimePicker"
                v-model="form.check_in"
                placeholder="Check in"
                class="w-full"
                @input="getAvailableRooms"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('check_in')"
                >{{ form.errors.get("check_in") }}</span
              >
            </div>
            <div class="vx-col w-1/2">
              <flat-pickr
                :config="configdateTimePicker"
                v-model="form.check_out"
                placeholder="Check out"
                class="w-full"
                @input="getAvailableRooms"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('check_out')"
                >{{ form.errors.get("check_out") }}</span
              >
            </div>
          </div>

          <div class="contained-example-container">
            <div id="div-with-loading" class="vs-con-loading__container">
              <div
                v-if="
                  availableRoomTypes &&
                  availableRoomTypes.length &&
                  form.check_in &&
                  form.check_out
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
                    <span
                      class="text-danger text-sm"
                      v-show="form.errors.has('rooms')"
                      >{{ form.errors.get("rooms") }}</span
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <vs-input
                :danger="form.errors.has('adults')"
                class="w-full"
                label-placeholder="Adults"
                v-model="form.adults"
              />

              <span
                class="text-danger text-sm"
                v-show="form.errors.has('adults')"
                >{{ form.errors.get("adults") }}</span
              >
            </div>
            <div class="vx-col w-1/2">
              <vs-input
                :danger="form.errors.has('kids')"
                type="text"
                class="w-full"
                label-placeholder="Kids"
                v-model="form.kids"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('kids')"
                >{{ form.errors.get("kids") }}</span
              >
            </div>
          </div>

          <p>Guest Details</p>

          <div class="vx-row mb-4">
            <div class="vx-col w-1/3">
              <vs-input
                :danger="form.errors.has('name')"
                type="text"
                class="w-full"
                label-placeholder="Name"
                v-model="form.name"
              />

              <span
                class="text-danger text-sm"
                v-show="form.errors.has('name')"
                >{{ form.errors.get("name") }}</span
              >
            </div>
            <div class="vx-col w-1/3">
              <vs-input
                :danger="form.errors.has('phone')"
                type="text"
                class="w-full"
                label-placeholder="Phone"
                v-model="form.phone"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('phone')"
                >{{ form.errors.get("phone") }}</span
              >
            </div>
            <div class="vx-col w-1/3">
              <vs-input
                :danger="form.errors.has('email')"
                type="text"
                class="w-full"
                label-placeholder="Email"
                v-model="form.email"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('email')"
                >{{ form.errors.get("email") }}</span
              >
            </div>
          </div>
          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <vs-input
                :danger="form.errors.has('company_name')"
                type="text"
                class="w-full"
                label-placeholder="Company Name"
                v-model="form.company_name"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('company_name')"
                >{{ form.errors.get("company_name") }}</span
              >
            </div>
            <div class="vx-col w-1/2">
              <vs-input
                :danger="form.errors.has('gst_no')"
                type="text"
                class="w-full"
                label-placeholder="GST No"
                v-model="form.gst_no"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('gst_no')"
                >{{ form.errors.get("gst_no") }}</span
              >
            </div>
          </div>
          <div class="vx-row mb-4">
            <div class="vx-col w-full">
              <vs-textarea
                :danger="form.errors.has('address')"
                label="Address"
                v-model="form.address"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('address')"
                >{{ form.errors.get("address") }}</span
              >
            </div>
          </div>

          <div class="vx-row mb-4">
            <div class="vx-col w-1/3">
              <vs-input
                :danger="form.errors.has('discount')"
                type="text"
                class="w-full"
                label-placeholder="Discount"
                v-model="form.discount"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('discount')"
                >{{ form.errors.get("discount") }}</span
              >
            </div>

            <div class="vx-col w-1/3">
              <vs-input
                :danger="form.errors.has('advance')"
                type="text"
                class="w-full"
                label-placeholder="Advance"
                v-model="form.advance"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('advance')"
                >{{ form.errors.get("advance") }}</span
              >
            </div>
            <div class="vx-col w-1/3">
              <p class="text-xs text-opacity-25s">Payment type</p>
              <v-select
                :options="['Cash', 'Card', 'UPI', 'Online']"
                :dir="$vs.rtl ? 'rtl' : 'ltr'"
                v-model="form.payment_type"
                class="mt-2"
              />
              <span
                class="text-danger text-sm"
                v-show="form.errors.has('payment_type')"
                >{{ form.errors.get("payment_type") }}</span
              >
            </div>
          </div>

          <!-- <div class="vx-row mt-4">
            <div class="vx-col w-full">
              <ul class="switch-container">
                <li>
                  <label>Status</label>
                  <vs-switch v-model="form.status" class="mb-4 mt-1" />
                </li>
              </ul>
            </div>
          </div> -->

          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <vs-button
                class="mr-3 mb-4"
                @click.prevent="onSubmit"
                :disabled="form.errors.any()"
                >Submit</vs-button
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
                  Nights: {{ nights }} |&nbsp;&nbsp;Total: &#8377;
                  {{ total }} |&nbsp;&nbsp;Balance: &#8377;
                  {{ balance }}
                </h5>
              </div>
            </div>
          </div>
        </div>
      </form>
      <!-- ERRORS -->
      <display-error :form="form"></display-error>
      <!-- end Errors -->
    </vs-tab>
    <vs-tab label="Selected Rooms">
      <EditRooms></EditRooms>
    </vs-tab>
  </vs-tabs>
</template>


<script>
import EditRooms from "./EditRooms";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import vSelect from "vue-select";

import { mapGetters } from "vuex";
export default {
  components: {
    flatPickr,
    EditRooms,
    "v-select": vSelect,
  },
  data() {
    return {
      display_oyo_id: false,
      options: [
        { label: "AC", value: "ac_price" },
        { label: "NON AC", value: "price" },
        { label: "OYO", value: "oyo_price" },
        { label: "OTHER", value: "other_price" },
      ],
      form: new Form({
        adults: 1,
        type: "",
        kids: 0,
        check_in: "",
        check_out: "",
        total: 0,
        discount: 0,
        advance: 0,
        balance: 0,
        rooms: [],
        name: "",
        phone: "",
        email: "",
        company_name: "",
        address: "",
        gst_no: "",
        checked_in: 0,
        status: true,
        payment_type: "Cash",
        oyo_id: "",
        oyo: false,
      }),
      configdateTimePicker: {
        enableTime: true,
        dateFormat: "d-m-Y H:i",
      },
    };
  },
  props: ["title"],
  computed: {
    ...mapGetters({ selectedRooms: "getSelectedRooms" }),
    ...mapGetters({ type: "getType" }),

    total() {
      if (this.selectedRooms && this.selectedRooms.length) {
        // nights calculation
        const nights = this.getNights(this.form.check_in, this.form.check_out);
        // end nights calculation
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
    balance() {
      return this.total - this.form.advance - this.form.discount;
    },
    availableRoomTypes() {
      return this.$store.getters.getAllAvailableRoomTypes;
    },
    label() {
      return `${this.title} Details`;
    },
    nights() {
      if (this.form.check_in && this.form.check_out) {
        return this.getNights(this.form.check_in, this.form.check_out);
      } else {
        return 1;
      }
    },
  },
  mounted() {
    this.form.check_in = moment().format("DD-MM-YYYY HH:mm");
  },
  methods: {
    openLoadingDiv() {
      this.$vs.loading({ color: this.colorLoading });
      setTimeout(() => {
        this.$vs.loading.close();
      }, 2000);
    },
    reset() {
      this.form.check_in = this.form.check_out = this.form.adults = this.form.kids = this.form.name = this.form.phone = this.form.email =
        "";
      this.form.status = true;
      this.form.rooms = [];
      this.form.advance = this.form.total = this.form.balance = this.discount = 0;
      this.$store.dispatch("deleteAllSelectedRoom");
    },

    onSubmit() {
      this.openLoadingDiv();
      this.form.rooms = this.selectedRooms;
      this.form.total = this.total;
      this.form.balance = this.balance;

      if (this.title === "Reservation") {
        this.form.checked_in = 0;
      } else {
        this.form.checked_in = 1;
      }
      this.form
        .submit("post", "/api/reservations")
        .then(() => {
          this.reset();

          if (this.title === "Reservation") {
            this.$store.dispatch("retrieveReservations");
          } else {
            this.$store.dispatch("retrieveCheckIns");
          }

          this.$store.dispatch("deleteAllSelectedRoom");

          // update dashboard
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

          this.$vs.notify({
            color: "success",
            title: "Created",
            text: `Created successfully.`,
          });
        })
        .catch();
    },
    getAvailableRooms() {
      if (this.form.check_in && this.form.check_out) {
        this.$vs.loading({
          container: "#div-with-loading",
          scale: 0.6,
        });
        setTimeout(() => {
          this.$vs.loading.close("#div-with-loading > .con-vs-loading");
        }, 1000);

        this.$store.dispatch("retrieveAvailableRooms", {
          check_in: this.form.check_in,
          check_out: this.form.check_out,
        });
      }
    },
    selectRoom(room, roomtype) {
      if (this.selectedRooms.some((el) => el.id == room.id)) {
        this.$store.dispatch("deleteSelectedRoom", room.id);
      } else {
        //  store room
        room.price = room[this.form.type];
        this.$store.dispatch("storeSelectedRoom", room);
      }
    },
    selectType(data) {
      this.form.type = data.value;
      if (data.value === "oyo_price") {
        this.display_oyo_id = true;
        this.form.oyo = true;
      } else {
        this.display_oyo_id = false;
        this.form.oyo = false;
      }
      this.$store.dispatch("selectRoomType", data.value);
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
};
</script>

<style lang="stylus" scoped>
.room-button {
  border: 0.1rem solid rgb(40, 199, 111);
  border-radius: 0.25rem;
  color: rgb(40, 199, 111);
  background-color: transparent;
  cursor: pointer;
}

.room-selected {
  background-color: rgb(40, 199, 111);
  color: white;
}
</style>