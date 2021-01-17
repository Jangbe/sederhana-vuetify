<template>
    <v-col cols="12">
        <stok-loader v-if="first"></stok-loader>
        <v-form action="#" method="post" role="form" @submit.prevent="add" lazy-validation v-else>
        <v-card :loading="loading">
            <v-row no-gutters>
                <v-col cols="12" md="4">
                    <v-img height="430" :src="input.gambar"></v-img>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card-title>
                        <v-icon left>mdi-view-dashboard</v-icon>
                        Detail Barang
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-text-field outlined readonly label="Id Barang" v-model="input.id"></v-text-field>
                        <v-text-field outlined readonly label="Nama Barang" v-model="input.nama"></v-text-field>
                        <v-text-field outlined readonly label="Stok Sisa" v-model="input.stok"></v-text-field>
                    </v-card-text>
                    <v-divider class="d-flex d-md-none"></v-divider>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card-title>
                        <v-icon left>mdi-plus-circle</v-icon>
                        Tambah Stok Barang
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text>
                        <template v-for="(v, k) in detail">
                            <v-text-field :key="k" outlined :label="k" v-model="input.detail[k]" type="number" min="0"></v-text-field>
                        </template>
                    </v-card-text>
                    <v-divider class="d-flex d-md-none"></v-divider>
                    <v-card-text>
                        <v-btn color="success" type="submit" text :disabled="loading">
                            <v-progress-circular indeterminate color="success" v-if="loading"></v-progress-circular>
                            <span v-else><v-icon left>mdi-plus-circle</v-icon>Tambah Stok</span>
                        </v-btn>
                    </v-card-text>
                </v-col>
            </v-row>
        </v-card>
        </v-form>
    </v-col>
</template>

<script>
import StokLoader from './StokLoader.vue';
export default {
    components: {'stok-loader': StokLoader},
    props: ['id_product'],
    data(){
        return{
            first: true,
            loading: false,
            hasErrors: {},
            notFound: false,
            detail: {},
            input: {
                id: '',
                nama: '',
                gambar: '',
                stok: '',
                detail: {}
            },
        }
    },
    mounted(){
        this.show();
    },
    watch: {
        id_product: function(){
            this.show();
        }
    },
    methods: {
        show(){
            axios.get(`/api/product/index/${this.id_product}/show`).then(res => {
                var input = res.data.data;
                this.detail = input.stok;
                this.input.id = input.id;
                this.input.nama = input.nama;
                this.input.gambar = input.link;
                this.input.stok = input.stok_kata;
                this.first = false;
            }).catch(e => {
                this.notFound = true;
            })
        },
        add(){
            var data = {
                id: this.input.id,
                detail: this.input.detail
            }
            this.loading = true;
            axios.post('/api/admin/add-stok', data).then(res => {
                this.$swal.fire({
                    toast: true,
                    showConfirmButton: false,
                    position: 'top-end',
                    icon: res.data.type,
                    title: res.data.message,
                    timer: 3000,
                    timerProgressBar: true
                })
                if (res.data.type == 'success') {
                    this.$router.push('/admin/add-stok');
                }
                this.loading = false;
            }).catch(e => {
                this.loading = false;
                this.hasErrors = e.response.data.errors
            })
        }
    }
}
</script>

<style>

</style>
