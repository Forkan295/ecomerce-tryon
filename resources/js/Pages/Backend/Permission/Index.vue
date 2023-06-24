<template>
    <AuthenticatedLayout>
        <Head title="Permissions"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Permissions"
                        icon="mdi-plus"
                        :router="{title:'Add New', route:'backend.permission.create'}"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                            <tr>
                                <th>Display Name</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Parent</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in permissions.data" :key="index">
                                <td>{{ item.display_name }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.description??'N/A' }}</td>
                                <td>{{ item.parent ? item.parent.display_name:"N/A" }}</td>
                                <td>
                                    <Badge :status="item.status"/>
                                </td>
                                <td class="text-center">
                                    <Link
                                        class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                        :href="route('backend.permission.edit', item.id)">
                                        <i class="mdi-pencil mdi v-icon" aria-hidden="true"></i>
                                    </Link>

                                    <Delete :id="item.id" :routeName="'backend.permission.destroy'"/>
                                </td>
                            </tr>
                            </tbody>
                        </v-table>

                        <v-divider></v-divider>
                        <Pagination class="mt-6" :items="permissions"/>
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
import {Link, Head} from '@inertiajs/vue3';

const props = defineProps(['permissions'])
</script>
