<template>
  <div>
    <vs-alert
      color="danger"
      class="mt-4"
      v-for="(value, propertyName) in form.originalData"
      :active.sync="form.errors.has(propertyName)"
      :key="propertyName"
    >{{form.errors.get(propertyName)}}</vs-alert>
  </div>
</template>

<script>
export default {
  props: ["form"],
  name: "display-error",
};
</script>