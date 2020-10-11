<template>
  <div>
    <!-- add new -->

    <!-- ERRORS -->
    <display-error :form="form"></display-error>
    <!-- End ERRORS -->

    <form @keydown="form.errors.clear()">
      <div class="p-4">
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <vs-input class="w-full" label-placeholder="Name" v-model="form.name" />
          </div>
        </div>

        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <vs-textarea class="w-full" label="Description" v-model="form.description" />
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
              @click="form.name = form.description=  ''; "
            >Reset</vs-button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        name: "",
        description: "",
      }),
    };
  },
  methods: {
    onSubmit() {
      this.form
        .submit("post", "/api/expense_categories")
        .then(() => {
          this.$store.dispatch("RETRIEVE_ALL_EXPENSE_CATEGORIES");
          this.$vs.notify({
            color: "success",
            title: "Created",
            text: `Expense Category created successfully.`,
          });
        })
        .catch();
    },
  },
};
</script>