<template>
  <div id="data-list-list-view" class="data-list-container">
    <vs-table
      ref="table"
      multiple
      v-model="selected"
      pagination
      :max-items="itemsPerPage"
      search
      :data="products"
    >
      <div
        slot="header"
        class="flex flex-wrap-reverse items-center flex-grow justify-between"
      >
        <div
          class="flex flex-wrap-reverse items-center data-list-btn-container"
        >
          <!-- ACTION - DROPDOWN -->
          <vs-dropdown
            vs-trigger-click
            class="dd-actions cursor-pointer mr-4 mb-4"
          >
            <div
              class="p-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer flex items-center justify-center text-lg font-medium w-full"
            >
              <span class="mr-2">Actions</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>

            <vs-dropdown-menu>
              <vs-dropdown-item @click="deleteSelected">
                <span class="flex items-center">
                  <feather-icon
                    icon="TrashIcon"
                    svgClasses="h-4 w-4"
                    class="mr-2"
                  />
                  <span>Delete</span>
                </span>
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>

          <!-- ADD NEW -->
          <div
            class="btn-add-new p-3 mb-4 mr-4 rounded-lg cursor-pointer flex items-center justify-center text-lg font-medium text-primary border border-solid border-primary"
            @click="addNewData"
          >
            <feather-icon icon="PlusIcon" svgClasses="h-4 w-4" />
            <span class="ml-2 text-base text-primary">Add New</span>
          </div>
        </div>

        <!-- ITEMS PER PAGE -->
        <vs-dropdown
          vs-trigger-click
          class="cursor-pointer mb-4 mr-4 items-per-page-handler"
        >
          <div
            class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
          >
            <span class="mr-2"
              >{{ currentPage * itemsPerPage - (itemsPerPage - 1) }} -
              {{
                products.length - currentPage * itemsPerPage > 0
                  ? currentPage * itemsPerPage
                  : products.length
              }}
              of {{ queriedItems }}</span
            >
            <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
          </div>
          <vs-dropdown-menu>
            <vs-dropdown-item @click="itemsPerPage = 4">
              <span>4</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage = 10">
              <span>10</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage = 15">
              <span>15</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage = 20">
              <span>20</span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <template slot="thead">
        <vs-th sort-key="title">Rooms</vs-th>
        <vs-th sort-key="description">Date</vs-th>
        <vs-th sort-key="base_price">Guest</vs-th>
        <vs-th sort-key="base_price">People</vs-th>
        <vs-th sort-key="base_price">Rooms Count</vs-th>
        <vs-th sort-key="base_price">Check in</vs-th>
        <vs-th sort-key="base_price">Check out</vs-th>
        <vs-th sort-key="base_price">Total</vs-th>
        <vs-th sort-key="status">Status</vs-th>
        <vs-th>Action</vs-th>
      </template>

      <template slot-scope="{ data }">
        <tbody>
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td>
              <vs-chip
                color="success"
                v-if="tr.rooms && tr.rooms.length"
                v-for="room in tr.rooms"
                :key="room.id"
                >{{ room.number }}</vs-chip
              >
            </vs-td>
            <vs-td>
              <p class="product-category">
                {{ getDateFormat(tr.date, "DD/MM/YYYY h:mm a") }}
              </p>
            </vs-td>
            <vs-td>
              <p class="product-category">{{ tr.name }}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">
                {{ tr.adults }} Aduts {{ tr.kids }} kids
              </p>
            </vs-td>
            <vs-td>
              <p class="product-category">{{ tr.number_of_room }}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">
                {{ getDateFormat(tr.check_in, "DD/MM/YYYY h:mm a") }}
              </p>
            </vs-td>
            <vs-td>
              <p class="product-category">
                {{ getDateFormat(tr.check_out, "DD/MM/YYYY h:mm a") }}
              </p>
            </vs-td>
            <vs-td>
              <p class="product-category">&#8377; {{ tr.total }}</p>
            </vs-td>

            <vs-td>
              <vs-chip
                :color="getStatusColor(tr)"
                class="product-order-status"
                >{{ getStatus(tr) }}</vs-chip
              >
            </vs-td>

            <vs-td class="whitespace-no-wrap">
              <feather-icon
                icon="EyeIcon"
                class="ml-2"
                svgClasses="w-5 h-5 hover:text-primary stroke-current"
                @click.stop="ViewData(tr)"
              />
              <feather-icon
                icon="EditIcon"
                svgClasses="w-5 h-5 hover:text-primary stroke-current"
                @click.stop="editData(tr)"
              />
              <feather-icon
                icon="TrashIcon"
                svgClasses="w-5 h-5 hover:text-danger stroke-current"
                class="ml-2"
                @click.stop="deleteData(tr.id)"
              />

              <vs-dropdown
                vs-trigger-click
                class="dd-actions cursor-pointer mr-4 mb-4"
              >
                <feather-icon
                  icon="ChevronDownIcon"
                  svgClasses="w-5 h-5 hover:text-danger stroke-current"
                />

                <vs-dropdown-menu>
                  <vs-dropdown-item
                    @click="check_in(tr.id)"
                    v-if="!tr.checked_in && !tr.checked_out"
                  >
                    <span class="flex items-center">
                      <span>Check in</span>
                    </span>
                  </vs-dropdown-item>
                  <vs-dropdown-item
                    @click="check_out(tr.id)"
                    v-if="!tr.checked_out && tr.checked_in"
                  >
                    <span class="flex items-center">
                      <span>Check out</span>
                    </span>
                  </vs-dropdown-item>
                  <vs-dropdown-item @click="generateInvoice(tr.id)">
                    <span class="flex items-center">
                      <span v-if="tr.invoice">View Invoice</span>
                      <span v-else>Generate Invoice</span>
                    </span>
                  </vs-dropdown-item>
                  <vs-dropdown-item @click="generatePaidServiceBill(tr.id)">
                    <span class="flex items-center">
                      <span>Paid Services Bill</span>
                    </span>
                  </vs-dropdown-item>
                  <vs-dropdown-item @click="paidService(tr.id)">
                    <span class="flex items-center">
                      <span>Paid Service</span>
                    </span>
                  </vs-dropdown-item>
                </vs-dropdown-menu>
              </vs-dropdown>
            </vs-td>
          </vs-tr>
        </tbody>
      </template>
    </vs-table>

    <!-- view booking -->
    <div class="demo-alignment">
      <vs-popup
        classContent="popup-example"
        title="View Checkin"
        :active.sync="isViewPopup"
      >
        <ViewBooking title="Checkin" :data="form"></ViewBooking>
      </vs-popup>
    </div>
    <!-- end view booking -->

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

    <!-- end add new -->

    <!-- update -->
    <div class="demo-alignment">
      <vs-popup
        classContent="popup-example"
        title="Edit Checkin"
        :active.sync="isUpdatePopup"
      >
        <EditBooking title="Checkin" :data="form"></EditBooking>
      </vs-popup>
    </div>

    <!-- end update -->

    <!-- add paid service -->
    <div class="demo-alignment">
      <vs-popup
        classContent="popup-example"
        title="Paid Service"
        :active.sync="isPaidServicePopup"
      >
        <PaidService title="Checkin" :id="form.id"></PaidService>
      </vs-popup>
    </div>
  </div>
