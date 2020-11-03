<template>
  <div class="vx-row mt-4">
    <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
      <statistics-card-line
        icon="BarChartIcon"
        :statistic="data.total_bookings"
        statisticTitle="Total Bookings"
        :chartData="data.oyo_business.series"
        type="area"
        color="success"
      ></statistics-card-line>
    </div>
    <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
      <statistics-card-line
        icon="BarChartIcon"
        :statistic="data.monthly_bookings"
        statisticTitle="Monthly Bookings"
        :chartData="data.oyo_business.series"
        type="area"
      ></statistics-card-line>
    </div>
    <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
      <statistics-card-line
        icon="BarChartIcon"
        :statistic="data.total_amount"
        statisticTitle="Total Amount"
        :chartData="data.oyo_business.series"
        type="area"
      ></statistics-card-line>
    </div>
    <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
      <statistics-card-line
        icon="BarChartIcon"
        :statistic="data.monthly_total"
        statisticTitle="Monthly Total"
        :chartData="data.oyo_business.series"
        type="area"
      ></statistics-card-line>
    </div>
  </div>
</template>

<script>
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";
import { mapGetters } from "vuex";
export default {
  props: ["data"],
  components: {
    StatisticsCardLine,
  },
  computed: {},
  mounted() {},
};
</script>