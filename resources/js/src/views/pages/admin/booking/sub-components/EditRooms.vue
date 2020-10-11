<template>
  <vs-table ref="table" search :data="products">
    <template slot="thead">
      <vs-th sort-key="title">Number</vs-th>
      <vs-th sort-key="description">Type</vs-th>
      <vs-th sort-key="base_price">Floor</vs-th>
      <vs-th sort-key="base_price">Price</vs-th>

      <vs-th v-if="!view">Action</vs-th>
    </template>

    <template slot-scope="{data}">
      <tbody>
        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
          <vs-td>
            <p class="product-category">{{ tr.number}}</p>
          </vs-td>
          <vs-td>
            <p class="product-category">{{ tr.type}}</p>
          </vs-td>
          <vs-td>
            <p class="product-category">{{ tr.floor}}</p>
          </vs-td>
          <vs-td>
            <p
              class="product-category"
              @dblclick.stop="showEdit(tr)"
              v-show="!tr.editing"
            >{{ tr.price}}</p>
            <vs-input
              class="product-category"
              v-show="tr.editing"
              @blur="editData(tr)"
              @keydown.enter="editData(tr)"
              v-model="price"
            ></vs-input>
          </vs-td>

          <vs-td class="whitespace-no-wrap" v-if="!view">
            <feather-icon
              icon="EditIcon"
              v-if="!isOnline"
              svgClasses="w-5 h-5 hover:text-primary stroke-current"
              @click.stop="showEdit(tr)"
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
</template>


<script>
import { mapGetters } from "vuex";
export default {
  props: ["title", "view", "isOnline"],
  data() {
    return {
      isMounted: false,
      isEdit: false,
      price: 0,
    };
  },
  computed: {
    currentPage() {
      if (this.isMounted) {
        return this.$refs.table.currentx;
      }
      return 0;
    },
    queriedItems() {
      return this.$refs.table
        ? this.$refs.table.queriedResults.length
        : this.products.length;
    },
    ...mapGetters({ products: "getSelectedRooms" }),
  },

  mounted() {
    this.isMounted = true;
  },
  methods: {
    addNewData() {
      this.isAddNewPopup = true;
    },

    async deleteData(id) {
      await this.$store.dispatch("deleteBookedRoom", id).then((res) => {
        this.$store.dispatch("deleteSelectedRoom", id);
        if (this.title === "Reservation") {
          this.$store.dispatch("retrieveReservations").then((res) => {
            if (this.products.length < 1) {
              this.$vs.notify({
                color: "warning",
                title: "Warning",
                text: `Please select atleast one room`,
              });
            }
          });
        } else {
          this.$store.dispatch("retrieveCheckIns").then((res) => {
            if (this.products.length < 1) {
              this.$vs.notify({
                color: "warning",
                title: "Warning",
                text: `Please select atleast one room`,
              });
            }
          });
        }
      });
    },
    showEdit(tr) {
      this.price = tr.price;
      this.$store.dispatch("toggleSelectedRoomEditing", tr.id);
    },
    editData(data) {
      this.$store.dispatch("toggleSelectedRoomEditing", data.id);
      let room = {
        id: data.id,
        price: this.price,
      };
      this.$store.dispatch("editSelectedRoom", room);
    },
    onUpdate() {
      this.form
        .submit("patch", `/api/reservations/${this.form.id}`)
        .then(() => {
          this.$store.dispatch("retrieveReservations");
          this.$vs.notify({
            color: "success",
            title: "Updated",
            text: "Reservation updated successfully.",
          });
        })
        .catch();
    },
    toggleDataSidebar(val = false) {
      this.addNewDataSidebar = val;
    },

    getDateFormat(date, format) {
      return moment(date).format(format);
    },
    getAvailableRooms() {
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
    },
    showError() {
      if (!this.selectedRooms.length) {
        this.$vs.notify({
          color: "warning",
          title: "Warning",
          text: "Please select Atleast one room.",
        });
      }
    },
  },
};
</script>