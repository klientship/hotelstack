
<template>
  <div id="invoice-page">
    <div class="flex flex-wrap items-center justify-end">
      <!-- <vx-input-group class="mb-base mr-3">
        <vs-input v-model="mailTo" placeholder="Email" />

        <template slot="append">
          <div class="append-text btn-addon">
            <vs-button type="border" @click="mailTo = ''" class="whitespace-no-wrap">Send Invoice</vs-button>
          </div>
        </template>
      </vx-input-group>-->
      <div class="flex items-end">
        <!-- <vs-button
          class="mb-base mr-3"
          type="border"
          icon-pack="feather"
          icon="icon icon-download"
        >Download</vs-button>-->
        <vs-button
          class="mb-base mr-3"
          icon-pack="feather"
          icon="icon icon-file"
          @click="printInvoice"
          >Print</vs-button
        >
      </div>
    </div>

    <vx-card id="invoice-container">
      <!-- INVOICE METADATA -->
      <div class="vx-row leading-loose">
        <div class="vx-col w-1/2 mt-base">
          <!-- <img src="@assets/images/logo/logo.png" alt="vuexy-logo" />
          -->
          <h1>{{ hotelDetails.name.toUpperCase() }}</h1>
        </div>
        <div class="vx-col w-1/2 text-right">
          <h1>Invoice</h1>
          <div class="invoice__invoice-detail mt-6">
            <h6>INVOICE NO.</h6>
            <p>{{ invoice.invoice_no }}</p>

            <h6 class="mt-4">INVOICE DATE</h6>
            <p>{{ invoice.created_at }}</p>

            <h6 class="mt-4">ID: {{ invoice.uid }}</h6>
          </div>
        </div>

        <div class="vx-col w-1/2">
          <h5>Booking Details</h5>
          <p class="mt-4">CHECK IN : {{ invoice.check_in }}</p>

          <p>CHECK OUT : {{ invoice.check_out }}</p>
          <!-- <b>Payment Status</b>: Paid -->
          <!-- <vs-chip transparent color="primary">Paid</vs-chip>
          <br />-->
          <p>
            BOOKING STATUS : {{ invoice.status }}
            <!-- <vs-chip transparent color="success">Success</vs-chip> -->
          </p>
          <p>PEOPLE : {{ invoice.adults }} Adults & {{ invoice.kids }} Kids</p>

          <p>NIGHTS : {{ invoice.nights }}</p>
          <h5 class="mt-4">Guest</h5>
          <div class="invoice__recipient-info mt-2">
            <p>NAME: {{ invoice.name }}</p>
            <p>COMPANY: {{ invoice.company_name }}</p>
            <p>GST NO: {{ invoice.gst_no }}</p>
          </div>
          <div class="invoice__recipient-contact">
            <p class="flex items-center">
              <feather-icon icon="MailIcon" svgClasses="h-4 w-4"></feather-icon>
              <span class="ml-2">{{ invoice.email }}</span>
            </p>
            <p class="flex items-center">
              <feather-icon
                icon="PhoneIcon"
                svgClasses="h-4 w-4"
              ></feather-icon>
              <span class="ml-2">{{ invoice.phone }}</span>
            </p>
          </div>
        </div>
        <div class="vx-col w-1/2 mt-base text-right mt-12">
          <h5>{{ hotelDetails.name }}</h5>
          <div class="invoice__company-info my-4">
            <p>{{ hotelDetails.addressLine1 }}</p>
            <p>{{ hotelDetails.addressLine2 }}</p>
            <p>{{ hotelDetails.zipcode }}</p>
            <p>{{ hotelDetails.gst }}</p>
          </div>
          <div class="invoice__company-contact">
            <p class="flex items-center justify-end">
              <feather-icon icon="MailIcon" svgClasses="h-4 w-4"></feather-icon>
              <span class="ml-2">{{ hotelDetails.mailId }}</span>
            </p>
            <p class="flex items-center justify-end">
              <feather-icon
                icon="PhoneIcon"
                svgClasses="h-4 w-4"
              ></feather-icon>
              <span class="ml-2">{{ hotelDetails.mobile }}</span>
            </p>
          </div>
        </div>
      </div>

      <!-- INVOICE CONTENT -->
      <div>
        <!-- INVOICE TASKS TABLE -->
        <vs-table hoverFlat :data="invoice.rooms">
          <!-- HEADER -->
          <template slot="thead">
            <vs-th class="pointer-events-none">#</vs-th>
            <vs-th class="pointer-events-none">Room Type</vs-th>
            <vs-th class="pointer-events-none">Number</vs-th>
            <vs-th class="pointer-events-none">RATE</vs-th>

            <vs-th class="pointer-events-none">Tax Amount</vs-th>
            <vs-th class="pointer-events-none">Room Total</vs-th>
          </template>

          <!-- DATA -->
          <template slot-scope="{ data }">
            <vs-tr :key="indextr" v-for="(tr, indextr) in data">
              <vs-td>{{ indextr + 1 }}</vs-td>
              <vs-td>{{ data[indextr].type }}</vs-td>

              <vs-td>{{ data[indextr].number }}</vs-td>

              <vs-td>&#8377;{{ data[indextr].price }}</vs-td>

              <vs-td>&#8377; {{ calculateRoomTax(data[indextr]) }}</vs-td>
              <vs-td
                >&#8377;
                {{
                  data[indextr].price * invoice.nights +
                  calculateRoomTax(data[indextr])
                }}</vs-td
              >
            </vs-tr>
          </template>
        </vs-table>

        <!-- INVOICE SUMMARY TABLE -->
        <vs-table hoverFlat class="w-3/4 ml-auto mt-2" :data="invoiceData">
          <vs-tr>
            <vs-th class="pointer-events-none">SUBTOTAL</vs-th>
            <vs-td>&#8377; {{ total }}</vs-td>
          </vs-tr>
          <vs-tr>
            <vs-th class="pointer-events-none">TOTAL TAX</vs-th>
            <vs-td>&#8377; {{ total_tax }}</vs-td>
          </vs-tr>
          <vs-tr>
            <vs-th class="pointer-events-none">DISCOUNT</vs-th>
            <vs-td>&#8377; {{ invoice.discount }}</vs-td>
          </vs-tr>
          <vs-tr>
            <vs-th class="pointer-events-none">PAYABLE AMOUNT</vs-th>
            <vs-td>&#8377; {{ total + total_tax - invoice.discount }}</vs-td>
          </vs-tr>
        </vs-table>
      </div>

      <div class="invoice__footer text-right p-base">
        <p class="mb-4">Hand Crafted by VAwebsites</p>
      </div>
    </vx-card>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      message: "",
      invoiceNo: "",
      mailTo: "",

      guestDetails: {
        fullName: "Peter Stark",
        addressLine1: "8577 West West Drive ",
        addressLine2: "Holbrook, NY",
        zipcode: "90001",
        mailId: "peter@mail.com",
        mobile: "+91 988 888 8888",
      },

      invoiceData: {
        tasks: [
          {
            id: 1,
            task: "Website Redesign",
            hours: 60,
            rate: 15,
            amount: 90000,
          },
          {
            id: 2,
            task: "Newsletter template design",
            hours: 20,
            rate: 12,
            amount: 24000,
          },
        ],
        subtotal: 114000,
        discountPercentage: 5,
        discountedAmount: 5700,
        total: 108300,
      },
    };
  },
  computed: {
    ...mapGetters({ invoice: "getInvoice" }),
    ...mapGetters({ hotelDetails: "getHotelDetails" }),
    total() {
      if (this.invoice.rooms) {
        let total = 0;
        for (let i = 0; i < this.invoice.rooms.length; i++) {
          if (this.invoice.nights) {
            total += +this.invoice.rooms[i].price * +this.invoice.nights;
          } else {
            total += +this.invoice.rooms[i].price;
          }
        }
        return total;
      } else {
        return 0;
      }
    },
    balance() {
      return this.total - this.invoice.discount;
    },
    total_tax() {
      let total = 0;
      if (this.invoice.rooms) {
        this.invoice.rooms.forEach((room) => {
          let room_total = +room.price * +this.invoice.nights;
          if (+room_total > 999 && +room_total < 2500) {
            total = total + (parseInt(room_total) * parseInt(room.tax_1)) / 100;
          } else if (+room_total > 2499) {
            total = total + (parseInt(room_total) * parseInt(room.tax_2)) / 100;
          }
        });
      }
      return total;
    },
  },
  methods: {
    generateInvoiceNumber(id) {
      const my_id = "0000" + id;
      return `INV2021${my_id}`;
    },
    calculateRoomTax(data) {
      // if (+data.price > 999 && +data.price < 2500) {
      //   return (+data.price * +data.tax_1) / 100;
      // } else if (+data.price > 2499) {
      //   return (+data.price * +data.tax_2) / 100;
      // } else {
      //   return 0;
      // }

      const total = +data.price * +this.invoice.nights;

      if (+total > 999 && +total < 2500) {
        return (+total * +data.tax_1) / 100;
      } else if (+total > 2499) {
        return (+total * +data.tax_2) / 100;
      } else {
        return 0;
      }
    },
    printInvoice() {
      window.print();
    },
  },
  components: {},
  mounted() {
    this.$emit("setAppClasses", "invoice-page");
  },
  created() {
    this.$store.dispatch("retrieveInvoice", this.$route.params.id);
  },
};
</script>

<style lang="scss">
@media print {
  .invoice-page {
    * {
      visibility: hidden;
    }

    #content-area {
      margin: 0 !important;
    }

    .vs-con-table {
      .vs-con-tbody {
        overflow: hidden !important;
      }
    }

    #invoice-container,
    #invoice-container * {
      visibility: visible;
    }
    #invoice-container {
      position: absolute;
      left: 0;
      top: 0;
      box-shadow: none;
    }
  }
}

@page {
  size: auto;
}
</style>
