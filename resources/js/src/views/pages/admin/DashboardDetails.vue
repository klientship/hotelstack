<template>
  <div>
    <vs-chip color="success" class="ml-2"
      >Available Rooms:
      {{ availableRooms.length - houseKeepings.length }}</vs-chip
    >
    <vs-chip color="danger" class="ml-2"
      >Walkin: {{ walkinRooms.length }}</vs-chip
    >
    <vs-chip color="primary" class="ml-2"
      >OTA Bookings: {{ oyoBookings.length }}</vs-chip
    >
    <vs-chip color="warning" class="ml-2"
      >Awaiting Checkouts: {{ awaitingCheckouts.length }}</vs-chip
    >

    <vs-chip color="dark" class="ml-2"
      >House Keeping: {{ houseKeepings.length }}</vs-chip
    >
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({ availableRooms: "getAvailableRoomsToday" }),
    ...mapGetters({ houseKeepings: "getHouseKeepings" }),
    ...mapGetters({ awaitingCheckouts: "getAwaitingCheckoutId" }),
    ...mapGetters({ oyoBookings: "getOyoBookingsId" }),
    ...mapGetters({ totalRooms: "getTotalRooms" }),
    ...mapGetters({ walkinRooms: "getWalkinBookingsRoomId" }),
  },
  created() {},
};
</script>