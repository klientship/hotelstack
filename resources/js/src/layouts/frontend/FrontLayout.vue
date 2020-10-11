
<template>
  <div class="layout--full-page">
    <router-view></router-view>
    <Footer></Footer>
    <Navbar></Navbar>
  </div>
</template>


<script>
import Navbar from "../../views/pages/front/sub/Navbar";
import Footer from "../../views/pages/front/sub/Footer";
export default {
  components: {
    Navbar,
    Footer,
  },
};
</script>