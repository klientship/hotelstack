<template>
  <vs-table ref="table" search :data="products">
    <template slot="thead">
      <vs-th sort-key="description">Product Name</vs-th>
      <vs-th sort-key="description">Quantity</vs-th>
      <vs-th sort-key="description">Price</vs-th>
      <vs-th sort-key="description">Total</vs-th>

      <vs-th>Action</vs-th>
    </template>

    <template slot-scope="{ data }">
      <tbody>
        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
          <vs-td>
            <p class="product-category">{{ tr.name }}</p>
          </vs-td>
          <vs-td>
            <p class="product-category">{{ tr.quantity }}</p>
          </vs-td>
          <vs-td>
            <p class="product-category">&#8377; {{ tr.price }}</p>
          </vs-td>
          <vs-td>
            <p class="product-category">&#8377; {{ tr.total }}</p>
          </vs-td>

          <vs-td class="whitespace-no-wrap">
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
  props: ["view", "id"],
  data() {
    return {};
  },
  methods: {
    deleteData(id) {
      this.$http.delete(`/api/reservation_cold_drinks/${id}`).then((res) => {
        this.$store.dispatch("RETRIEVE_RESERVATION_COLD_DRINKS", this.id);
      });
    },
  },
  computed: {
    ...mapGetters({ products: "getReservationColdDrinks" }),
  },
  created() {
    this.$store.dispatch("RETRIEVE_RESERVATION_COLD_DRINKS", this.id);
  },
};
</script>