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
          <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
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
        <vs-th sort-key="title">Title</vs-th>
        <vs-th sort-key="short_code">Short Code</vs-th>
        <vs-th sort-key="description">Description</vs-th>
        <vs-th sort-key="base_price">Base Price</vs-th>
        <vs-th sort-key="base_price">AC Price</vs-th>
        <vs-th sort-key="base_price">Oyo Price</vs-th>
        <vs-th sort-key="base_price">Other Price</vs-th>
        <vs-th sort-key="status">Status</vs-th>
        <vs-th>Action</vs-th>
      </template>

      <template slot-scope="{ data }">
        <tbody>
          <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
            <vs-td>
              <p class="product-name font-medium truncate">{{ tr.title }}</p>
            </vs-td>

            <vs-td>
              <p class="product-category">{{ tr.short_code }}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">{{ tr.description }}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">&#8377; {{ tr.base_price }}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">&#8377; {{ tr.ac_price }}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">&#8377; {{ tr.oyo_price }}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">&#8377; {{ tr.other_price }}</p>
            </vs-td>
            <vs-td>
              <p class="product-category">
                1000 to 2499 - {{ tr.tax_1 }} %
                <br />
                2500 - {{ tr.tax_2 }} %
              </p>
            </vs-td>

            <vs-td>
              <vs-chip
                :color="getStatusColor(tr.status)"
                class="product-order-status"
                >{{ getStatus(tr.status) }}</vs-chip
              >
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
        title="Create Room Type"
        :active.sync="isAddNewPopup"
      >
        <!-- ERRORS -->
        <display-error :form="form"></display-error>
        <!-- End ERRORS -->

        <form @keydown="form.errors.clear()">
          <div class="p-4">
            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input
                  class="w-full"
                  label-placeholder="Title"
                  v-model="form.title"
                />
              </div>
            </div>
            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Short code"
                  v-model="form.short_code"
                />
              </div>
            </div>
            <div class="vx-row mb-4">
              <div class="vx-col w-1/4">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Base Price"
                  v-model="form.base_price"
                />
              </div>
              <div class="vx-col w-1/4">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="AC Price"
                  v-model="form.ac_price"
                />
              </div>
              <div class="vx-col w-1/4">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Oyo Price"
                  v-model="form.oyo_price"
                />
              </div>
              <div class="vx-col w-1/4">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Other Price"
                  v-model="form.other_price"
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
            <div class="vx-row mb-4">
              <div class="vx-col w-1/2">
                <vs-input
                  class="w-full"
                  label-placeholder="Tax 1 - 999 to 2499"
                  v-model="form.tax_1"
                />
              </div>
              <div class="vx-col w-1/2">
                <vs-input
                  class="w-full"
                  label-placeholder="Tax 2 - greater than 2499"
                  v-model="form.tax_2"
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
                  >Submit</vs-button
                >
                <vs-button
                  color="warning"
                  type="border"
                  class="mb-4"
                  @click="
                    form.title = form.short_code = form.description = form.base_price =
                      '';
                    form.status = 1;
                  "
                  >Reset</vs-button
                >
              </div>
            </div>
          </div>
        </form>
      </vs-popup>
    </div>

    <!-- end add new -->

    <!-- update -->
    <div class="demo-alignment">
      <vs-popup
        classContent="popup-example"
        title="Edit Room Type"
        :active.sync="isUpdatePopup"
      >
        <!-- ERRORS -->
        <display-error :form="form"></display-error>
        <!-- End ERRORS -->

        <form @keydown="form.errors.clear()">
          <div class="p-4">
            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input
                  class="w-full"
                  label-placeholder="Title"
                  v-model="form.title"
                />
              </div>
            </div>
            <div class="vx-row mb-4">
              <div class="vx-col w-full">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Short Code"
                  v-model="form.short_code"
                />
              </div>
            </div>
            <div class="vx-row mb-4">
              <div class="vx-col w-1/4">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Base Price"
                  v-model="form.base_price"
                />
              </div>
              <div class="vx-col w-1/4">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="AC Price"
                  v-model="form.ac_price"
                />
              </div>
              <div class="vx-col w-1/4">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Oyo Price"
                  v-model="form.oyo_price"
                />
              </div>
              <div class="vx-col w-1/4">
                <vs-input
                  type="text"
                  class="w-full"
                  label-placeholder="Other Price"
                  v-model="form.other_price"
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
            <div class="vx-row mb-4">
              <div class="vx-col w-1/2">
                <vs-input
                  class="w-full"
                  label-placeholder="Tax 1 - 999 to 2499"
                  v-model="form.tax_1"
                />
              </div>
              <div class="vx-col w-1/2">
                <vs-input
                  class="w-full"
                  label-placeholder="Tax 2 - greater than 2499"
                  v-model="form.tax_2"
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
                  >Update</vs-button
                >
                <vs-button
                  color="warning"
                  type="border"
                  class="mb-4"
                  @click="
                    form.title = form.short_code = form.description = form.base_price = form.ac_price = form.oyo_price = form.other_price =
                      '';
                    form.status = 1;
                    form.tax = 0;
                  "
                  >Reset</vs-button
                >
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
  // components: {
  //   DataViewSidebar
  // },
  data() {
    return {
      selected: [],
      // products: [],
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
        short_code: "",
        description: "",
        base_price: "",
        ac_price: "",
        oyo_price: "",
        other_price: "",
        tax_1: 0,
        tax_2: 0,
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
      return this.$store.getters.getAllRoomTypes;
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
        .submit("post", "/api/room_types")
        .then(() => {
          this.$store.dispatch("retrieveRoomTypes");
          this.$vs.notify({
            color: "success",
            title: "Created",
            text: "The Room Type created successfully.",
          });
        })
        .catch();
    },
    deleteData(id) {
      // console.log(id);
      this.$vs.notify({
        color: "warning",
        title: "Can't be deleted",
        text: "Feature has been disabled for security reason.",
      });
      // this.$store.dispatch("deleteRoomType", id).then(
      //   this.$vs.notify({
      //     color: "danger",
      //     title: "Deleted",
      //     text: "The selected room type deleted successfully.",
      //   })
      // );

      this.$store.dispatch("retrieveRoomTypes");
    },
    editData(data) {
      for (let property in this.form.originalData) {
        this.form[property] = data[property];
      }

      this.isUpdatePopup = true;
    },
    onUpdate() {
      this.form
        .submit("patch", `/api/room_types/${this.form.id}`)
        .then(() => {
          this.$store.dispatch("retrieveRoomTypes");
          this.$vs.notify({
            color: "success",
            title: "Updated",
            text: "The Room type updated successfully.",
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
          this.$store.dispatch("deleteRoomType", item.id).then(
            this.$vs.notify({
              color: "danger",
              title: "Deleted",
              text: "The selected room type was deleted successfully.",
            })
          );
        });
        this.$store.dispatch("retrieveRoomTypes");
      } else {
        this.$vs.notify({
          color: "warning",
          title: "Warning",
          text: "Please select floors to delete.",
        });
      }
    },
  },
  created() {
    this.$store.dispatch("retrieveRoomTypes");
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
