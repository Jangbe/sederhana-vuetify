<template>
<!-- <div class="d-none d-md-inline">
<ul class="list-group">
    <li class="list-group-item bg-dark text-white text-center">
        <i class="fas fa-cart-plus"></i> <span class="h5 pl-2">Keranjangku</span>
        <button type="button" class="close" data-target="#keranjang1" data-toggle="collapse">
            <span aria-hidden="true"><i class="fas fa-plus text-white"></i></span>
        </button>
    </li>
    <div class="collapse show" id="keranjang1">
        <section v-if="isThere">
            <li class="list-group-item"  v-for="cart in carts.product" :key="cart.data.id_product">
                {{cart.jumlah}} <b v-text="cart.data.nama_barang"></b> {{`(${cart.jumlah} x ${number_format(cart.data.harga_barang)})`}}
                <button :ref="cart.data.id" type="button" class="close" @click="hapus(cart.data.id_product)">
                    <i class="fas fa-trash text-danger"></i>
                </button> <br>
                => Rp. {{ number_format(cart.jumlah * cart.data.harga_barang) }}
            </li>
        </section>
        <section v-else>
            <li class="list-group-item text-center text-danger">
                Keranjang belanja masih kosong
            </li>
        </section>
    </div>
    <li class="list-group-item bg-dark text-white">
        Jumlah : {{carts.jumlah}} item | Rp. {{ number_format(carts.harga) }}
    </li>
</ul>
</div> -->
  <v-card tile>
    <v-list>
      <v-subheader><v-icon left>mdi-cart-arrow-right</v-icon>Keranjang</v-subheader>
      <v-divider></v-divider>
      <template v-if="isThere">
        <v-list-item v-for="(item, i) in carts.product" :key="i">
            <v-list-item-content>
                <v-list-item-title class="d-flex justify-space-between">
                    <span class="pt-2">
                        {{item.jumlah+' '+item.data.nama_barang}} ({{item.jumlah +' x '+ number_format(item.data.harga_barang)}})
                    </span>
                    <v-btn text class="red--text" @click="hapus(item.data.id_product)">
                        <v-icon>mdi-cart-remove</v-icon>
                    </v-btn>
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
      <v-divider></v-divider>
      </template>
      <template v-else>
          <v-list-item>
              <v-list-item-content>
                  <v-list-item-title class="d-flex justify-center red--text">
                      Keranjang masih kosong
                  </v-list-item-title>
              </v-list-item-content>
          </v-list-item>
      </template>
      <v-divider></v-divider>
      <v-list-item>
          <v-list-item-content>
              <v-list-item-title>
                  Jumlah : {{carts.jumlah}} item | Rp. {{ number_format(carts.harga) }}
              </v-list-item-title>
          </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-card>
</template>
<script>
import number_format from '../number_format';
export default {
    props: ['hasChange'],
    data(){
        return{
            carts: {},
            isThere: false,
            number_format,
            count: 0,
        }
    },
    watch:{
        count: function(){this.getCarts()},
        hasChange: function(){this.getCarts()}
    },
    mounted(){
        this.getCarts();
    },
    methods:{
        hapus(id){
            axios.get(`/api/keranjang/hapus/${id}`).then((respon) =>{
                this.$toasted.show(respon.data.message, {
                    duration: 2000,
                    type: respon.data.type
                });
            });
            this.count--;
        },

        getCarts(){
            axios.get('/api/keranjang/get').then((data) => {
                this.number_format = number_format;
                this.count = data.data.count;
                if (data.data.count == 0) {
                    this.isThere = false;
                }else{
                    this.isThere = true;
                }
                this.carts = data.data;
            });
        }
    }
}
</script>
