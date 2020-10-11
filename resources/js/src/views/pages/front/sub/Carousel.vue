<template>
  <div class="carousel-example" style="height: 90vh">
    <!-- swiper -->
    <swiper
      :options="swiperOption"
      :dir="$vs.rtl ? 'rtl' : 'ltr'"
      :key="$vs.rtl"
    >
      <swiper-slide> </swiper-slide>
      <swiper-slide> </swiper-slide>
      <swiper-slide> </swiper-slide>
      <div
        class="swiper-pagination swiper-pagination-white"
        slot="pagination"
      ></div>
      <div
        class="swiper-button-prev swiper-button-white"
        slot="button-prev"
      ></div>
      <div
        class="swiper-button-next swiper-button-white"
        slot="button-next"
      ></div>
    </swiper>
  </div>
</template>

<script>
import "swiper/dist/css/swiper.min.css";
import { swiper, swiperSlide } from "vue-awesome-swiper";
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      swiperOption: {
        spaceBetween: 30,
        effect: "fade",
        speed: 600,
        parallax: true,
        autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },

        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      },
    };
  },
  components: {
    swiper,
    swiperSlide,
  },
  computed: {
    ...mapGetters({ hotelDetails: "getHotelDetails" }),
  },
};
</script>
          

          <style scoped>
.swiper-slide {
  font-size: 18px;
  color: #fff;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  padding: 40px 60px;
  background-color: transparent !important;
  justify-content: space-around !important;
  height: 90vh;
}

.parallax-bg {
  position: absolute;
  left: 0;
  top: 0;
  width: 130%;
  height: 100%;
  -webkit-background-size: cover;
  background-size: cover;
  background-position: center;
  background-image: url("hhttps://images.pexels.com/photos/3732383/pexels-photo-3732383.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940");
}

.swiper-slide .title {
  font-size: 41px;
  font-weight: 300;
}

.swiper-slide .subtitle {
  font-size: 21px;
}

.swiper-slide .text {
  font-size: 14px;
  max-width: 400px;
  line-height: 1.3;
}
</style>
        