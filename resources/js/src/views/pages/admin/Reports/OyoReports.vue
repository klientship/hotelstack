

<template>
  <div>
    <OyoReportCard :data="oyo_card_details"></OyoReportCard>
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
                <vs-dropdown-item @click="presentCheckins">
                  <span class="flex items-center">
                    <span
                      :class="[
                        filter == 'present_checkins' ? 'text-primary' : '',
                      ]"
                      >Present Checkins</span
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
                    reports.length - currentPage * paginationPageSize > 0
                      ? currentPage * paginationPageSize
                      : reports.length
                  }}
                  of {{ reports.length }}</span
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
          :rowData="reports"
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
import OyoReportCard from "./OyoReportCard";

export default {
  components: {
    AgGridVue,
    StatisticsCardLine,
    OyoReportCard,
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
          headerName: "Booking ID",
          field: "uid",
          filter: true,
          width: 175,
          pinned: "left",
        },
        {
          headerName: "OYO ID",
          field: "oyo_id",
          filter: true,
          width: 175,
          pinned: "left",
        },
        {
          headerName: "Name",
          field: "name",
          filter: true,
          width: 175,
        },
        {
          headerName: "Date",
          field: "created_at",
          filter: true,
          width: 175,
        },
        {
          headerName: "Check in",
          field: "check_in",
          filter: true,
          width: 250,
        },
        {
          headerName: "Check out",
          field: "check_out",
          filter: true,
          width: 250,
        },
        {
          headerName: "Adults",
          field: "adults",
          filter: true,
          width: 175,
        },
        {
          headerName: "Kids",
          field: "kids",
          filter: true,
          width: 175,
        },
        {
          headerName: "Nights",
          field: "nights",
          filter: true,
          width: 175,
        },
        {
          headerName: "No of Rooms",
          field: "number_of_room",
          filter: true,
          width: 175,
        },
        {
          headerName: "Total",
          field: "total",
          filter: true,
          width: 175,
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
    ...mapGetters({ reports: "getOyoReports" }),

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

    ...mapGetters({ dashboardDetails: "getDashboardDetails" }),
    ...mapGetters({ oyo_card_details: "getOyoCardDetails" }),
  },
  methods: {
    thisMonth() {
      this.$store.dispatch("RETRIEVE_THIS_MONTH_OYO_REPORTS");
      this.filter = "this_month";
    },
    lastMonth() {
      this.$store.dispatch("RETRIEVE_LAST_MONTH_OYO_REPORTS");
      this.filter = "last_month";
    },
    all() {
      this.$store.dispatch("RETRIEVE_ALL_OYO_REPORTS");
      this.filter = "all";
    },
    presentCheckins() {
      this.$store.dispatch("RETRIEVE_PRESENT_CHECKED_IN_OYO_REPORTS");
      this.filter = "present_checkins";
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

    this.$store.dispatch("RETRIEVE_DASHBOARD_DETAILS");
  },
  created() {
    this.$store.dispatch("RETRIEVE_ALL_OYO_REPORTS");
    this.$store.dispatch("RETRIEVE_OYO_CARD_DETAILS");
  },
};
</script>
