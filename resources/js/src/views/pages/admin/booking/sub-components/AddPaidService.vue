<template>
  <div>
    <!-- ERRORS -->
    <display-error :form="form"></display-error>
    <!-- end Errors -->

    <form @keydown="form.errors.clear()">
      <div class="p-4">
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <vs-input class="w-full" label-placeholder="Description" v-model="form.description" />
          </div>
        </div>
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <vs-input type="text" class="w-full" label-placeholder="Price" v-model="form.price" />
          </div>
        </div>

        <div class="vx-row mb-4">
          <div class="vx-col w-1/2">
            <vs-button
              class="mr-3 mb-4"
              @click.prevent="onSubmit"
              :disabled="form.errors.any()"
            >Submit</vs-button>
            <vs-button color="warning" type="border" class="mb-4" @click="reset">Reset</vs-button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      form: new Form({
        description: "",
        price: 0,
        reservation_id: "",
      }),
    };
  },
  methods: {
    reset() {
      this.form.description = "";
      this.form.price = 0;
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
            text: "Paid Service created successfully.",
          });
        })
        .catch();
    },
  },
};
</script>