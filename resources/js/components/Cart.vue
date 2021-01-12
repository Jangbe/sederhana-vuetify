<template>
  <v-card tile>
    <v-list-group prepend-icon="mdi-cart-arrow-right" value="true">
      <template v-slot:activator><v-list-item-title>Keranjang</v-list-item-title></template>
      <v-divider></v-divider>
      <template v-if="carts.count > 0">
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
    </v-list-group>
  </v-card>
</template>
<script>
import number_format from '../number_format';
export default {
    data(){
        return{
            number_format
        }
    },
    computed: {
        carts(){
            return this.$store.state.carts;
        }
    },
    mounted(){
        this.init();
    },
    methods:{
        init(){
           this.number_format = number_format;
        },
        hapus(id){
           this.$swal.fire({
             title: 'Apakah kamu yakin?',
             text: "Jika iya, tekan tombol 'Ya'!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Ya'
           }).then((result) => {
             if (result.isConfirmed) {
              axios.get(`/api/keranjang/hapus/${id}`).then((respon) =>{
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: respon.data.type,
                    title: respon.data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                })
               });
               this.getCarts();
             }
          })
        },

        getCarts(){
            axios.get('/api/keranjang/get').then((data) => {
                this.$store.commit('editCart', data.data);
            });
        }
    }
}
</script>
