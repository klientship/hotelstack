<template>
  <div>
    <div class="vx-row mt-4">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_payment"
          statisticTitle="Today's Payments"
          :chartData="dashboardDetails.payments.series"
          type="area"
          color="success"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.todays_pending_payment"
          statisticTitle="Today's Pending Payments"
          :chartData="dashboardDetails.pending_payments.series"
          type="area"
          color="danger"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_payments_received"
          statisticTitle="Total Payments Received"
          :chartData="dashboardDetails.payments.series"
          type="area"
          color="warning"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_pending_payments"
          statisticTitle="Total Pending Payments"
          :chartData="dashboardDetails.payments.series"
          type="area"
          color="dark"
        ></statistics-card-line>
      </div>
    </div>

    <!-- numbers -->
    <div class="vx-row mt-4">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_walkin_business"
          statisticTitle="Todays Total Walkins"
          :chartData="dashboardDetails.walkin_business.series"
          type="area"
          color="success"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_oyo_business"
          statisticTitle="Todays Oyo Bookings"
          :chartData="dashboardDetails.oyo_business.series"
          type="area"
          color="danger"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_today_checkin"
          statisticTitle="Todays Total Checkins"
          :chartData="dashboardDetails.checkin_business.series"
          type="area"
          color="warning"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_checkedin"
          statisticTitle="Total Occupied Rooms"
          :chartData="dashboardDetails.checkin_business.series"
          type="area"
          color="primary"
        ></statistics-card-line>
      </div>
    </div>

    <div class="vx-row mt-4">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_today_checkout"
          statisticTitle="Today's Total Checkout"
          :chartData="dashboardDetails.checkout_business.series"
          type="area"
          color="danger"
        ></statistics-card-line>
      </div>

      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_future_bookings"
          statisticTitle="Future Bookings"
          :chartData="dashboardDetails.future_bookings_business.series"
          type="area"
          color="dark"
        ></statistics-card-line>
      </div>

      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.total_no_checkin"
          statisticTitle="Total Checkins (All)"
          :chartData="dashboardDetails.checkin_business.series"
          type="area"
          color="warning"
        ></statistics-card-line>
      </div>

      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.income"
          statisticTitle="Profit"
          :chartData="dashboardDetails.payments.series"
          type="area"
          color="success"
        ></statistics-card-line>
      </div>
    </div>

    <div class="vx-row mt-2">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.todays_walkin_business"
          statisticTitle="Today's Walkin Business"
          :chartData="dashboardDetails.walkin_business.series"
          type="area"
          color="warning"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.todays_oyo_business"
          statisticTitle="Today's Oyo Business"
          :chartData="dashboardDetails.oyo_business.series"
          type="area"
          color="danger"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.todays_cold_drink_business"
          statisticTitle="Soft drinks"
          :chartData="dashboardDetails.cold_drinks.series"
          type="area"
          color="success"
        ></statistics-card-line>
      </div>
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/4 xl:w-1/4 mb-base">
        <statistics-card-line
          icon="BarChartIcon"
          :statistic="dashboardDetails.todays_paid_service_business"
          statisticTitle="Paid Services"
          :chartData="dashboardDetails.paid_services.series"
          type="area"
          color="danger"
        ></statistics-card-line>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import StatisticsCardLine from "@/components/statistics-cards/StatisticsCardLine.vue";
export default {
  components: {
    StatisticsCardLine,
  },
  computed: {
    ...mapGetters({ dashboardDetails: "getDashboardDetails" }),
  },
  created() {
    this.$store.dispatch("RETRIEVE_DASHBOARD_DETAILS");
  },
};
</script>