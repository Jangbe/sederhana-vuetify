<template>
  <v-card>
        <v-row no-gutters>
            <v-col cols="12" md="5">
                <v-skeleton-loader type="image"></v-skeleton-loader>
                <v-skeleton-loader type="image"></v-skeleton-loader>
            </v-col>
            <v-col cols="12" md="7">
                <v-card-title>
                    <v-skeleton-loader type="chip"></v-skeleton-loader>
                    <v-spacer></v-spacer>
                    <v-skeleton-loader type="chip"></v-skeleton-loader>
                </v-card-title>
                <v-card-text>
                    <v-row align="center" class="mx-0" >
                        <v-skeleton-loader type="text"></v-skeleton-loader>

                        <v-skeleton-loader type="text" class="mt-2"></v-skeleton-loader>
                    </v-row>

                    <div class="my-4 subtitle-1">
                        <v-skeleton-loader type="text"></v-skeleton-loader>
                    </div>
                </v-card-text>

                <v-divider class="mt-2"></v-divider>

                <v-card-text class="mt-2">
                    <v-row dense>
                        <v-col cols="12">
                            <v-skeleton-loader type="table-row"></v-skeleton-loader>
                        </v-col>
                    </v-row>
                </v-card-text>

                <v-card-actions>
                <v-skeleton-loader type="button" class="mt-1 col-6"></v-skeleton-loader>
                </v-card-actions>
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
