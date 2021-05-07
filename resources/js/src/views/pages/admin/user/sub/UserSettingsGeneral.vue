<template>
  <vx-card no-shadow>
    <!-- Img Row -->
    <div class="flex flex-wrap items-center mb-base">
      <vs-avatar
        :src="activeUserInfo.user.photoURL"
        size="70px"
        class="mr-4 mb-4"
      />
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
          v-model="activeUserInfo.user.name"
        ></vs-input>
      </div>
      <div class="vx-col w-1/2">
        <vs-input
          class="w-full"
          label-placeholder="Email"
          v-model="activeUserInfo.user.email"
        ></vs-input>
      </div>
    </div>

    <div class="vx-row mb-base">
      <div class="vx-col w-1/3">
        <vs-input
          class="w-full"
          label-placeholder="Mobile"
          v-model="activeUserInfo.user.phone"
        ></vs-input>
      </div>
      <div class="vx-col w-1/3">
        <vs-input
          class="w-full"
          label-placeholder="GST"
          v-model="activeUserInfo.user.gst_no"
        ></vs-input>
      </div>
      <div class="vx-col w-1/3">
        <vs-input
          class="w-full"
          label-placeholder="Zipcode"
          v-model="activeUserInfo.user.zipcode"
        ></vs-input>
      </div>
    </div>
    <vs-input
      class="w-full mb-base"
      label-placeholder="Invoice Title"
      v-model="activeUserInfo.user.invoice_title"
    ></vs-input>
    <div class="vx-row">
      <div class="vx-col w-1/2">
        <vs-textarea
          class="w-full"
          placeholder="Address Line 1"
          v-model="activeUserInfo.user.address_line_1"
        ></vs-textarea>
      </div>
      <div class="vx-col w-1/2">
        <vs-textarea
          class="w-full"
          placeholder="Address Line 2"
          v-model="activeUserInfo.user.address_line_2"
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
import { mapGetters } from "vuex";
export default {
  data() {
    return {};
  },
  computed: {
    ...mapGetters({ activeUserInfo: "getUserData" }),
  },
  created() {
    this.$store.dispatch("RETRIEVE_ACTIVE_USER_DETAILS");
  },
};
</script>
