<template>
  <vs-tabs>
    <vs-tab :label="label">
      <!-- ERRORS -->
      <display-error :form="form"></display-error>
      <!-- end Errors -->

      <form @keydown="form.errors.clear()">
        <div class="p-4">
          <div class="vx-row mb-4">
            <div class="vx-col w-full">
              Room Type
              <v-select
                label="label"
                :options="options"
                @input="selectType($event)"
                :dir="$vs.rtl ? 'rtl' : 'ltr'"
              />
              <br />
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
            </div>
            <div class="vx-col w-1/2">
              <flat-pickr
                :config="configdateTimePicker"
                v-model="form.check_out"
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
                v-model="form.adults"
              />
            </div>
            <div class="vx-col w-1/2">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Kids"
                v-model="form.kids"
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
                v-model="form.name"
              />
            </div>
            <div class="vx-col w-1/3">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Phone"
                v-model="form.phone"
              />
            </div>
            <div class="vx-col w-1/3">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Email"
                v-model="form.email"
              />
            </div>
          </div>
          <div class="vx-row mb-4">
            <div class="vx-col w-1/2">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="Company Name"
                v-model="form.company_name"
              />
            </div>
            <div class="vx-col w-1/2">
              <vs-input
                type="text"
                class="w-full"
                label-placeholder="GST No"
                v-model="form.gst_no"
              />
            </div>
          </div>
          <div class="vx-row mb-4">
            <div class="vx-col w-full">
              <vs-textarea label="Address" v-model="form.address" />
            </div>
          </div>

          <div class="vx-row mb-4">
            <div class="vx-col w-3/4">
              <vs-button
                class="mr-3 mb-4"
                @click.prevent="onSubmit"
                :disabled="
                  form.errors.any() ||
                  form.check_in === '' ||
                  form.check_out === '' ||
                  form.adults === '' ||
                  form.kids === '' ||
                  form.name === '' ||
                  form.phone === ''
                "
                >Pay Now</vs-button
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
                <h5>Total: &#8377; {{ total + total_tax }}</h5>
              </div>
            </div>
          </div>
        </div>
      </form>
    </vs-tab>
    <vs-tab label="Selected Rooms">
      <EditRooms isOnline="true"></EditRooms>
    </vs-tab>
  </vs-tabs>
</template>


<script>
import EditRooms from "../../admin/booking/sub-components/EditRooms";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import vSelect from "vue-select";

import { mapGetters } from "vuex";

const __DEV__ =
  document.domain === "localhost" || document.domain === "127.0.0.1";

export default {
  components: {
    flatPickr,
    EditRooms,
    "v-select": vSelect,
  },
  data() {
    return {
      options: [
        { label: "AC", value: "ac_price" },
        { label: "NON AC", value: "price" },
        // { label: "OTHER", value: "other_price" },
      ],
      form: new Form({
        adults: "",
        type: "",
        kids: "",
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
      }),
      payment: {
        name: "",
        amount: 0,
        contactNumber: "",
        address: "",
        email: "",
      },
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
    total_tax() {
      let total = 0;
      if (this.selectedRooms) {
        // nights calculation
        const nights = this.getNights(this.form.check_in, this.form.check_out);
        this.selectedRooms.forEach((room) => {
          let room_total = +room.price * +nights;
          if (+room_total > 999 && +room_total < 2500) {
            total = total + (parseInt(room_total) * parseInt(room.tax_1)) / 100;
          } else if (+room_total > 2499) {
            total = total + (parseInt(room_total) * parseInt(room.tax_2)) / 100;
          }
        });
      }
      return total;
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
  },
  methods: {
    reset() {
      this.form.check_in = this.form.check_out = this.form.adults = this.form.kids = this.form.name = this.form.phone = this.form.email =
        "";
      this.form.status = true;
      this.form.rooms = [];
      this.form.advance = this.form.total = this.form.balance = this.discount = 0;
      this.$store.dispatch("deleteAllSelectedRoom");
    },

    loadScript(src) {
      return new Promise((resolve) => {
        const script = document.createElement("script");
        script.src = src;

        script.onload = () => {
          resolve(true);
        };
        script.onerror = () => {
          resolve(false);
        };
        document.body.appendChild(script);
      });
    },

    async displayRazorpay() {
      const res = await this.loadScript(
        "https://checkout.razorpay.com/v1/checkout.js"
      );
      if (!res) {
        alert(
          "Razorpay SDK failed to load. Please make sure you have stable internet connnection"
        );
        return;
      }

      const data = await this.$http
        .post("/api/transactions/initiate_payment", this.payment)
        .then((res) => {
          return res.data;
        });
      const options = {
        key: response.razorpayId, // Enter the Key ID generated from the Dashboard
        amount: data.amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        currency: data.currency,
        name: data.name,
        description: data.description,
        image: "https://i.ibb.co/Bz2SfCt/favicon.png",
        order_id: data.orderId, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
        handler: function (response) {
          alert(response.razorpay_payment_id);
          alert(response.razorpay_order_id);
          alert(response.razorpay_signature);
        },
        prefill: {
          name: data.name,
          email: data.email,
          contact: data.contactNumber,
        },
        notes: {
          address: data.address,
        },
        theme: {
          color: "#F37254",
        },
      };
      const rzp1 = new Razorpay(options);
      rzp1.open();
    },

    onSubmit() {
      this.createReservation();
    },

    createReservation() {
      this.form.rooms = this.selectedRooms;
      this.form.total = this.total;
      this.form.balance = this.balance;

      if (this.title === "Reservation") {
        this.form.checked_in = 0;
      } else {
        this.form.checked_in = 1;
      }

      // copy
      this.payment.name = this.form.name;
      this.payment.amount = this.total + this.total_tax;
      this.payment.email = this.form.email;
      this.payment.contactNumber = this.form.phone;
      this.payment.address = this.form.address;

      this.form
        .submit("post", "/api/reservations")
        .then(() => {
          this.$vs.loading({ color: this.colorLoading });
          setTimeout(() => {
            this.$vs.loading.close();
          }, 3000);
          this.displayRazorpay();

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
          this.$store.dispatch("retrieveRecentCheckins");
          this.$store.dispatch("retrieveTodaysCheckins");
          this.$store.dispatch("retrieveTodaysCheckouts");

          this.$vs.notify({
            color: "success",
            title: "Created",
            text: `${this.label} created successfully.`,
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