<template>
    <AuthenticatedLayout>
        <Head title="Site Setting"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Site Setting Groups"
                        icon="mdi-plus"
                        :router="{title:'Add New', route:'backend.groups.create'}"
                        :extraRoute="{title:'Back', route:'backend.settings.form'}"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in items.data" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.title }}</td>
                                    <td>{{ item.slug }}</td>
                                    <td>{{ item.order }}</td>
                                    <td>
                                        <Badge :status="item.status" />
                                    </td>
                                    <td class="text-center">
                                        <Link
                                            class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                            :href="route('backend.groups.edit', item.id)">
                                            <i class="mdi-pencil mdi v-icon" aria-hidden="true"></i>
                                        </Link>
                                        <Link
                                            class="v-btn mx-1 v-btn--elevated bg-blue-darken-1 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                            :href="route('backend.groups.form', item.id)">
                                            <i class="mdi-eye mdi v-icon" aria-hidden="true"></i>
                                        </Link>

                                        <Delete :id="item.id" :routeName="'backend.groups.destroy'" />
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
    import { Link,Head } from '@inertiajs/vue3';

    const props = defineProps(['items'])
</script>
