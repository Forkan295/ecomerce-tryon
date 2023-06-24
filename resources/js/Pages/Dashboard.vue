<template>
    <AuthenticatedLayout>
        <Head title="Dashboard"/>
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col cols="4">
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
                                            <Link :href="route('backend.categories.index', $page.props.auth.tenant)" class="v-btn v-btn--variant-text">
                                                {{ totalCategory }}
                                            </Link>
                                        </v-btn>
                                    </v-card-actions>
                                </div>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="4">
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
                                            <Link :href="route('backend.product.index', $page.props.auth.tenant)" class="v-btn v-btn--variant-text">
                                                {{ totalProduct }}
                                            </Link>
                                        </v-btn>
                                    </v-card-actions>
                                </div>
                            </div>
                        </v-card>
                    </v-col>
                    <v-col cols="4">
                        <v-card color="#1F7087" theme="dark">
                            <div class="d-flex flex-no-wrap justify-space-between">
                                <div>
                                    <v-card-title class="text-h6 text-uppercase">
                                        Orders
                                    </v-card-title>

                                    <v-card-subtitle>Total</v-card-subtitle>

                                    <v-card-actions>
                                        <v-btn
                                            class="ms-2"
                                            variant="outlined"
                                            size="small"
                                            type="button"
                                        >
                                            0
                                        </v-btn>
                                    </v-card-actions>
                                </div>
                            </div>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row class="mt-5">
                    <v-col cols="12" v-if="date.length > 0">
                        <div class="text-h6 text-center">Daily Product Views</div>
                        <Apexchart
                            type="bar"
                            :options="state.options"
                            :series="state.series"
                        ></Apexchart>
                    </v-col>

<!--                    <v-col cols="6">-->
<!--                        <div class="text-h6 text-center">Order Report</div>-->

<!--                        <Apexchart-->
<!--                            width="500" type="donut"-->
<!--                            :options="state.circleOptions"-->
<!--                            :series="state.circleSeries"-->
<!--                        ></Apexchart>-->
<!--                    </v-col>-->
                </v-row>
            </v-card-text>
        </v-card>

    </AuthenticatedLayout>
</template>

<script setup>
    import {reactive} from "vue";
    import { Head, Link } from '@inertiajs/vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import Apexchart from "vue3-apexcharts";

    const props = defineProps({
        totalProduct: {
          type: Number,
        },
        totalCategory: {
          type: Number,
        },
        date: {
            type: Array,
        },
        total: {
            type: Array,
        }
    });

    const state = reactive({
        options: {
            labels: props.date,
        },
        series: [{
            name: '',
            data: props.total
        }],

        circleOptions: {
            labels: ['Total Order', 'Total Order Delivery', 'Total Order Pending']
        },
        circleSeries: [500, 350, 150],
    });
</script>
