<template></template>a<template>
  <div>
    <!-- ERRORS -->
    <display-error :form="form"></display-error>
    <!-- end Errors -->

    <form @keydown="form.errors.clear()">
      <div class="p-4">
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <p>Product Name</p>
            <v-select
              label="label"
              :options="options"
              v-model="form.product_id"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
              :danger="form.errors.has('product_id')"
            />
            <span
              class="text-danger text-sm"
              v-show="form.errors.has('product_id')"
              >{{ form.errors.get("product_id") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <vs-input
              type="text"
              class="w-full"
              label-placeholder="Quantity"
              v-model="form.quantity"
              :danger="form.errors.has('quantity')"
            />
            <span
              class="text-danger text-sm"
              v-show="form.errors.has('quantity')"
              >{{ form.errors.get("quantity") }}</span
            >
          </div>
        </div>

        <div class="vx-row mb-4">
          <div class="vx-col w-1/2">
            <vs-button
              class="mr-3 mb-4"
              @click.prevent="onSubmit"
              :disabled="form.errors.any()"
              >Submit</vs-button
            >
            <vs-button color="warning" type="border" class="mb-4" @click="reset"
              >Reset</vs-button
            >
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import vSelect from "vue-select";
import { mapGetters } from "vuex";

export default {
  props: ["id"],
  data() {
    return {
      form: new Form({
        product_id: "",
        quantity: 0,
        reservation_id: "",
      }),
    };
  },
  components: {
    vSelect,
  },
  methods: {
    reset() {
      this.form.product_id = "";
      this.form.quantity = 0;
      this.form.reservation_id = "";
    },

    onSubmit() {
      this.form.reservation_id = this.id;

      this.form
        .submit("post", "/api/reservation_paid_services")
        .then(() => {
          this.$store.dispatch("retrieveReservationPaidServices", this.id);

          this.$vs.notify({
            color: "success",
            title: "Created",
            text: "Order created successfully.",
          });
        })
        .catch();
    },
  },
  computed: {
    ...mapGetters({ cold_drinks: "getAllColdDrinks" }),
    options() {
      let op = [];
      if (this.cold_drinks) {
        this.cold_drinks.forEach((cold_drink) => {
          op.push({
            label: cold_drink.product_name,
            value: cold_drink.id,
          });
        });
      }

      return op;
    },
  },
  created() {
    this.$store.dispatch("RETRIEVE_ALL_COLD_DRINKS");
  },
};
</script>