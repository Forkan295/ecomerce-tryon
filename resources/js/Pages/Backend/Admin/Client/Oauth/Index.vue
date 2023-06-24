<template>
    <AdminLayout>
        <Head title="User"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Clients"
                        :totalItem="clients.length"
                        icon="mdi-plus"
                        :router="{title:'Add New', route:'backend.client.create' , queryParam:{tenant:$page.props.auth.tenant}}"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Client ID</th>
                                <th>Client Secret</th>
                                <th>Redirect Url</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in clients" :key="index">
                                <td>{{ item.name }}</td>
                                <td>{{ item.id }}</td>
                                <td width="350">
                                    <v-badge :content="item.secret??'*****************'"
                                             @click="getSecret(index,item.id)" hint="asdf"></v-badge>
                                </td>
                                <td>{{ item.redirect }}</td>
                                <!--                                    <td>{{ item.phone_number }}</td>-->
                                <!--                                    <td>{{ item.address }}</td>-->
                                <!--                                    <td>-->
                                <!--                                        <Badge :status="item.status" />-->
                                <!--                                    </td>-->
                                <!--                                    <td class="text-center">-->
                                <!--                                        <Link-->
                                <!--                                            class="v-btn mx-1 v-btn&#45;&#45;elevated bg-blue-darken-3 v-btn&#45;&#45;icon v-theme&#45;&#45;light v-btn&#45;&#45;density-comfortable v-btn&#45;&#45;size-default v-btn&#45;&#45;variant-elevated"-->
                                <!--                                            :href="route('admin.users.edit', item.id)">-->
                                <!--                                            <i class="mdi-pencil mdi v-icon" aria-hidden="true"></i>-->
                                <!--                                        </Link>-->
                                <!--                                        <Delete :id="item.id" :routeName="'admin.users.destroy'" />-->
                                <!--                                    </td>-->
                            </tr>
                            </tbody>
                        </v-table>

                        <v-divider></v-divider>
                        <!--                        <Pagination class="mt-6" :items="items" />-->
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
import {Link, Head, usePage} from '@inertiajs/vue3';

const props = defineProps(['user', 'clients'])

function getSecret(index, clientId) {
    console.log(usePage().props.auth.tenant)
    axios
        .get(route('backend.client.get-secret', {tenant: usePage().props.auth.tenant, id: clientId}))
        .then(response => (
            console.log(response.data),
                props.clients[index].secret = response.data !== '' ? response.data : "PKCE doesn't contain secret key"
        ))
}
</script>
