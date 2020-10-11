<template>
  <vs-table ref="table" search :data="products">
    <template slot="thead">
      <vs-th sort-key="title">#</vs-th>

      <vs-th sort-key="base_price">Amount</vs-th>
      <vs-th sort-key="base_price">Type</vs-th>
      <vs-th sort-key="base_price">Date</vs-th>
      <vs-th>Action</vs-th>
    </template>

    <template slot-scope="{data}">
      <tbody>
        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
          <vs-td>
            <p class="product-category">{{ indextr+1 }}</p>
          </vs-td>
          <vs-td>
            <p class="product-category">&#8377; {{ tr.amount}}</p>
          </vs-td>
          <vs-td>
            <p class="product-category">{{ tr.type}}</p>
          </vs-td>
          <vs-td>
            <p class="product-category">{{ getDateFormat(tr.created_at, "DD/MM/YYYY h:mm a") }}</p>
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

          <vs-td class="whitespace-no-wrap">
            <!-- <feather-icon
              icon="EditIcon"
              svgClasses="w-5 h-5 hover:text-primary stroke-current"
              @click.stop="showEdit(tr)"
            />-->
            <feather-icon
              icon="TrashIcon"
              svgClasses="w-5 h-5 hover:text-danger stroke-current"
              class="ml-2"
              @click.stop="deleteData(tr)"
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
  data() {
    return {
      isMounted: false,
      isEdit: false,
      price: 0,
    };
  },
  props: ["title"],
  computed: {
    ...mapGetters({ products: "getSelectedPayments" }),
  },
  mounted() {
    this.isMounted = true;
  },
  methods: {
    getDateFormat(date, format) {
      return moment(date).format(format);
    },
    deleteData(tr) {
      this.$store
        .dispatch("deleteSelectedPayment", tr.id)
        .then(() => {
          this.$store.dispatch(
            "retrieveAllReservationPayments",
            tr.reservation_id
          );
          if (this.title === "Reservation") {
            this.$store.dispatch("retrieveReservations");
          } else {
            this.$store.dispatch("retrieveCheckIns");
          }
          this.$vs.notify({
            color: "success",
            title: "Deleted",
            text: "Payment deleted successfully.",
          });
        })
        .catch(() => {
          this.$vs.notify({
            color: "danger",
            title: "Unsuccessful",
            text: "Something went wrong",
          });
        });
    },
    showEdit(tr) {
      this.price = tr.price;
      this.$store.dispatch("toggleSelectedPaymentEditing", tr.id);
    },
    editData(data) {
      this.$store.dispatch("toggleSelectedPaymentEditing", data.id);
      let payment = {
        id: data.id,
        price: this.price,
      };
      this.$store.dispatch("editSelectedPayment", payment);
    },
    getDateFormat(date, format) {
      return moment(date).format(format);
    },
    getDateFormat(date, format) {
      return moment(date).format(format);
    },
  },
};
</script>

