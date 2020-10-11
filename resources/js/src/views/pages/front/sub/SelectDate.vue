<template>
  <vx-card title-color="primary text-center ">
    <div class="flex flex-wrap -mx-3 mb-2">
      <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          for="grid-city"
        >CHECK IN</label>

        <flat-pickr
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          :config="configFromdateTimePicker"
          v-model="fromDate"
          placeholder="SELECT DATE"
          @on-change="onFromChange"
          size="large"
        />
      </div>
      <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          for="grid-state"
        >CHECK OUT</label>
        <div class="relative">
          <flat-pickr
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            :config="configTodateTimePicker"
            v-model="toDate"
            placeholder="SELECT DATE"
            @on-change="onToChange"
            size="large"
          />
        </div>
      </div>
      <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Adults</label>
        <input
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          type="text"
          v-model="adults"
        />
      </div>
      <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Kids</label>
        <input
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          type="text"
          v-model="kids"
        />
      </div>
      <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
        <vs-button
          color="primary"
          type="filled"
          size="large"
          class="mt-4"
          @click="findRooms"
        >Find Rooms</vs-button>
      </div>
    </div>
  </vx-card>
</template>

<script>
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
export default {
  components: {
    flatPickr,
  },
  data() {
    return {
      fromDate: null,
      toDate: null,
      adults: 1,
      kids: 0,
      configFromdateTimePicker: {
        minDate: new Date(),
        maxDate: null,
        enableTime: true,
        dateFormat: "d-m-Y H:i",
      },
      configTodateTimePicker: {
        minDate: null,
        enableTime: true,
        dateFormat: "d-m-Y H:i",
      },
    };
  },
  methods: {
    onFromChange(selectedDates, dateStr, instance) {
      this.$set(this.configTodateTimePicker, "minDate", dateStr);
    },
    onToChange(selectedDates, dateStr, instance) {
      this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
    },
    findRooms() {
      this.$router.push({ name: "create_reservation" });
    },
  },
};
</script>

<style scoped>
</style>