</template>

<script>
import CreateBooking from "./sub-components/CreateBooking";
import EditBooking from "./sub-components/EditBooking";
import ViewBooking from "./sub-components/ViewBooking";
import PaidService from "./sub-components/PaidService";

import { mapGetters } from "vuex";

export default {
  components: {
    CreateBooking,
    EditBooking,
    PaidService,
    ViewBooking,
  },
  data() {
    return {
      form: new Form({
        adults: "",
        kids: "",
        check_in: "",
        check_out: "",
        total: 0,
        discount: 0,
        advance: 0,
        balance: 0,
        rooms: [],
        payments: [],
        name: "",
        phone: "",
        email: "",
        company_name: "",
        gst_no: "",
        address: "",
        checked_in: 1,
        checked_out: "",
        status: true,
        id: "",
        uid: "",
        invoice: "",
        nights: "",
        oyo_id: "",
      }),
      backgroundLoading: "primary",
      colorLoading: "#fff",
      selected: [],

      disabledDates: {
        daysOfMonth: [8, 11, 17],
      },

      itemsPerPage: 4,
      isMounted: false,

      // Data Sidebar
      addNewDataSidebar: false,
      sidebarData: {},
      value1: "",
      value2: "",
      isAddNewPopup: false,
      isUpdatePopup: false,
      isViewPopup: false,
      isPaidServicePopup: false,

      configdateTimePicker: {
        enableTime: true,
        dateFormat: "d-m-Y H:i",
      },
      id: "",
    };
  },
  computed: {
    currentPage() {
      if (this.isMounted) {
        return this.$refs.table.currentx;
      }
      return 0;
    },
    products() {
      return this.$store.getters.getAllReservations;
    },
    availableRoomTypes() {
      return this.$store.getters.getAllAvailableRoomTypes;
    },
    queriedItems() {
      return this.$refs.table
        ? this.$refs.table.queriedResults.length
        : this.products.length;
    },
  },
  methods: {
    check_in(id) {
      this.$store.dispatch("CHECK_IN", id).then((res) => {
        this.$store.dispatch("retrieveCheckIns");
        this.$vs.notify({
          color: "success",
          title: "Checked In",
          text: "Successfully checked in",
        });
      });
    },
    check_out(id) {
      this.$store.dispatch("CHECK_OUT", id).then((res) => {
        this.$store.dispatch("retrieveCheckIns");
        this.$vs.notify({
          color: "success",
          title: "Checked Out",
          text: "Successfully checked out",
        });
      });
    },
    generateInvoice(item_id) {
      this.$router.push({ name: "generate-invoice", params: { id: item_id } });
    },
    generatePaidServiceBill(item_id) {
      this.$router.push({
        name: "generate-paid-service-bill",
        params: { id: item_id },
      });
    },
    addNewData() {
      this.isAddNewPopup = true;
      // delete old data from store
      this.$store.dispatch("deleteAllSelectedRoom");
      this.$store.dispatch("deleteAllSelectedPayment");
    },

    deleteData(id) {
      // console.log(id);

      this.$vs.notify({
        title: "Are you sure you want to delete Checkin?",
        text: "Click here to Delete",
        color: "warning",

        click: () => {
          this.$store.dispatch("deleteReservation", id).then(() => {
            this.$store.dispatch("retrieveAvailableRoomsToday");
            this.$store.dispatch("retrieveCheckIns");
            this.$vs.notify({
              color: "danger",
              title: "Deleted",
              text: "The selected Checkin deleted successfully.",
            });
          });
        },
      });
    },
    ViewData(data) {
      for (let property in this.form.originalData) {
        this.form[property] = data[property];
      }

      // delete old data from store
      this.$store.dispatch("deleteAllSelectedRoom");
      this.$store.dispatch("deleteAllSelectedPayment");

      data.rooms.forEach((element) => {
        this.$store.dispatch("storeSelectedRoom", element);
      });
      data.payments.forEach((element) => {
        this.$store.dispatch("storeSelectedPayment", element);
      });

      // delete paid service
      this.$store.dispatch("deleteAllReservationPaidService");
      this.$store.dispatch("retrieveReservationPaidServices", data.id);

      this.isViewPopup = true;
    },
    editData(data) {
      for (let property in this.form.originalData) {
        this.form[property] = data[property];
      }

      this.form.check_in = "";
      this.form.check_out = "";
      // delete old data from store
      this.$store.dispatch("deleteAllSelectedRoom");
      this.$store.dispatch("deleteAllSelectedPayment");

      data.rooms.forEach((element) => {
        this.$store.dispatch("storeSelectedRoom", element);
      });

      data.payments.forEach((element) => {
        this.$store.dispatch("storeSelectedPayment", element);
      });

      this.$store.dispatch("deleteAvailableRooms");

      this.isUpdatePopup = true;
    },

    paidService(id) {
      this.form.id = id;
      this.$store.dispatch("retrieveReservationPaidServices", id);
      this.isPaidServicePopup = !this.isPaidServicePopup;
    },
    onUpdate() {
      this.form
        .submit("patch", `/api/reservations/${this.form.id}`)
        .then(() => {
          this.$store.dispatch("retrieveCheckIns");
          this.$vs.notify({
            color: "success",
            title: "Updated",
            text: "Reservation updated successfully.",
          });
        })
        .catch();
    },
    getStatusColor(data) {
      // if (status === "on_hold") return "warning";
      if (data.awaiting_check_out) return "warning";
      if (data.checked_in && !data.checked_out) return "success";
      if (data.checked_out && data.checked_in) return "danger";

      return "primary";
    },
    getStatus(data) {
      if (data.awaiting_check_out) return "AWAITING CHECKOUT";
      if (data.checked_in && !data.checked_out) return "CHECKED IN";
      if (data.checked_out && data.checked_in) return "CHECKED OUT";
      return "Active";
    },

    toggleDataSidebar(val = false) {
      this.addNewDataSidebar = val;
    },

    deleteSelected() {
      if (this.selected.length > 0) {
        this.selected.forEach((item) => {
          this.$store.dispatch("deleteReservation", item.id).then(
            this.$vs.notify({
              color: "danger",
              title: "Deleted",
              text: "The selected Checkin was deleted successfully.",
            })
          );
        });
        this.$store.dispatch("retrieveCheckIns");
      } else {
        this.$vs.notify({
          color: "warning",
          title: "Warning",
          text: "Please select Checkin to delete.",
        });
      }
    },
    getDateFormat(date, format) {
      return moment(date).format(format);
    },
  },
  created() {
    this.$store.dispatch("retrieveCheckIns");
  },
  mounted() {
    this.isMounted = true;
  },
};
</script>

