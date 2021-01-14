<template>
<v-container>
<v-row>
    <v-col cols="12" md="8">
        <v-text-field type="text" v-model="word" @keyup="search" hide-details="" placeholder="cari nama barang..." class="mb-3"></v-text-field>
        <v-list class="list-group mb-2 barang">
            <v-card>
                <v-list-item-group>
                    <v-list-item class="cyan">
                        <v-list-item-title class="d-flex justify-space-between white--text">
                            Nama Barang
                            <span>Opsi</span>
                        </v-list-item-title>
                    </v-list-item>
                    <template v-for="(product, k) in products">
                        <v-list-item  :key="product.id" inactive>
                            <v-list-item-title class="d-flex justify-space-between col-md-5 col-3">
                                <span class="d-md-inline-block d-none" v-text="product.nama"></span>
                                <span class="d-sm-inline-block d-md-none" v-text="product.singkatan"></span>
                            </v-list-item-title>
                            <v-list-item-action>
                                <form action="#" method="post" @submit.prevent="cart(product.id)">
                                    <v-btn class="float-right ml-2" small fab depressed color="cyan" type="submit"><v-icon color="white">mdi-plus</v-icon></v-btn>
                                        <v-text-field v-for="(value, name) in product.stok" :key="name"
                                            type="number" min="0"
                                            class="col-3 float-right"
                                            outlined dense hide-details=""
                                            v-model="form[product.id]['detail'][name]"
                                            :label="name"></v-text-field>
                                </form>
                            </v-list-item-action>
                        </v-list-item>
                        <v-divider :key="k"></v-divider>
                    </template>
                </v-list-item-group>
            </v-card>
        </v-list>
        <v-pagination v-model="page" :length="meta.last_page"></v-pagination>
    </v-col>
    <v-col cols="12" md="4" class="mb-4">
        <form action="#" method="post" @submit.prevent="make">
            <v-text-field type="text" minlength="5" label="Nama" @focus="hasError = ''" :error-messages="hasError" maxlength="20" v-model="nama.nama" placeholder="Nama..."></v-text-field>
            <v-btn color="success" type="submit" class="mb-5 col-12">Tambahkan</v-btn>
        </form>
        <cart></cart>
    </v-col>
</v-row>
</v-container>
</template>

<script>
import Cart from '../../components/Cart.vue';
import number_format from '../../number_format';
export default {
    props: ['page'],
    data(){
        return {
            products: {},
            form: {},
            number_format,
            link: {},
            meta: {},
            word: '',
            nama: {
                nama: ''
            },
            hasError: ''
        }
    },
    beforeCreate(){
        axios.get('/api/auth/init').then(data => {
            if(!data.data.isAdmin){
                this.$router.push('/auth/signin');
            }
        })
    },
    mounted(){
        this.getProducts();
    },
    watch: {
        page: function(){
            this.getProducts(this.page);
        }
    },
    methods: {
        async getProducts(page = this.page){
            var data = await axios.get(`/api/admin/struct?page=${page}`)
            this.products = data.data.data;
            for(var i in this.products){
                this.form[this.products[i].id] = { id: '', detail: {},};
            }
            this.link = data.data.links;
            this.meta = data.data.meta;
            this.number_format = number_format;
        },
        async cart(id){
            this.form[id].id = id;
            var response = await axios.post('/api/keranjang/make', this.form[id]);
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
            });
        },
        search(){
            axios.get(`/api/admin/struct/${this.word}`).then(data => {
                this.products = data.data.data;
                for(var i in this.products){
                    this.form[this.products[i].id] = { id: '', detail: {},};
                }
                this.link = data.data.links;
                this.meta = data.data.meta;
            });
        },
        async make(){
            try{
                var response = await axios.post('/api/admin/make', this.nama);
                this.hasError = '';
                this.nama.nama = '';
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: response.data.type,
                    title: response.data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                axios.get('/api/keranjang/get').then(data => {
                    this.$store.commit('editCart', data.data)
                });
            }catch(e){
                this.hasError = e.response.data.errors.nama[0];
            }
        }
    }
}
</script>

<style>

</style>
