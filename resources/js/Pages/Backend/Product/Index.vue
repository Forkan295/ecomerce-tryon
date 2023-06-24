<template>
    <AuthenticatedLayout>
        <Head title="Products" />
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Product List"
                        :totalItem="items.total"
                        icon="mdi-plus"
                        :router="{
                            title: 'Add New',
                            route: 'backend.product.create',
                            queryParam: $page.props.auth.tenant
                        }"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                                <tr>
                                    <th class="text-left">Title(EN)</th>
                                    <th class="text-left">Title(BN)</th>
                                    <th class="text-left">SKU</th>
                                    <th class="text-left">Cost Price</th>
                                    <th class="text-left">Sales Price</th>
                                    <th class="text-left">Compare Price</th>
                                    <th class="text-left">Order</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in items.data" :key="index">
                                    <td>{{ item.title_en }}</td>
                                    <td>{{ item.title_bn }}</td>
                                    <td>{{ item.sku }}</td>
                                    <td>{{ item.cost_price }}</td>
                                    <td>{{ item.sales_price }}</td>
                                    <td>{{ item.compare_price }}</td>
                                    <td>{{ item.order }}</td>
                                    <td>
                                        <Badge :status="item.status" />
                                    </td>
                                    <td class="text-center">
                                        <Link
                                            class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                            :href="route('backend.product.edit', [$page.props.auth.tenant, item.id])">
                                            <i class="mdi-pencil mdi v-icon" aria-hidden="true"></i>
                                        </Link>

                                        <Delete :id="item.id" :routeName="'backend.product.delete'" :tenantName="$page.props.auth.tenant"/>
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>

                        <v-divider></v-divider>
                        <Pagination class="mt-6" :items="items" />
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import Pagination from "@/Components/Common/Pagination.vue";
    import CardTitle from "@/Components/Common/CardTitle.vue";
    import Delete from "@/Components/Common/Delete.vue";
    import Badge from "@/Components/Common/Badge.vue";
    import { Link, Head } from '@inertiajs/vue3';

    const props = defineProps(['items'])
</script>
