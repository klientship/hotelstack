<template>
  <div>
    <div class="container mt-4">
      <vx-card>
        <CreateOnlineBooking title="Reservation"></CreateOnlineBooking>
      </vx-card>
    </div>
  </div>
</template>

<script>
import Navbar from "./sub/Navbar";
import CreateOnlineBooking from "./sub/CreateOnlineBooking";
export default {
  components: {
    CreateOnlineBooking,
    Navbar,
  },
};
</script>