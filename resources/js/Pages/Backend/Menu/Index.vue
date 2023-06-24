<template>
    <AuthenticatedLayout>
        <Head title="Roles"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Roles"
                        icon="mdi-plus"
                        :router="{title:'Add New', route:'backend.menu.create'}"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Route</th>
                                <th>Permissions</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in menus.data" :key="index">
                                <td><v-icon :icon="item.icon"/> {{ item.title }}</td>
                                <td>
                                    <template v-if="item.parent">
                                        <v-icon :icon="item.parent.icon"/> {{ item.parent.title }}
                                    </template>
                                    <span v-else> N/A </span>
                                </td>
                                <td>{{ item.route??"N/A" }}</td>
                                <td class="w-25">
                                    <span v-if="item.permission">
                                        <v-badge class="my-1" :content="item.permission.name" color="green" inline></v-badge>
                                    </span>
                                    <div v-else>N/A</div>
                                </td>
                                <td class="text-center">
                                    <Link
                                        class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                        :href="route('backend.role.edit', item.id)">
                                        <i class="mdi-pencil mdi v-icon" aria-hidden="true"></i>
                                    </Link>

                                    <Delete :id="item.id" :routeName="'backend.role.destroy'"/>
                                </td>
                            </tr>
                            </tbody>
                        </v-table>

                        <v-divider></v-divider>
                        <Pagination class="mt-6" :items="menus"/>
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

const props = defineProps(['menus'])

</script>
