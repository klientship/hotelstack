<template>
  <vx-card title="Restaurant POS" title-color="primary">
    <div class="vx-row mb-4">
      <div class="vx-col w-1/8">
        <h5>Table No</h5>
        <v-select
          :options="[
            { label: '1', value: '1' },
            { label: '2', value: '2' },
            { label: '3', value: '3' },
          ]"
          :dir="$vs.rtl ? 'rtl' : 'ltr'"
          v-model="form.table_no"
          class="mt-2 text-xs"
        />
      </div>
      <div class="vx-col w-1/8">
        <p>Item code</p>
        <v-select
          :options="[
            { label: '101', value: '101' },
            { label: '222', value: '222' },
            { label: '233', value: '233' },
          ]"
          :dir="$vs.rtl ? 'rtl' : 'ltr'"
          v-model="form.item_code"
          class="mt-2 text-xs"
        />
      </div>
      <div class="vx-col w-1/3">
        <p>Item name</p>
        <v-select
          :options="[
            { label: 'chappathi', value: 'chappathi' },
            { label: 'chicken', value: 'chicken' },
            { label: 'juice', value: 'juice' },
          ]"
          :dir="$vs.rtl ? 'rtl' : 'ltr'"
          v-model="form.item_name"
          class="mt-2 text-xs"
        />
      </div>
      <div class="vx-col w-1/6">
        <p>Qty</p>
        <v-select
          :options="[
            { label: '1', value: '1' },
            { label: '2', value: '2' },
          ]"
          :dir="$vs.rtl ? 'rtl' : 'ltr'"
          v-model="form.qty"
          class="mt-2 text-xs"
        />
      </div>
      <div class="vx-col w-1/8">
        <p>Price</p>
        <vs-input v-model="form.price" class="mt-2" size="small"></vs-input>
      </div>
    </div>
    <div class="vx-row mb-4"></div>
    <div>
      <vs-table :data="users" max-items="3">
        <template slot="thead">
          <vs-th>Item name</vs-th>
          <vs-th>Item code</vs-th>
          <vs-th>Qty</vs-th>
          <vs-th>Price</vs-th>
        </template>

        <template slot-scope="{ data }">
          <vs-tr :key="indextr" v-for="(tr, indextr) in data">
            <vs-td :data="data[indextr].email">
              {{ data[indextr].email }}
            </vs-td>

            <vs-td :data="data[indextr].username">
              {{ data[indextr].name }}
            </vs-td>

            <vs-td :data="data[indextr].id">
              {{ data[indextr].website }}
            </vs-td>

            <vs-td :data="data[indextr].id">
              {{ data[indextr].id }}
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
    </div>
    <div class="vx-row mt-4">
      <div class="vx-col w-1/5">
        <vs-input
          label-placeholder="Service charge"
          v-model="form.service_charge"
          size="small"
        />
      </div>
      <div class="vx-col w-1/5">
        <vs-input
          label-placeholder="Discount"
          v-model="form.discount"
          size="small"
        />
      </div>

      <div class="vx-col w-1/5">
        <vs-input label-placeholder="Tax" v-model="form.tax" size="small" />
      </div>
      <div class="vx-col w-1/5">
        <vs-chip color="primary" class="mt-2 p-4"
          ><h6 class="text-white">Total: &#x20B9;200</h6></vs-chip
        >
      </div>
      <div class="vx-col w-1/5 mt-5">
        <vs-button size="small">Add</vs-button>
        <vs-button color="success" size="small">Bill</vs-button>
        <vs-button color="warning" size="small">KOT</vs-button>
      </div>
    </div>
  </vx-card>
</template>

<script>
import vSelect from "vue-select";
export default {
  components: {
    "v-select": vSelect,
  },
  data() {
    return {
      users: [
        {
          id: 1,
          name: "Leanne Graham",
          username: "Bret",
          email: "Sincere@april.biz",
          website: "hildegard.org",
        },
        {
          id: 1,
          name: "Leanne Graham",
          username: "Bret",
          email: "Sincere@april.biz",
          website: "hildegard.org",
        },
        {
          id: 1,
          name: "Leanne Graham",
          username: "Bret",
          email: "Sincere@april.biz",
          website: "hildegard.org",
        },
        {
          id: 2,
          name: "Ervin Howell",
          username: "Antonette",
          email: "Shanna@melissa.tv",
          website: "anastasia.net",
        },
        {
          id: 3,
          name: "Clementine Bauch",
          username: "Samantha",
          email: "Nathan@yesenia.net",
          website: "ramiro.info",
        },
        {
          id: 4,
          name: "Patricia Lebsack",
          username: "Karianne",
          email: "Julianne.OConner@kory.org",
          website: "kale.biz",
        },
        {
          id: 5,
          name: "Patricia Lebsack",
          username: "Karianne",
          email: "Julianne.OConner@kory.org",
          website: "kale.biz",
        },
        {
          id: 6,
          name: "Patricia Lebsack",
          username: "Karianne",
          email: "Julianne.OConner@kory.org",
          website: "kale.biz",
        },
      ],
      form: new Form({
        table_no: "",
        item_code: "",
        item_name: "",
        qty: "",
        price: "200",
        service_charge: 100,
        discount: 100,
        tax: 100,
        total: 100,
      }),
    };
  },
  methods: {},
  mounted() {},
};
</script>

