<template>
  <v-row>
    <v-col cols="12" md="8" class="mt-6">
        <v-skeleton-loader type="text" class="mt-1"></v-skeleton-loader>
        <v-list class="mt-3">
            <v-card>
                <v-list-item>
                    <v-list-item-title class="d-flex justify-space-between">
                        <v-skeleton-loader type="text" width="120"></v-skeleton-loader>
                        <v-skeleton-loader type="text" width="50"></v-skeleton-loader>
                    </v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item v-for="i in 10" :key="i">
                    <v-list-item-title class="d-flex justify-space-between my-2">
                        <v-skeleton-loader type="text" class="my-auto" width="170"></v-skeleton-loader>
                        <div class="d-flex float-left">
                            <v-skeleton-loader class="d-flex mr-2" type="table-cell@3" width="200"></v-skeleton-loader>
                            <v-skeleton-loader type="avatar"></v-skeleton-loader>
                        </div>
                    </v-list-item-title>
                </v-list-item>
            </v-card>
        </v-list>
    </v-col>
    <v-col cols="12" md="4" class="mt-6">
        <v-skeleton-loader type="text"></v-skeleton-loader>
        <v-skeleton-loader type="button@6" class="mt-5 d-flex"></v-skeleton-loader>
        <v-list class="mt-3">
            <v-card>
                <v-list-item>
                    <v-list-item-title>
                        <v-skeleton-loader type="heading"></v-skeleton-loader>
                    </v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                    <v-list-item-title>
                        <v-skeleton-loader class="mx-auto" type="text" width="200"></v-skeleton-loader>
                    </v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                    <v-list-item-title>
                        <v-skeleton-loader type="text" width="200"></v-skeleton-loader>
                    </v-list-item-title>
                </v-list-item>
            </v-card>
        </v-list>
    </v-col>
</v-row>
</template>

<script>
export default {

}
</script>

<style>

</style>
