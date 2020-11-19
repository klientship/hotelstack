

<template>
  <div>
    <!-- <div class="vx-row mt-4">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_payment"
          statisticTitle="Total Services"
          :chartData="dashboardDetails.payments.series"
          type="area"
          color="success"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_payment"
          statisticTitle="Monthly Services"
          :chartData="dashboardDetails.payments.series"
          type="area"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_payment"
          statisticTitle="Total Amount"
          :chartData="dashboardDetails.payments.series"
          type="area"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_payment"
          statisticTitle="Monthly Total"
          :chartData="dashboardDetails.payments.series"
          type="area"
        ></statistics-card-line>
      </div>
    </div> -->

    <div id="ag-grid-demo">
      <vx-card>
        <!-- TABLE ACTION ROW -->
        <div class="flex flex-wrap justify-between items-center">
          <!-- ITEMS PER PAGE -->
          <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
            <vs-dropdown
              vs-trigger-click
              class="dd-actions cursor-pointer mr-4 mb-4"
            >
              <div
                class="p-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer flex items-center justify-center text-lg font-medium w-full"
              >
                <span class="mr-2">Filter</span>
                <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
              </div>

              <vs-dropdown-menu>
                <vs-dropdown-item @click="thisMonth">
                  <span class="flex items-center">
                    <!-- <feather-icon icon="TrashIcon" svgClasses="h-4 w-4" class="mr-2" /> -->
                    <span
                      :class="[filter == 'this_month' ? 'text-primary' : '']"
                      >This Month</span
                    >
                  </span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="lastMonth">
                  <span class="flex items-center">
                    <span
                      :class="[filter == 'last_month' ? 'text-primary' : '']"
                      >Last Month</span
                    >
                  </span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="all">
                  <span class="flex items-center">
                    <span :class="[filter == 'all' ? 'text-primary' : '']"
                      >All</span
                    >
                  </span>
                </vs-dropdown-item>
              </vs-dropdown-menu>
            </vs-dropdown>

            <vs-dropdown vs-trigger-click class="cursor-pointer">
              <div
                class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
              >
                <span class="mr-2"
                  >{{
                    currentPage * paginationPageSize - (paginationPageSize - 1)
                  }}
                  -
                  {{
                    paid_services.length - currentPage * paginationPageSize > 0
                      ? currentPage * paginationPageSize
                      : paid_services.length
                  }}
                  of {{ paid_services.length }}</span
                >
                <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
              </div>

              <vs-dropdown-menu>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(20)">
                  <span>20</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(50)">
                  <span>50</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(100)">
                  <span>100</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(150)">
                  <span>150</span>
                </vs-dropdown-item>
              </vs-dropdown-menu>
            </vs-dropdown>
          </div>

          <!-- TABLE ACTION COL-2: SEARCH & EXPORT AS CSV -->
          <div
            class="flex flex-wrap items-center justify-between ag-grid-table-actions-right"
          >
            <vs-input
              class="mb-4 md:mb-0 mr-4"
              v-model="searchQuery"
              @input="updateSearchQuery"
              placeholder="Search..."
            />
            <vs-button class="mb-4 md:mb-0" @click="gridApi.exportDataAsCsv()"
              >Export as CSV</vs-button
            >
          </div>
        </div>
        <ag-grid-vue
          ref="agGridTable"
          :gridOptions="gridOptions"
          class="ag-theme-material w-100 my-4 ag-grid-table"
          :columnDefs="columnDefs"
          :defaultColDef="defaultColDef"
          :rowData="paid_services"
          rowSelection="multiple"
          colResizeDefault="shift"
          :animateRows="true"
          :floatingFilter="true"
          :pagination="true"
          :paginationPageSize="paginationPageSize"
          :suppressPaginationPanel="true"
          :enableRtl="$vs.rtl"
        ></ag-grid-vue>
        <vs-pagination
          :total="totalPages"
          :max="maxPageNumbers"
          v-model="currentPage"
        />
      </vx-card>
    </div>
  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";

import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import { mapGetters } from "vuex";

export default {
  components: {
    AgGridVue,
    StatisticsCardLine,
  },
  data() {
    return {
      filter: "this_month",
      isAddNewPopup: false,
      searchQuery: "",
      gridOptions: {},
      maxPageNumbers: 7,
      gridApi: null,
      defaultColDef: {
        sortable: true,
        // editable: true,
        resizable: true,
        suppressMenu: true,
      },
      columnDefs: [
        {
          headerName: "Description",
          field: "description",
          width: 375,
          filter: true,
          pinned: "left",
        },
        {
          headerName: "Price",
          field: "price",
          filter: true,
          width: 275,
        },
        {
          headerName: "Booking ID",
          field: "uid",
          filter: true,
          width: 275,
        },

        {
          headerName: "Date",
          field: "created_at",
          filter: true,
          width: 275,
        },
      ],
    };
  },

  watch: {
    "$store.state.windowWidth"(val) {
      if (val <= 576) {
        this.maxPageNumbers = 4;
        this.gridOptions.columnApi.setColumnPinned("email", null);
      } else this.gridOptions.columnApi.setColumnPinned("email", "left");
    },
  },
  computed: {
    ...mapGetters({ paid_services: "getAllReservationPaidServices" }),

    // test
    ...mapGetters({ roomTypes: "getRoomTypesWithRooms" }),
    ...mapGetters({ recent_checkins: "getRecentCheckins" }),
    ...mapGetters({ todays_checkins: "getTodaysCheckins" }),
    ...mapGetters({ todays_checkouts: "getTodaysCheckouts" }),
    ...mapGetters({ availableRooms: "getAvailableRoomsToday" }),
    ...mapGetters({ houseKeepings: "getHouseKeepings" }),
    ...mapGetters({ hotelDetails: "getHotelDetails" }),
    ...mapGetters({ dashboardDetails: "getDashboardDetails" }),

    paginationPageSize() {
      if (this.gridApi) return this.gridApi.paginationGetPageSize();
      else return 50;
    },
    totalPages() {
      if (this.gridApi) return this.gridApi.paginationGetTotalPages();
      else return 0;
    },
    currentPage: {
      get() {
        if (this.gridApi) return this.gridApi.paginationGetCurrentPage() + 1;
        else return 1;
      },
      set(val) {
        this.gridApi.paginationGoToPage(val - 1);
      },
    },
  },
  methods: {
    thisMonth() {
      this.$store.dispatch("RETRIEVE_THIS_MONTH_RESERVATION_PAID_SERVICES");
      this.filter = "this_month";
    },
    lastMonth() {
      this.$store.dispatch("RETRIEVE_LAST_MONTH_RESERVATION_PAID_SERVICES");
      this.filter = "last_month";
    },
    all() {
      this.$store.dispatch("RETRIEVE_ALL_RESERVATION_PAID_SERVICES");
      this.filter = "all";
    },
    updateSearchQuery(val) {
      this.gridApi.setQuickFilter(val);
    },
    addNewData() {
      this.isAddNewPopup = true;
    },
  },
  mounted() {
    this.gridApi = this.gridOptions.api;
    if (this.$vs.rtl) {
      const header = this.$refs.agGridTable.$el.querySelector(
        ".ag-header-container"
      );
      header.style.left = `-${String(
        Number(header.style.transform.slice(11, -3)) + 9
      )}px`;
    }
  },
  created() {
    this.$store.dispatch("RETRIEVE_THIS_MONTH_RESERVATION_PAID_SERVICES");
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
};
</script>
