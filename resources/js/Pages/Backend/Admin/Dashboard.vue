<template>
    <AdminLayout>
        <Head title="Dashboard"/>
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="3">
                        <v-card color="#1F7087" theme="dark">
                            <div class="d-flex flex-no-wrap justify-space-between">
                                <div>
                                    <v-card-title class="text-h6 text-uppercase">
                                        Admin
                                    </v-card-title>

                                    <v-card-subtitle>Total</v-card-subtitle>

                                    <v-card-actions>
                                        <v-btn
                                            class="ms-2"
                                            variant="outlined"
                                            size="small"
                                            type="button"
                                        >
                                            <Link :href="route('admin.admins.index')" class="v-btn v-btn--variant-text">
                                                {{ totalAdmin }}
                                            </Link>
                                        </v-btn>
                                    </v-card-actions>
                                </div>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="3">
                        <v-card color="#1F7087" theme="dark">
                            <div class="d-flex flex-no-wrap justify-space-between">
                                <div>
                                    <v-card-title class="text-h6 text-uppercase">
                                        Clients
                                    </v-card-title>

                                    <v-card-subtitle>Total</v-card-subtitle>

                                    <v-card-actions>
                                        <v-btn
                                            class="ms-2"
                                            variant="outlined"
                                            size="small"
                                            type="button"
                                        >
                                            <Link :href="route('admin.admins.index')" class="v-btn v-btn--variant-text">
                                                {{ totalClient }}
                                            </Link>
                                        </v-btn>
                                    </v-card-actions>
                                </div>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="3">
                        <v-card color="#1F7087" theme="dark">
                            <div class="d-flex flex-no-wrap justify-space-between">
                                <div>
                                    <v-card-title class="text-h6 text-uppercase">
                                        Products
                                    </v-card-title>

                                    <v-card-subtitle>Total</v-card-subtitle>

                                    <v-card-actions>
                                        <v-btn
                                            class="ms-2"
                                            variant="outlined"
                                            size="small"
                                            type="button"
                                        >
                                            {{ totalProduct }}
                                        </v-btn>
                                    </v-card-actions>
                                </div>
                            </div>
                        </v-card>
                    </v-col>

                    <v-col cols="3">
                        <v-card color="#1F7087" theme="dark">
                            <div class="d-flex flex-no-wrap justify-space-between">
                                <div>
                                    <v-card-title class="text-h6 text-uppercase">
                                        Categories
                                    </v-card-title>

                                    <v-card-subtitle>Total</v-card-subtitle>

                                    <v-card-actions>
                                        <v-btn
                                            class="ms-2"
                                            variant="outlined"
                                            size="small"
                                            type="button"
                                        >
                                            {{ totalCategory }}
                                        </v-btn>
                                    </v-card-actions>
                                </div>
                            </div>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row class="mt-5">
                    <v-col cols="12" v-if="total.length > 0">
                        <div class="text-h6 text-center">Client wise product views</div>
                        <Apexchart
                            type="bar"
                            :options="state.options"
                            :series="state.series"
                        ></Apexchart>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </AdminLayout>
</template>

<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue'
    import { Head, Link } from '@inertiajs/vue3';
    import Apexchart from "vue3-apexcharts";

    import {reactive} from "vue";

    const props = defineProps({
       totalCategory: {
           type: Number,
       },
        totalProduct: {
           type: Number,
        },
        totalClient: {
           type: Number,
        },
        totalAdmin: {
           type: Number,
        },
        client: {
            type: Array,
        },
        total: {
            type: Array,
        }
    });

    const state = reactive({
        options: {
            labels: props.client,
        },
        series: [{
            name: '',
            data: props.total
        }],
    });
</script>
