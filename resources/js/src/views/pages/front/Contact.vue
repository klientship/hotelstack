<template>
  <div class="container mt-4">
    <div class="py-6 bg-gray-100">
      <div class="px-4 mx-auto max-w-7xl lg:px-8">
        <div class="overflow-hidden bg-white rounded shadow">
          <div class="bg-white">
            <div class="mx-auto max-w-7xl lg:grid lg:grid-cols-5">
              <div
                class="px-4 py-16 bg-gray-50 sm:px-6 lg:col-span-2 lg:px-8 lg:py-24 xl:pr-12"
              >
                <div class="max-w-lg mx-auto">
                  <h2
                    class="text-2xl font-extrabold leading-8 tracking-tight text-gray-900 sm:text-3xl sm:leading-9"
                  >
                    Get in touch
                  </h2>
                  <p class="mt-3 text-lg leading-6 text-gray-500">
                    Thank you for your interest in our services, if you would
                    like to get in touch please find our contact details below
                    or use our contact form. We aim to reply to all enquiries
                    within 24 hours.
                  </p>

                  <dl class="mt-8 text-base leading-6 text-gray-500">
                    <div>
                      <dt class="sr-only">Physical address</dt>
                      <dd>
                        <p>{{ hotelDetails.name }}</p>
                        <p>{{ hotelDetails.addressLine1 }}</p>
                        <p>{{ hotelDetails.addressLine2 }}</p>
                        <p>Pincode: {{ hotelDetails.zipcode }}</p>
                      </dd>
                    </div>
                    <div class="mt-3">
                      <dt class="sr-only">Email</dt>
                      <dd class="flex">
                        <svg
                          class="flex-shrink-0 w-6 h-6 text-gray-400"
                          stroke="currentColor"
                          fill="none"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                          ></path>
                        </svg>
                        <span class="ml-3"
                          ><a
                            :href="mail"
                            class="font-medium text-gray-700 underline"
                            >{{ hotelDetails.mailId }}</a
                          ></span
                        >
                      </dd>
                    </div>
                  </dl>
                </div>
              </div>
              <div
                class="px-4 py-16 bg-white sm:px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12"
              >
                <div class="max-w-lg mx-auto lg:max-w-none">
                  <form
                    method="POST"
                    name="contact"
                    class="grid grid-cols-1 row-gap-6"
                  >
                    <input type="hidden" name="form-name" value="contact" />
                    <div>
                      <label for="name">Name</label>
                      <div class="relative rounded-md shadow-sm">
                        <input
                          id="name"
                          name="Name"
                          class="block w-full px-4 py-3 placeholder-gray-400 transition duration-150 ease-in-out form-input"
                          placeholder="Don Draper"
                        />
                      </div>
                    </div>
                    <div>
                      <label for="email">Email</label>
                      <div class="relative rounded-md shadow-sm">
                        <input
                          id="email"
                          name="Email"
                          type="email"
                          class="block w-full px-4 py-3 placeholder-gray-400 transition duration-150 ease-in-out form-input"
                          placeholder="don@draper.com"
                        />
                      </div>
                    </div>
                    <div>
                      <label for="phone">Phone</label>
                      <div class="relative rounded-md shadow-sm">
                        <input
                          id="phone"
                          name="Phone"
                          class="block w-full px-4 py-3 placeholder-gray-400 transition duration-150 ease-in-out form-input"
                          placeholder="0432 1111 1111"
                        />
                      </div>
                    </div>
                    <div>
                      <label for="message">Message</label>
                      <div class="relative rounded-md shadow-sm">
                        <textarea
                          id="message"
                          name="Message"
                          rows="4"
                          class="block w-full px-4 py-3 placeholder-gray-500 transition duration-150 ease-in-out form-input"
                        ></textarea>
                      </div>
                    </div>
                    <div>
                      <vs-button>Submit</vs-button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters({ hotelDetails: "getHotelDetails" }),
    mail() {
      return `mailto:${this.hotelDetails.mailId}`;
    },
  },
};
</script>