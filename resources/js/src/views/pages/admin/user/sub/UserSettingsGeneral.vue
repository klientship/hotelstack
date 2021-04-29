<template>
  <vx-card no-shadow>
    <!-- Img Row -->
    <div class="flex flex-wrap items-center mb-base">
      <vs-avatar :src="activeUserInfo.photoURL" size="70px" class="mr-4 mb-4" />
      <div>
        <vs-button class="mr-4 sm:mb-0 mb-2">Upload photo</vs-button>
        <vs-button type="border" color="danger">Remove</vs-button>
        <p class="text-sm mt-2">Allowed JPG, GIF or PNG. Max size of 800kB</p>
      </div>
    </div>

    <!-- Info -->

    <div class="vx-row mb-base">
      <div class="vx-col w-1/2">
        <vs-input
          class="w-full"
          label-placeholder="Name"
          v-model="name"
        ></vs-input>
      </div>
      <div class="vx-col w-1/2">
        <vs-input
          class="w-full"
          label-placeholder="Email"
          v-model="email"
        ></vs-input>
      </div>
    </div>

    <div class="vx-row mb-base">
      <div class="vx-col w-1/3">
        <vs-input
          class="w-full"
          label-placeholder="Mobile"
          v-model="mobile"
        ></vs-input>
      </div>
      <div class="vx-col w-1/3">
        <vs-input
          class="w-full"
          label-placeholder="GST"
          v-model="gst_no"
        ></vs-input>
      </div>
      <div class="vx-col w-1/3">
        <vs-input
          class="w-full"
          label-placeholder="Zipcode"
          v-model="zipcode"
        ></vs-input>
      </div>
    </div>
    <vs-input
      class="w-full mb-base"
      label-placeholder="Invoice Title"
      v-model="invoiceTitle"
    ></vs-input>
    <div class="vx-row">
      <div class="vx-col w-1/2">
        <vs-textarea
          class="w-full"
          placeholder="Address Line 1"
          v-model="addressLine1"
        ></vs-textarea>
      </div>
      <div class="vx-col w-1/2">
        <vs-textarea
          class="w-full"
          placeholder="Address Line 2"
          v-model="addressLine2"
        ></vs-textarea>
      </div>
    </div>

    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="ml-auto mt-2">Update</vs-button>
      <vs-button class="ml-4 mt-2" type="border" color="warning"
        >Reset</vs-button
      >
    </div>
  </vx-card>
</template>

<script>
export default {
  data() {
    return {
      username: "johny_01",
      name: this.$store.state.AppActiveUser.displayName,
      email: "john@admin.com",
      invoiceTitle: "",
      addressLine1: "",
      addressLine2: "",
    };
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser;
    },
  },
};
</script>
