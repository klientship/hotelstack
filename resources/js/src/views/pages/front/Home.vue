<template>
  <div>
    <Carousel></Carousel>
    <SelectDate class="move-up"></SelectDate>
    <SectionAbout></SectionAbout>
    <FeatureSection></FeatureSection>
  </div>
</template>

<script>
import Navbar from "./sub/Navbar";
import SectionAbout from "./sub/SectionAbout";
import Carousel from "./sub/Carousel";
import SelectDate from "./sub/SelectDate";
import FeatureSection from "./sub/FeatureSection";
import HomeGallery from "./sub/HomeGallery";
import Footer from "./sub/Footer";

export default {
  components: {
    Navbar,
    Carousel,
    SelectDate,
    FeatureSection,
    Footer,
    SectionAbout,
  },
  data() {
    return {
      fromDate: null,
      toDate: null,
      configFromdateTimePicker: {
        minDate: null,
      },
      configTodateTimePicker: {
        minDate: null,
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
  },
};
</script>

<style scoped>
.move-up {
  margin-top: -3rem;
  z-index: 1;
}
</style>