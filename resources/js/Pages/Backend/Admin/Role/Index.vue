<template>
    <AdminLayout>
        <Head title="Roles"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Roles"
                        icon="mdi-plus"
                        :router="{title:'Add New', route:'admin.role.create'}"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                            <tr>
                                <th>Display Name</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Permissions</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in roles.data" :key="index">
                                <td>{{ item.display_name }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.description ?? 'N/A' }}</td>
                                <td>
                                    <div v-if="item.permissions.length > 0" v-for="permission in item.permissions">
                                        <v-badge :content="permission.name" color="green" inline></v-badge>
                                    </div>
                                    <div v-else>N/A</div>
                                </td>
                                <td>
                                    <Badge :status="item.status" />
                                </td>
                                <td class="text-center">
                                    <Link
                                        class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                        :href="route('admin.role.edit', item.id)">
                                        <i class="mdi-pencil mdi v-icon" aria-hidden="true"></i>
                                    </Link>

                                    <Delete :id="item.id" :routeName="'admin.role.destroy'"/>
                                </td>
                            </tr>
                            </tbody>
                        </v-table>

                        <v-divider></v-divider>
                        <Pagination class="mt-6" :items="roles"/>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </AdminLayout>
</template>

<script setup>
    import Pagination from "@/Components/Common/Pagination.vue";
    import CardTitle from "@/Components/Common/CardTitle.vue";
    import Delete from "@/Components/Common/Delete.vue";
    import AdminLayout from '@/Layouts/AdminLayout.vue'
    import Badge from "@/Components/Common/Badge.vue";
    import {Link, Head} from '@inertiajs/vue3';

    const props = defineProps(['roles'])
</script>
