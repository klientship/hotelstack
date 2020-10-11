
<template>
  <div class="carousel-example">
    <div class="swiper-inner">
      <!-- swiper -->
      <swiper
        :options="swiperOption"
        :dir="$vs.rtl ? 'rtl' : 'ltr'"
        :key="$vs.rtl"
      >
        <swiper-slide>
          <img
            class="responsive"
            src="@assets/images/pages/carousel/banner-1.jpg"
            alt="banner"
          />
        </swiper-slide>
        <swiper-slide>
          <img
            class="responsive"
            src="@assets/images/pages/carousel/banner-2.jpg"
            alt="banner"
          />
        </swiper-slide>
        <swiper-slide>
          <img
            class="responsive"
            src="@assets/images/pages/carousel/banner-3.jpg"
            alt="banner"
          />
        </swiper-slide>
        <swiper-slide>
          <img
            class="responsive"
            src="@assets/images/pages/carousel/banner-1.jpg"
            alt="banner"
          />
        </swiper-slide>
        <swiper-slide>
          <img
            class="responsive"
            src="@assets/images/pages/carousel/banner-2.jpg"
            alt="banner"
          />
        </swiper-slide>

        <div class="swiper-pagination" slot="pagination"></div>
      </swiper>
    </div>
  </div>
</template>

<script>
import "swiper/dist/css/swiper.min.css";
import { swiper, swiperSlide } from "vue-awesome-swiper";

export default {
  data() {
    return {
      swiperOption: {
        effect: "cube",
        grabCursor: true,
        cubeEffect: {
          shadow: true,
          slideShadows: true,
          shadowOffset: 20,
          shadowScale: 0.94,
        },
        pagination: {
          el: ".swiper-pagination",
        },
      },
    };
  },
  components: {
    swiper,
    swiperSlide,
  },
};
</script>

<style scoped>
.swiper-inner {
  position: relative;
  overflow: hidden;
  height: 330px;
  padding: 15px;
}

.swiper-container {
  width: 300px !important;
  height: 300px;
  position: absolute;
  left: 50%;
  top: 50%;
  margin-left: -150px;
  margin-top: -150px;
}

.swiper-slide {
  background-position: center;
  background-size: cover;
}
</style>