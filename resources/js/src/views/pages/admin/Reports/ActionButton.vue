<template>
  <span class="currency">{{ params.value | currency('EUR') }}</span>
</template>

<script>
export default {
  filters: {
    currency(value, symbol) {
      let result = value;
      if (!isNaN(value)) {
        result = value.toFixed(2);
      }
      return symbol ? symbol + result : result;
    },
  },
};
</script>

<style scoped>
.currency {
  color: blue;
}
</style>