<template>
<v-container class="mt-1">
<v-row>
    <v-col cols="12">
        <v-dialog v-model="dialog" persistent max-width="650px">
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="success" dark v-bind="attrs" v-on="on">
            Tambah Kategori
            </v-btn>
        </template>
        <v-form methods="post" action="#" @submit.prevent="add()">
        <v-card>
            <v-card-title>
            <span class="headline">Tambah Kategori</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container>
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-text-field outlined autocomplete="false" type="text" v-model="form.nama" label="Nama Kategori" :error-messages="hasErrors.nama" @focus="hasErrors.nama = ''"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field outlined type="number" min="1" max="6" v-model="form.jumlah" label="Detail Kategori" @keyup="detail()" @change="detail()" :error-messages="hasErrors.jumlah" @focus="hasErrors.jumlah = ''"></v-text-field>
                        </v-col>
                        <v-col cols="12" v-for="(i, k) in form.detail" :key="k">
                            <v-text-field outlined class="col-12" :label="`Detail ke-${k+1}`" type="text" v-model="form.detail[k]" :rules="rules"> </v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="error" text @click="dialog = false">Close</v-btn>
            <v-btn color="success" text type="submit">Save</v-btn>
            </v-card-actions>
        </v-card>
        </v-form>
        </v-dialog>
        <!-- Untuk Edit -->
        <v-dialog v-model="dialog_edit" persistent max-width="650px">
        <v-form methods="post" action="#" @submit.prevent="store()">
        <v-card>
            <v-card-title>
            <span class="headline">Edit Kategori</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container>
                    <v-row no-gutters>
                        <v-col cols="12">
                            <v-text-field outlined autocomplete="false" type="text" v-model="form.nama" label="Nama Kategori" :error-messages="hasErrors.nama" @focus="hasErrors.nama = ''"></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field outlined type="number" min="1" max="6" v-model="form.jumlah" label="Detail Kategori" @keyup="detail()" @change="detail()" :error-messages="hasErrors.jumlah" @focus="hasErrors.jumlah = ''"></v-text-field>
                        </v-col>
                        <v-col cols="12" v-for="(i, k) in form.detail" :key="k">
                            <v-text-field outlined class="col-12" :label="`Detail ke-${k+1}`" type="text" v-model="form.detail[k]" :rules="rules"> </v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="error" text @click="close()">Cancel</v-btn>
            <v-btn color="success" text type="submit">Ubah</v-btn>
            </v-card-actions>
        </v-card>
        </v-form>
        </v-dialog>
    </v-col>
    <v-col cols="12">
        <v-list>
            <v-list-item-group>
                <v-card>
                    <v-list-item class="cyan">
                        <v-list-item-content>
                            <v-row class="white--text">
                                <v-col cols="1">#</v-col>
                                <v-col cols="3">Nama</v-col>
                                <v-col cols="3" class="d-none d-md-flex">Slug</v-col>
                                <v-col cols="5" md="3">Detail</v-col>
                                <v-col cols="3" md="2">Aksi</v-col>
                            </v-row>
                        </v-list-item-content>
                    </v-list-item>
                    <template v-for="(category, k) in categories">
                        <v-divider :key="k+'d'"></v-divider>
                        <v-list-item :key="k" inactive>
                            <v-list-item-content>
                                <v-row no-gutters>
                                    <v-col cols="1" v-text="k+1"></v-col>
                                    <v-col cols="3" v-text="category.nama_kategori"></v-col>
                                    <v-col cols="3" class="d-none d-md-flex" v-text="category.slug"></v-col>
                                    <v-col cols="5" md="3" v-text="category.detail_nama"></v-col>
                                    <v-col cols="3" md="2">
                                        <v-btn small text color="warning" @click="edit(category.id)"><v-icon left>mdi-square-edit-outline</v-icon>Edit</v-btn>
                                        <v-btn small text color="error" @click="hapus(category.id)"><v-icon left>mdi-delete</v-icon>Hapus</v-btn>
                                    </v-col>
                                </v-row>
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                </v-card>
            </v-list-item-group>
        </v-list>
    </v-col>
</v-row>
</v-container>
</template>

<script>
import Cart from '../../components/Cart.vue';
import number_format from '../../number_format';
export default {
    data(){
        return {
            number_format,
            dialog: false,
            dialog_edit: false,
            form: {
                nama: '',
                jumlah: 1,
                detail: [''],
            },
            id: 0,
            hasErrors: {},
            rules: [
                v => !!v || 'Detail is required'
            ],
        }
    },
    computed: {
        categories(){
            return this.$store.state.categories;
        }
    },
    mounted(){
        this.number_format = number_format;
    },
    methods: {
        detail(){
            let a = this.form.jumlah;
            this.form.detail = ['']
            for(let i = 1; i < a; i++){
                this.form.detail[i] = ''
            }
        },
        async add(){
            try{
                var response = await axios.post('/api/admin/category', this.form)
                axios.get('/api/kategori/index').then(data => {
                    this.$store.commit('category', data.data);
                })
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: response.data.type,
                    title: response.data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                })
                this.dialog = false;
                this.form.nama = '';
                this.form.jumlah = 1;
                this.form.detail = [''];
            }catch(e){
                this.hasErrors = e.response.data.errors;
            }
        },
        edit(id){
            axios.get(`/api/kategori/show/${id}`).then(data => {
                this.form.nama = data.data.nama;
                this.form.jumlah = data.data.jumlah;
                this.form.detail = data.data.detail;
                this.id = data.data.id;
            });
            this.dialog_edit = true;
        },
        store(){
            this.form.id = this.id;
            axios.post('/api/kategori/edit', this.form).then(data => {
                this.$swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: data.data.type,
                    title: data.data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                })
            });
            axios.get('/api/kategori/index').then(data => {
                this.$store.commit('category', data.data);
            })
            this.dialog_edit = false
        },
        close(){
            this.dialog_edit = false;
            this.form.nama = '';
            this.form.jumlah = 1;
            this.form.detail = [''];
            this.id = 0;
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
                axios.post(`/api/kategori/delete/`, {id: id}).then((respon) => {
                    axios.get('/api/kategori/index').then(data => {
                        this.$store.commit('category', data.data);
                    })
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
                }
            })
        }
    }
}
</script>

<style>

</style>
