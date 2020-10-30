<template>
  <div>
    <BuyColdDrinks :id="id"></BuyColdDrinks>
    <ReservationColdDrinkList :id="id"></ReservationColdDrinkList>
  </div>
</template>

<script>
import BuyColdDrinks from "./BuyColdDrinks";
import ReservationColdDrinkList from "./ReservationColdDrinkList";
export default {
  props: ["id"],
  components: {
    BuyColdDrinks,
    ReservationColdDrinkList,
  },
};
</script>