<template>
  <v-card>
    <v-row no-gutters>
        <v-col cols="12" md="4">
            <v-skeleton-loader type="image"></v-skeleton-loader>
            <v-skeleton-loader type="image"></v-skeleton-loader>
        </v-col>
        <v-col cols="12" md="4">
            <v-skeleton-loader class="my-5 ml-7" type="heading"></v-skeleton-loader>
            <v-divider></v-divider>
            <v-card-text>
                <v-skeleton-loader type="list-item"></v-skeleton-loader>
                <v-skeleton-loader type="list-item" class="mt-10"></v-skeleton-loader>
                <v-skeleton-loader type="list-item" class="mt-10"></v-skeleton-loader>
            </v-card-text>
            <v-divider class="d-flex d-md-none"></v-divider>
        </v-col>
        <v-col cols="12" md="4">
            <v-skeleton-loader class="my-5 ml-7" type="heading"></v-skeleton-loader>
            <v-divider></v-divider>
            <v-card-text>
                <v-skeleton-loader type="list-item"></v-skeleton-loader>
                <v-skeleton-loader type="list-item" class="mt-10"></v-skeleton-loader>
                <v-skeleton-loader type="list-item" class="mt-10"></v-skeleton-loader>
            </v-card-text>
            <v-divider class="d-flex d-md-none"></v-divider>
            <v-card-text>
                <v-skeleton-loader type="button"></v-skeleton-loader>
            </v-card-text>
        </v-col>
    </v-row>
</v-card>
</template>

<script>
export default {

}
</script>

<style>

</style>
