<template>
  <form @keydown="form.errors.clear()">
    <div class="p-4">
      <!-- ERRORS -->
      <!-- <display-error :form="form"></display-error> -->
      <!-- End ERRORS -->
      <div class="vx-row mb-4">
        <div class="vx-col w-full">
          <vs-input
            class="w-full"
            label-placeholder="Product Name"
            v-model="form.product_name"
            :danger="form.errors.has('product_name')"
          />
          <span
            class="text-danger text-sm"
            v-show="form.errors.has('product_name')"
            >{{ form.errors.get("product_name") }}</span
          >
        </div>
      </div>
      <div class="vx-row mb-4">
        <div class="vx-col w-1/2">
          <vs-input
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
        <div class="vx-col w-1/2">
          <vs-input
            class="w-full"
            label-placeholder="Price"
            v-model="form.price"
            :danger="form.errors.has('price')"
          />
          <span class="text-danger text-sm" v-show="form.errors.has('price')">{{
            form.errors.get("price")
          }}</span>
        </div>
      </div>

      <div class="vx-row">
        <div class="vx-col w-full">
          <vs-button
            class="mr-3 mb-4"
            @click.prevent="onSubmit"
            :disabled="form.errors.any()"
            >Update</vs-button
          >
          <vs-button color="warning" type="border" class="mb-4" @click="reset"
            >Reset</vs-button
          >
        </div>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  props: ["form"],
  data() {
    return {};
  },
  methods: {
    reset() {
      this.form.product_name = "";
      this.form.quantity = this.form.price = 0;
    },
    onSubmit() {
      this.form
        .submit("patch", `/api/cold_drinks/${this.form.id}`)
        .then(() => {
          this.$store.dispatch("RETRIEVE_ALL_COLD_DRINKS");
          this.$vs.notify({
            color: "success",
            title: "Updated",
            text: `Cold Drink updated successfully.`,
          });
        })
        .catch();
    },
  },
  computed: {},
};
</script>