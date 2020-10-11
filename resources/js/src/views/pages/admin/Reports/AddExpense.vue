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
            Select Expense Catgeory
            <v-select
              label="name"
              :options="expense_categories"
              @input="selectCategory($event)"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <br />
          </div>
        </div>
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <flat-pickr
              :config="configdateTimePicker"
              v-model="form.date"
              placeholder="Date"
              class="w-full"
            />
          </div>
        </div>
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <vs-input class="w-full" label-placeholder="Name" v-model="form.name" />
          </div>
        </div>
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <vs-input class="w-full" label-placeholder="Amount" v-model="form.amount" />
          </div>
        </div>
        <div class="vx-row mb-4">
          <div class="vx-col w-full">
            <vs-textarea class="w-full" label="Note" v-model="form.note" />
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
              @click="form.name = form.note = form.date = form.category_id =  ''; "
            >Reset</vs-button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import vSelect from "vue-select";

import { mapGetters } from "vuex";

export default {
  components: {
    flatPickr,
    vSelect,
  },
  data() {
    return {
      configdateTimePicker: {
        enableTime: true,
        dateFormat: "d-m-Y",
      },
      form: new Form({
        amount: 0,
        category_id: "",
        date: "",
        name: "",
        note: "",
      }),
    };
  },
  computed: {
    ...mapGetters({ expense_categories: "getAllExpenseCategories" }),
  },
  methods: {
    onSubmit() {
      this.form
        .submit("post", "/api/expenses")
        .then(() => {
          this.$store.dispatch("RETRIEVE_ALL_EXPENSES");
          this.$vs.notify({
            color: "success",
            title: "Created",
            text: `Expense created successfully.`,
          });
        })
        .catch();
    },
    selectCategory(data) {
      this.form.category_id = data.id;
    },
  },
  created() {
    this.$store.dispatch("RETRIEVE_ALL_EXPENSE_CATEGORIES");
  },
};
</script>