<style lang="scss">
#data-list-list-view {
  .vs-con-table {
    /*
      Below media-queries is fix for responsiveness of action buttons
      Note: If you change action buttons or layout of this page, Please remove below style
    */
    @media (max-width: 689px) {
      .vs-table--search {
        margin-left: 0;
        max-width: unset;
        width: 100%;

        .vs-table--search-input {
          width: 100%;
        }
      }
    }

    @media (max-width: 461px) {
      .items-per-page-handler {
        display: none;
      }
    }

    @media (max-width: 341px) {
      .data-list-btn-container {
        width: 100%;

        .dd-actions,
        .btn-add-new {
          width: 100%;
          margin-right: 0 !important;
        }
      }
    }

    .product-name {
      max-width: 23rem;
    }

    .vs-table--header {
      display: flex;
      flex-wrap: wrap;
      margin-left: 1.5rem;
      margin-right: 1.5rem;
      > span {
        display: flex;
        flex-grow: 1;
      }

      .vs-table--search {
        padding-top: 0;

        .vs-table--search-input {
          padding: 0.9rem 2.5rem;
          font-size: 1rem;

          & + i {
            left: 1rem;
          }

          &:focus + i {
            left: 1rem;
          }
        }
      }
    }

    .vs-table {
      border-collapse: separate;
      border-spacing: 0 1.3rem;
      padding: 0 1rem;

      tr {
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.05);
        td {
          padding: 20px;
          &:first-child {
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
          }
          &:last-child {
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
          }
        }
        td.td-check {
          padding: 20px !important;
        }
      }
    }

    .vs-table--thead {
      th {
        padding-top: 0;
        padding-bottom: 0;

        .vs-table-text {
          text-transform: uppercase;
          font-weight: 600;
        }
      }
      th.td-check {
        padding: 0 15px !important;
      }
      tr {
        background: none;
        box-shadow: none;
      }
    }

    .vs-table--pagination {
      justify-content: center;
    }
  }
}

.fill-row-loading {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  .loading-example {
    width: 120px;
    float: left;
    height: 120px;
    box-shadow: 0px 5px 20px 0px rgba(0, 0, 0, 0.05);
    border-radius: 10px;
    margin: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
    &:hover {
      box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.05);
      transform: translate(0, 4px);
    }
    h4 {
      z-index: 40000;
      position: relative;
      text-align: center;
      padding: 10px;
    }
    &.activeLoading {
      opacity: 0 !important;
      transform: scale(0.5);
    }
  }
}

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
