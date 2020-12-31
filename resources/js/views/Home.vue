<template>
<div>
    <div class="container">
        Ini halaman utama, {{ nama }}
        <v-form action="#" @submit.prevent="changeName">
        <v-text-field v-model="name"></v-text-field>
        <v-btn type="submit">Change Name</v-btn>
        </v-form>
        
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            name: ''
        }
    },
    computed: {
        nama(){
            return this.$store.state.name
        }
    },
    methods: {
         changeName(){
             this.$store.commit('changeName', this.name);
         }
    }
}
</script>
