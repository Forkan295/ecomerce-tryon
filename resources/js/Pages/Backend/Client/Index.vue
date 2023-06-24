<template>
    <AdminLayout>
        <Head title="User"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Clients"
                        :totalItem="items.total"
                        icon="mdi-plus"
                        :router="{title:'Add New', route:'admin.users.create'}"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in items.data" :key="index">
                                    <td>{{ item.name }}</td>
                                    <td>{{ item.email }}</td>
                                    <td>{{ item.phone_number }}</td>
                                    <td>{{ item.address }}</td>
                                    <td>
                                        <Badge :status="item.status" />
                                    </td>
                                    <td class="text-center">
                                        <Link
                                            class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                            :href="route('admin.users.edit', item.id)">
                                            <i class="mdi-pencil mdi v-icon" aria-hidden="true"></i>
                                        </Link>
                                        <Delete :id="item.id" :routeName="'admin.users.destroy'" />
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
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from "@/Components/Common/Pagination.vue";
import CardTitle from "@/Components/Common/CardTitle.vue";
import Delete from "@/Components/Common/Delete.vue";
import Badge from "@/Components/Common/Badge.vue";
import {Link, Head} from '@inertiajs/vue3';

const props = defineProps(['items'])
</script>
