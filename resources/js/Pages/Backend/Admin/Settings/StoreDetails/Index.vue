<template>
    <AdminLayout>
        <Head title="Client Setting"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-row>
                    <v-col cols="2">
                        <SettingsMenu />
                    </v-col>

                    <v-col cols="10">
                        <v-card>
                            <CardTitle
                                title="Setting List"
                                icon="mdi-plus"
                                :router="{title:'Add New', route:'admin.store-detail.create'}"
                            />

                            <v-card-text>
                                <v-table>
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Logo</th>
                                        <th>Client Name</th>
                                        <th>Store Name</th>
                                        <th>Phone Number</th>
                                        <th>Slogan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item, index) in items.data" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <v-img v-if="item.logo" :src="item.logo" :width="60" :height="60" />
                                            <p v-else>N/A</p>
                                        </td>
                                        <td>{{ item.user.name }}</td>
                                        <td>{{ item.store_name }}</td>
                                        <td>{{ item.phone_number }}</td>
                                        <td>{{ item.slogan ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <Link
                                                class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                                :href="route('admin.store-detail.edit', item.id)">
                                                <i class="mdi-pencil mdi v-icon" aria-hidden="true"></i>
                                            </Link>

                                            <Delete :id="item.id" :routeName="'admin.store-details.destroy'" />
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
            </v-col>
        </v-row>
    </AdminLayout>
</template>

<script setup>
    import SettingsMenu from "@/Components/Layouts/Admin/SettingsMenu.vue";
    import Pagination from "@/Components/Common/Pagination.vue";
    import CardTitle from "@/Components/Common/CardTitle.vue";
    import AdminLayout from '@/Layouts/AdminLayout.vue'
    import Delete from "@/Components/Common/Delete.vue";
    import { Link,Head } from '@inertiajs/vue3';

    const props = defineProps(['items'])
    console.log(props.items)
</script>
