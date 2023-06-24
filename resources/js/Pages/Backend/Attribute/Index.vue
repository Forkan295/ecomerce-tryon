<template>
    <AuthenticatedLayout>
        <Head title="Attributes"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Attributes"
                        :totalItem="items.total"
                        icon="mdi-plus"
                        :router="{title:'Add New', route:'backend.attributes.create', queryParam: $page.props.auth.tenant}"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                                <tr>
                                    <th>Title(EN)</th>
                                    <th>Title(BN)</th>
                                    <th>Slug</th>
                                    <th>Order</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in items.data" :key="index">
                                    <td>{{ item.title_en }}</td>
                                    <td>{{ item.title_bn }}</td>
                                    <td>{{ item.slug }}</td>
                                    <td>{{ item.order }}</td>
                                    <td>
                                        <Badge :status="item.status" />
                                    </td>
                                    <td class="text-center">
                                        <Link
                                            class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                            :href="route('backend.attributes.edit', [$page.props.auth.tenant, item.id])">
                                            <i class="mdi-pencil mdi v-icon" aria-hidden="true"></i>
                                        </Link>

                                        <Delete :id="item.id" :routeName="'backend.attributes.destroy'" :tenantName="$page.props.auth.tenant" />
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
