<template>
  <div>
    <AddPaidService :id="id"></AddPaidService>

    <PaidServiceList :id="id"></PaidServiceList>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import PaidServiceList from "./PaidServiceList";
import AddPaidService from "./AddPaidService";
export default {
  props: ["title", "id"],
  components: {
    PaidServiceList,
    AddPaidService,
  },
  data() {
    return {};
  },
  computed: {
    ...mapGetters({ products: "getReservationPaidServices" }),
  },
  methods: {
    deleteData(id) {
      this.$store.dispatch("deleteReservationPaidService", id).then(() => {
        this.$store.dispatch("retrieveReservationPaidServices", this.id);
      });
    },
  },
  created() {
    this.$store.dispatch("retrieveReservationPaidServices", this.id);
  },
};
</script>