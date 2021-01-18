<template>
<v-container>
    <v-carousel hide-delimiters :interval="3000" cycle show-arrows-on-hover>
        <v-carousel-item v-for="(item,i) in 3" :key="i" :src="`/img/carousel/${i+1}.jpg`">

        </v-carousel-item>
    </v-carousel>
</v-container>
</template>

<script>
export default {
    data(){
        return {
        }
    },
}
</script>
