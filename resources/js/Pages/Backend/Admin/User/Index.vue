<template>
    <AdminLayout>
        <Head title="Admins"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Admins"
                        icon="mdi-plus"
                        :router="{title:'Add New', route:'admin.admins.create'}"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in items.data" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.phone_number }}</td>
                                <td>
                                    <Badge :status="item.status"/>
                                </td>
                                <td class="text-center">
                                    <RouterLink
                                        router="admin.admins.edit"
                                        icon="mdi-pencil"
                                        :queryParam="item.id"
                                    />
                                    <Delete :id="item.id" :routeName="'admin.admins.destroy'"/>
                                </td>
                            </tr>
                            </tbody>
                        </v-table>
                        <v-divider></v-divider>
                        <Pagination class="mt-6" :items="items"/>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from "@/Components/Common/Pagination.vue";
import CardTitle from "@/Components/Common/CardTitle.vue";
import Delete from "@/Components/Common/Delete.vue";
import Badge from "@/Components/Common/Badge.vue";
import RouterLink from "@/Components/Common/RouterLink.vue";
import {Head} from '@inertiajs/vue3';

const props = defineProps(['items'])
</script>
