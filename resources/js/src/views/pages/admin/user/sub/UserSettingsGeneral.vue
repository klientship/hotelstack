<template>
  <vx-card no-shadow>
    <!-- ERRORS -->
    <display-error :form="form"></display-error>
    <!-- End ERRORS -->
    <!-- Img Row -->
    <div class="flex flex-wrap items-center mb-base">
      <vs-avatar :src="form.profile_img" size="70px" class="mr-4 mb-4" />
      <div>
        <vs-upload
          fileName="file"
          automatic
          :action="uploadUrl"
          @on-success="successUpload"
          @on-error="errorUpload"
          limit="1"
        />

        <!-- <vs-button type="border" color="danger">Remove</vs-button> -->
        <p class="text-sm mt-2">Allowed JPG, GIF or PNG. Max size of 800kB</p>
      </div>
    </div>

    <!-- Info -->

    <div class="vx-row mb-base">
      <div class="vx-col w-1/2">
        <vs-input
          class="w-full"
          label-placeholder="Name"
          v-model="form.name"
        ></vs-input>
      </div>
      <div class="vx-col w-1/2">
        <vs-input
          class="w-full"
          label-placeholder="Email"
          v-model="form.email"
        ></vs-input>
      </div>
    </div>

    <div class="vx-row mb-base">
      <div class="vx-col w-1/3">
        <vs-input
          class="w-full"
          label-placeholder="Mobile"
          v-model="form.phone"
        ></vs-input>
      </div>
      <div class="vx-col w-1/3">
        <vs-input
          class="w-full"
          label-placeholder="GST"
          v-model="form.gst_no"
        ></vs-input>
      </div>
      <div class="vx-col w-1/3">
        <vs-input
          class="w-full"
          label-placeholder="Zipcode"
          v-model="form.zipcode"
        ></vs-input>
      </div>
    </div>
    <vs-input
      class="w-full mb-base"
      label-placeholder="Invoice Title"
      v-model="form.invoice_title"
    ></vs-input>
    <div class="vx-row">
      <div class="vx-col w-1/2">
        <vs-textarea
          class="w-full"
          placeholder="Address Line 1"
          v-model="form.address_line_1"
        ></vs-textarea>
      </div>
      <div class="vx-col w-1/2">
        <vs-textarea
          class="w-full"
          placeholder="Address Line 2"
          v-model="form.address_line_2"
        ></vs-textarea>
      </div>
    </div>

    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="ml-auto mt-2" @click="update">Update</vs-button>
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
      form: new Form({
        id: "",
        name: "",
        email: "",
        phone: "",
        gst_no: "",
        zipcode: "",
        invoice_title: "",
        address_line_1: "",
        address_line_2: "",
        profile_img: "",
      }),
    };
  },
  methods: {
    update() {
      this.form
        .submit("patch", `/api/user/${this.form.id}`)
        .then(() => {
          this.$store.dispatch("RETRIEVE_ACTIVE_USER_DETAILS");
          this.$vs.notify({
            color: "success",
            title: "Updated",
            text: `User updated successfully.`,
          });
        })
        .catch();
    },
    successUpload() {
      this.$store.dispatch("RETRIEVE_ACTIVE_USER_DETAILS");
      const user = this.$store.getters.getUserData.user;
      this.form.profile_img = user.profile_img;
    },
    errorUpload() {
      this.$vs.notify({
        color: "danger",
        title: "Failed",
        text: `Something went wrong.`,
      });
    },
  },
  computed: {
    uploadUrl() {
      return `/api/upload/${this.form.id}`;
    },
  },
  created() {
    this.$store.dispatch("RETRIEVE_ACTIVE_USER_DETAILS");
    const user = this.$store.getters.getUserData.user;
    for (let property in user) {
      this.form[property] = user[property];
    }
  },
};
</script>
