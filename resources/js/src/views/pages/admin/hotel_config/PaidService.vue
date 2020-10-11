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
      <div slot="header" class="flex flex-wrap-reverse items-center flex-grow justify-between">
        <div class="flex flex-wrap-reverse items-center data-list-btn-container">
          <!-- ACTION - DROPDOWN -->
          <vs-dropdown vs-trigger-click class="dd-actions cursor-pointer mr-4 mb-4">
            <div
              class="p-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer flex items-center justify-center text-lg font-medium w-full"
            >
              <span class="mr-2">Actions</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>

            <vs-dropdown-menu>
              <vs-dropdown-item @click="deleteSelected">
                <span class="flex items-center">
                  <feather-icon icon="TrashIcon" svgClasses="h-4 w-4" class="mr-2" />
                  <span>Delete</span>
                </span>
              </vs-dropdown-item>

              <!-- <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon icon="FileIcon" svgClasses="h-4 w-4" class="mr-2" />
                  <span>Print</span>
                </span>
              </vs-dropdown-item>-->
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
        <vs-dropdown vs-trigger-click class="cursor-pointer mb-4 mr-4 items-per-page-handler">
          <div
            class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
          >
            <span
              class="mr-2"
            >{{ currentPage * itemsPerPage - (itemsPerPage - 1) }} - {{ products.length - currentPage * itemsPerPage > 0 ? currentPage * itemsPerPage : products.length }} of {{ queriedItems }}</span>
            <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
          </div>
          <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
          <vs-dropdown-menu>
            <vs-dropdown-item @click="itemsPerPage=4">
              <span>4</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=10">
              <span>10</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=15">
              <span>15</span>
            </vs-dropdown-item>
            <vs-dropdown-item @click="itemsPerPage=20">
              <span>20</span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <template slot="thead">
        <vs-th sort-key="title">Title</vs-th>
        <vs-th sort-key="description">Description</vs-th>
        <vs-th sort-key="base_price">Price</vs-th>
        <vs-th sort-key="status">Status</vs-th>
        <vs-th>Action</vs-th>
      </template>

      <template slot-scope="{data}">
        <tbody>
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td>
              <p class="product-name font-medium truncate">{{ tr.title }}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">{{ tr.description}}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">{{ tr.price}}</p>
            </vs-td>

            <vs-td>
              <vs-chip
                :color="getStatusColor(tr.status)"
                class="product-order-status"
              >{{ getStatus(tr.status) }}</vs-chip>
            </vs-td>

            <vs-td class="whitespace-no-wrap">
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
            </vs-td>
          </vs-tr>
        </tbody>
      </template>
    </vs-table>

    <!-- add new -->
    <div class="demo-alignment">
      <vs-popup
        classContent="popup-example"
        title="Create Paid Service"
        :active.sync="isAddNewPopup"
      >
        <!-- ERRORS -->
        <display-error :form="form"></display-error>
        <!-- End ERRORS -->

        <form @keydown="form.errors.clear()">
          <div class="p-4">
            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input class="w-full" label-placeholder="Title" v-model="form.title" />
              </div>
            </div>

            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Price"
                  v-model="form.price"
                />
              </div>
            </div>
            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input
                  class="w-full"
                  label-placeholder="Description"
                  v-model="form.description"
                />
              </div>
            </div>

            <div class="vx-row mt-4">
              <div class="vx-col w-full">
                <ul class="switch-container">
                  <li>
                    <label>Status</label>
                    <vs-switch v-model="form.status" class="mb-4 mt-1" />
                  </li>
                </ul>
              </div>
            </div>

            <div class="vx-row">
              <div class="vx-col w-full">
                <vs-button
                  class="mr-3 mb-4"
                  @click.prevent="onSubmit"
                  :disabled="form.errors.any()"
                >Submit</vs-button>
                <vs-button
                  color="warning"
                  type="border"
                  class="mb-4"
                  @click="form.title  = form.description = form.price =  ''; form.status= 1;"
                >Reset</vs-button>
              </div>
            </div>
          </div>
        </form>
      </vs-popup>
    </div>

    <!-- end add new -->

    <!-- update -->
    <div class="demo-alignment">
      <vs-popup classContent="popup-example" title="Edit Paid Service" :active.sync="isUpdatePopup">
        <!-- ERRORS -->
        <display-error :form="form"></display-error>
        <!-- End ERRORS -->

        <vs-alert
          color="danger"
          class="mt-4"
          :active.sync="form.errors.has('status')"
        >{{form.errors.get('status')}}</vs-alert>

        <form @keydown="form.errors.clear()">
          <div class="p-4">
            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input class="w-full" label-placeholder="Title" v-model="form.title" />
              </div>
            </div>

            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Price"
                  v-model="form.price"
                />
              </div>
            </div>
            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input
                  class="w-full"
                  label-placeholder="Description"
                  v-model="form.description"
                />
              </div>
            </div>

            <div class="vx-row mt-4">
              <div class="vx-col w-full">
                <ul class="switch-container">
                  <li>
                    <label>Status</label>
                    <vs-switch v-model="form.status" class="mb-4 mt-1" />
                  </li>
                </ul>
              </div>
            </div>

            <div class="vx-row">
              <div class="vx-col w-full">
                <vs-button
                  class="mr-3 mb-4"
                  @click.prevent="onUpdate"
                  :disabled="form.errors.any()"
                >Update</vs-button>
                <vs-button
                  color="warning"
                  type="border"
                  class="mb-4"
                  @click="form.title = form.short_code = form.description = form.price =  ''; form.status= 1;"
                >Reset</vs-button>
              </div>
            </div>
          </div>
        </form>
      </vs-popup>
    </div>

    <!-- end update -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      selected: [],

      itemsPerPage: 4,
      isMounted: false,

      // Data Sidebar
      addNewDataSidebar: false,
      sidebarData: {},
      value1: "",
      value2: "",
      isAddNewPopup: false,
      isUpdatePopup: false,
      form: new Form({
        id: "",
        title: "",
        price: "",
        description: "",
        status: true,
      }),
      // products: []
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
      return this.$store.getters.getAllPaidServices;
    },
    queriedItems() {
      return this.$refs.table
        ? this.$refs.table.queriedResults.length
        : this.products.length;
    },
  },
  methods: {
    addNewData() {
      this.form.reset();
      this.isAddNewPopup = true;
    },

    onSubmit() {
      this.form
        .submit("post", "/api/paid_services")
        .then(() => {
          this.$store.dispatch("retrievePaidServices");
          this.$vs.notify({
            color: "success",
            title: "Created",
            text: "Paid Service created successfully.",
          });
        })
        .catch();
    },
    deleteData(id) {
      // console.log(id);
      this.$store.dispatch("deletePaidService", id).then(
        this.$vs.notify({
          color: "danger",
          title: "Deleted",
          text: "The selected Paid Service deleted successfully.",
        })
      );

      this.$store.dispatch("retrievePaidServices");
    },
    editData(data) {
      this.form.id = data.id;
      this.form.title = data.title;
      this.form.price = data.price;
      this.form.description = data.description;
      this.form.status = data.status;

      this.isUpdatePopup = true;
    },
    onUpdate() {
      this.form
        .submit("patch", `/api/paid_services/${this.form.id}`)
        .then(() => {
          this.$store.dispatch("retrievePaidServices");
          this.$vs.notify({
            color: "success",
            title: "Updated",
            text: "Paid Service updated successfully.",
          });
        })
        .catch();
    },
    getStatusColor(status) {
      // if (status === "on_hold") return "warning";
      if (status === 1) return "success";
      if (status === 0) return "danger";
      return "primary";
    },
    getStatus(status) {
      if (status === 0) return "Inactive";
      return "Active";
    },
    getPopularityColor(num) {
      if (num > 90) return "success";
      if (num > 70) return "primary";
      if (num >= 50) return "warning";
      if (num < 50) return "danger";
      return "primary";
    },
    toggleDataSidebar(val = false) {
      this.addNewDataSidebar = val;
    },

    deleteSelected() {
      if (this.selected.length > 0) {
        this.selected.forEach((item) => {
          this.$store.dispatch("deletePaidService", item.id).then(
            this.$vs.notify({
              color: "danger",
              title: "Deleted",
              text: "The selected Paid Service was deleted successfully.",
            })
          );
        });
        this.$store.dispatch("retrievePaidServices");
      } else {
        this.$vs.notify({
          color: "warning",
          title: "Warning",
          text: "Please select Paid service to delete.",
        });
      }
    },
  },
  created() {
    this.$store.dispatch("retrievePaidServices");
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
</style>
