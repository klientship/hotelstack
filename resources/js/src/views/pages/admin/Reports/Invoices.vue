

<template>
  <div id="ag-grid-demo">
    <vx-card>
      <!-- TABLE ACTION ROW -->
      <div class="flex flex-wrap justify-between items-center">
        <!-- ITEMS PER PAGE -->
        <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
          <vs-dropdown vs-trigger-click class="dd-actions cursor-pointer mr-4 mb-4">
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
                  <span :class="[filter == 'this_month' ? 'text-primary': '']">This Month</span>
                </span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="lastMonth">
                <span class="flex items-center">
                  <span :class="[filter == 'last_month' ? 'text-primary': '']">Last Month</span>
                </span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="all">
                <span class="flex items-center">
                  <span :class="[filter == 'all' ? 'text-primary': '']">All</span>
                </span>
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>

          <vs-dropdown vs-trigger-click class="cursor-pointer">
            <div
              class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
            >
              <span
                class="mr-2"
              >{{ currentPage * paginationPageSize - (paginationPageSize - 1) }} - {{ invoices.length - currentPage * paginationPageSize > 0 ? currentPage * paginationPageSize : invoices.length }} of {{ invoices.length }}</span>
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
        <div class="flex flex-wrap items-center justify-between ag-grid-table-actions-right">
          <vs-input
            class="mb-4 md:mb-0 mr-4"
            v-model="searchQuery"
            @input="updateSearchQuery"
            placeholder="Search..."
          />
          <vs-button class="mb-4 md:mb-0" @click="gridApi.exportDataAsCsv()">Export as CSV</vs-button>
        </div>
      </div>
      <ag-grid-vue
        ref="agGridTable"
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :rowData="invoices"
        rowSelection="multiple"
        colResizeDefault="shift"
        :animateRows="true"
        :floatingFilter="true"
        :pagination="true"
        :paginationPageSize="paginationPageSize"
        :suppressPaginationPanel="true"
        :enableRtl="$vs.rtl"
      ></ag-grid-vue>
      <vs-pagination :total="totalPages" :max="maxPageNumbers" v-model="currentPage" />
    </vx-card>
  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";

import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import { mapGetters } from "vuex";

export default {
  components: {
    AgGridVue,
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
          headerName: "Invoice No",
          field: "no",
          width: 175,
          filter: true,
          pinned: "left",
          // checkboxSelection: true,
          // headerCheckboxSelectionFilteredOnly: true,
          // headerCheckboxSelection: true,
        },
        {
          headerName: "Booking ID",
          field: "uid",
          filter: true,
          width: 175,
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
          headerName: "Subtotal",
          field: "sub_total",
          filter: true,
          width: 175,
        },
        {
          headerName: "Tax",
          field: "tax",
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
    ...mapGetters({ invoices: "getAllInvoices" }),

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
      this.$store.dispatch("RETRIEVE_THIS_MONTH_INVOICES");
      this.filter = "this_month";
    },
    lastMonth() {
      this.$store.dispatch("RETRIEVE_LAST_MONTH_INVOICES");
      this.filter = "last_month";
    },
    all() {
      this.$store.dispatch("RETRIEVE_ALL_INVOICES");
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
    this.$store.dispatch("RETRIEVE_THIS_MONTH_INVOICES");
  },
};
</script>
