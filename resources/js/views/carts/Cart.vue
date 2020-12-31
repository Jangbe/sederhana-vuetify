<template>
<div>
    <v-container class="mt-3">
        <v-row>
            <v-col cols="12" md="3">
                <cart></cart>
            </v-col>
            <v-col cols="12" md="9">
                <v-form v-if="carts.count > 0" action="#" method="post" @submit.prevent="store" lazy-validation>
                    <v-row dense>
                        <v-col cols="12" md="6">
                            <v-text-field @focus="hasErrors.nama = ''" outlined v-model="input.nama" :error-messages="hasErrors.nama" label="nama" color="cyan" :counter="11"></v-text-field>
                            <v-text-field @focus="hasErrors.email = ''" outlined v-model="input.email" :error-messages="hasErrors.email" color="cyan" label="email" type="email"></v-text-field>
                            <v-text-field @focus="hasErrors.notel = ''" outlined v-model="input.notel" :error-messages="hasErrors.notel" color="cyan" label="No Telepon" type="number" :counter="13" min="0"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6" class="border-left">
                            <v-text-field @focus="hasErrors.alamat = ''" outlined v-model="input.alamat" :error-messages="hasErrors.alamat" color="cyan" label="Alamat"></v-text-field>
                            <v-select @focus="hasErrors.metode = ''" outlined v-model="input.metode" :error-messages="hasErrors.metode" color="cyan" :items="metode" :item-text="metode.text" :item-value="metode.value" label="Metode"></v-select>
                            <v-textarea outlined v-model="input.catatan" label="Catatan"></v-textarea>
                        </v-col>
                    </v-row>
                    <div class="form-group">
                        <div class="input-group mt-3 mt-md-3" id="btn-kirim">
                            <!-- <div class="card col-12 mb-3 border-info text-info text-center mt-1">
                                <div class="card-body py-2">Total item : <span id="total-item">{{}}</span> | Total berat : <span id="total-berat">{{$jumlah_berat}} kg</span> <br> Ongkir : <span id="ongkir"></span> | Total harga : Rp. <span id="total-harga">{{number_format($total_harga)}}</span></div>
                            </div> -->
                            <v-btn color="success" outlined class="col-12 text-center" type="submit">Kirim ke keranjang</v-btn>
                        </div>
                    </div>
                </v-form>
                <v-alert v-else class="text-center" color="warning" outlined>
                    <span class="text-center">Keranjang masih kosong, silahkan pilih dulu barang jika ingin berbelanja</span>
                </v-alert>
                <v-alert class="text-white mt-3" color="cyan" outlined>
                    <v-card-title class="text-white h5 text-center">Cek Status Transaksi</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <span>
                            Apabila anda sudah melakukan pembayaran, dan ingin mengetahui barang yang anda beli sudah dikirim atau belum, silahkan cek status pengiriman dibawah ini dengan No Pesanan yang diberikan sewaktu belanja.
                        </span>
                    </v-card-text>
                </v-alert>
            </v-col>
        </v-row>
    </v-container>
</div>
</template>

<script>
import cart from '../../components/Cart';
import number_format from '../../number_format';
export default {
    data(){
        return{
            isThere: false,
            input: {
                nama: '',
                email: '',
                notel: '',
                catatan: '',
                alamat: '',
                metode: '',
            },
            hasErrors: {},
            isLogin: false,
            number_format,
            metode: [
                {text: 'Di Jemput Sendiri', value: 1},
                {text: 'Bank BRI', value: 2},
                {text: 'Bank BNI', value: 3},
                {text: 'Bank BCA', value: 4},
                {text: 'Bank Mandiri', value: 5},
            ],
        }
    },
    mounted(){
        this.getUser();
        this.init();
    },
    computed: {
        carts(){
           return this.$store.state.carts
        }
    },
    methods:{
        init(){
           this.number_format = number_format;
        },
        getUser(){
            axios.get('/api/auth/init').then(user => {
                this.user = user.data.user;
                this.isLogin = user.data.isLogin;
                if (this.isLogin) {
                    this.input.nama = this.user.name;
                    this.input.email = this.user.email;
                    this.input.notel = this.user.telepon;
                }else{
                    this.input.nama = '';
                    this.input.email = '';
                    this.input.notel = '';
                }
            });
        },

        async store(){
            try{
                this.input.carts = this.carts;
                let respon = await axios.patch('/api/keranjang/store', this.input);
                this.hasErrors = [];
                this.input.nama = '';
                this.input.email = '';
                this.input.notel = '';
                this.input.alamat = '';
                this.input.catatan = '';
                this.input.metode = '';
                this.$swal.fire({
                  title: '<strong>Barang berhasil dikonfirmasi</strong>',
                  icon: respon.data.type,
                  html: respon.data.message,
focusConfirm: false,
confirmButtonText:
'<i class="fa fa-thumbs-up"></i> Confirm!',
confirmButtonAriaLabel: 'Thumbs up, great!',
})
                this.$router.push('/belanja');
            }catch(e){
                this.hasErrors = e.response.data.errors;
            }
        }
    }
}
</script>

<style>

</style>
