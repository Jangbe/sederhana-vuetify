<template>
    <!-- <div class="d-none d-md-inline">
        <ul class="list-group mb-3">
            <li class="list-group-item bg-dark text-light text-center">
                <span class="h5">Kategori</span>
                <button type="button" class="close" data-target="#kategori" data-toggle="collapse">
                    <span aria-hidden="true"><i class="fas fa-plus text-white"></i></span>
                </button>
            </li>
            <div class="collapse show" id="kategori">
                <router-link class="list-group-item list-group-item-action list-group-item-dark" exact :to="{name: 'product'}">Semua</router-link>
                <router-link v-for="category in categories" :key="category.id" class="list-group-item list-group-item-action list-group-item-dark" :to="{name: 'product', params: {category: category.slug}}" v-text="category.nama_kategori"></router-link>
            </div>
        </ul>
    </div> -->
  <v-card class="mb-3" max-width="300" tile>
    <v-list shaped>
      <v-subheader>KATEGORI</v-subheader>
      <v-list-item-group color="primary">
        <v-list-item :to="{name: 'product'}" exact>
            <v-list-item-content>
                <v-list-item-title>Semua Kategori</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list-item v-for="(item, i) in categories" :key="i" :to="{name: 'product', params: {category: item.slug}}">
          <!-- <v-list-item-icon>
            <v-icon v-text="item.icon"></v-icon>
          </v-list-item-icon> -->
          <v-list-item-content>
            <v-list-item-title v-text="item.nama_kategori"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
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
    mounted(){
        axios.get('/api/kategori/index').then((response) => {
            this.categories = response.data;
        });
    }
}
</script>
