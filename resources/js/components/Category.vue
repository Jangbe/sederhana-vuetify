<template>
  <v-card class="mb-4" tile>
    <v-list-group prepend-icon="mdi-shape" shaped value="true">
      <template v-slot:activator><v-list-item-title>Kategori</v-list-item-title></template>
      <v-divider></v-divider>
      <v-list-item-group color="primary">
        <v-list-item :to="{name: 'product'}" exact>
            <v-list-item-content>
                <v-list-item-title>Semua Kategori</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list-item v-for="(item, i) in categories" :key="i" :to="{name: 'product', params: {category: item.slug}}">
          <v-list-item-content>
            <v-list-item-title v-text="item.nama_kategori"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list-group>
  </v-card>
</template>

<script>
export default {
    props: [],
    data(){
        return {
            categories: []
        }
    },
    beforeCreate(){
        axios.get('/api/kategori/index').then((response) => {
            this.categories = response.data;
        });
    }
}
</script>
