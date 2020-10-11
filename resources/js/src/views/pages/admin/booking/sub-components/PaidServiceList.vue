<template>
  <vs-table ref="table" search :data="products">
    <template slot="thead">
      <vs-th sort-key="description">Description</vs-th>
      <vs-th sort-key="base_price">Price</vs-th>

      <vs-th>Action</vs-th>
    </template>

    <template slot-scope="{data}">
      <tbody>
        <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
          <vs-td>
            <p class="product-category">{{ tr.description}}</p>
          </vs-td>
          <vs-td>
            <p class="product-category">&#8377; {{ tr.price}}</p>
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
  computed: {
    ...mapGetters({ products: "getReservationPaidServices" }),
  },
  created() {
    this.$store.dispatch("retrieveReservationPaidServices", this.id);
  },
};
</script>