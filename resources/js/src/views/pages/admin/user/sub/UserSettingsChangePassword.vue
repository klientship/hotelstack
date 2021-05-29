<template>
  <vx-card no-shadow>
    <!-- ERRORS -->
    <display-error :form="form"></display-error>
    <!-- End ERRORS -->
    <vs-input
      class="w-full mb-base"
      label-placeholder="Old Password"
      v-model="form.password"
    />
    <vs-input
      class="w-full mb-base"
      label-placeholder="New Password"
      v-model="form.new_password"
    />
    <vs-input
      class="w-full mb-base"
      label-placeholder="Confirm Password"
      v-model="form.confirm_new_password"
    />

    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="ml-auto mt-2" @click="update">Update</vs-button>
    </div>
  </vx-card>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        password: "",
        new_password: "",
        confirm_new_password: "",
      }),
    };
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser;
    },
    user() {
      return this.$store.getters.getUserData.user;
    },
  },
  methods: {
    update() {
      this.form
        .submit("patch", `/api/user/${this.user.id}/reset_password`)
        .then(() => {
          this.$store.dispatch("RETRIEVE_ACTIVE_USER_DETAILS");
          this.$vs.notify({
            color: "success",
            title: "Updated",
            text: `User password updated successfully.`,
          });
        })
        .catch();
    },
  },

  created() {
    this.$store.dispatch("RETRIEVE_ACTIVE_USER_DETAILS");
  },
};
</script>
