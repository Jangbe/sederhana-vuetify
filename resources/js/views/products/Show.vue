<template>
    <v-container class="mt-3">
        <v-row>
            <v-col md="3" class="d-none d-md-block">
                <kategori :active="active"></kategori>
                <cart></cart>
            </v-col>
            <v-col md="9">
                <form action="#" method="post" @submit.prevent="cart">
                <v-card :loading="loading">
                    <v-row no-gutters>
                        <v-col cols="12" md="5">
                            <v-img max-height="400" :src="`/img/barang/${product.gambar}`"></v-img>
                        </v-col>
                        <v-col cols="12" md="7">
                            <v-card-title>
                                {{product.nama}}
                                <v-spacer></v-spacer>
                                <v-chip color="primary" outlined>
                                    Rp. {{number_format(harga)}}
                                </v-chip>
                            </v-card-title>
                            <v-card-text>
                                <v-row align="center" class="mx-0" >
                                    <v-rating :value="4.5" color="amber" dense half-increments readonly size="18" ></v-rating>

                                    <div class="grey--text ml-4">4.5 (413)</div>
                                </v-row>

                                <div class="my-4 subtitle-1">
                                    {{product.stok_kata}}
                                </div>
                            </v-card-text>

                            <v-divider></v-divider>

                            <v-card-text>
                                <v-row dense>
                                    <v-col :cols="12/product.stok.lenght" v-for="(value, name) in product.stok" :key="name">
                                        <v-text-field type="number" min="0" :max="value" @keyup="cekHarga(form.detail)" @change="cekHarga(form.detail)" :label="name" v-model="form.detail[name]" autocomplete="false"></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>

                            <v-card-actions>
                            <v-btn color="primary" text type="submit">
                                <v-icon left>mdi-cart-arrow-down</v-icon>Tambahkan Ke Keranjang
                            </v-btn>
                            </v-card-actions>
                        </v-col>
                    </v-row>
                </v-card>
                </form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import number_format from '../../number_format';
import Cart from '../../components/Cart.vue';
export default {
  components: { Cart },
    data(){
        return{
            loading: false,
            product: {},
            form: {
                id: '',
                detail: {},
            },
            active: '',
            number_format,
            harga: 0,
        }
    },
    mounted(){
        this.getProduct();
    },
    methods: {
        getProduct(){
            this.number_format = number_format;
            axios.get(`/api/product/index/${this.$route.params.id}/show`).then((data) => {
                this.product = data.data.data;
                this.harga = this.product.harga;
                this.active = this.product.slug;
            });
        },
        async cart(){
            this.loading = true;
            this.form.id = this.product.id;
            var response = await axios.post('/api/keranjang/make', this.form);
            axios.get('/api/keranjang/get').then(data => {
                 this.$store.commit('editCart', data.data)
            });
            this.$swal.fire({
                toast: true,
                position: 'top-end',
                icon: response.data.type,
                title: response.data.message,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            })
            this.loading = false;
        },
        cekHarga(detail){
            var rincian = this.product.rincian;
            var hasil = {};
            let result = 0;
            for( var value in detail){
                hasil[value] = detail[value] * rincian[value];
            }
            for(var key in hasil){
                result += hasil[key];
            }
            this.harga = this.product.harga * result;
        }
    }
}
</script>

<style>
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance:textfield;
}
</style>
