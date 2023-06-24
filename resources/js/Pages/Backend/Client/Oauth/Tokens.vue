<template>
    <AdminLayout>
        <Head title="User"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Tokens"
                        :totalItem="tokens.length"
                        icon="mdi-arrow-left"
                        :router="{title:'Back', route:'backend.client.index' , queryParam:{tenant:$page.props.auth.tenant}}"
                    />

                    <v-card-text>
                        <v-table>
                            <thead>
                            <tr>
                                <th>Token ID</th>
                                <th>Name</th>
                                <th>Scopes</th>
                                <th>Expire At</th>
                                <th class="text-center">Revoke</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in tokens" :key="index">
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td width="350">
                                    {{ item.scopes}}
                                </td>
                                <td>{{ item.expires_at }}</td>
                                <td>
                                    <Link
                                        class="v-btn mx-1 v-btn--elevated bg-red-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                        :href="route('backend.oauth.revoke',item.id)">
                                        <i class="mdi-sync-off mdi v-icon" aria-hidden="true">
                                            <v-tooltip
                                                activator="parent"
                                                location="start"
                                            >Revoke</v-tooltip>
                                        </i>
                                    </Link>
                                </td>
                            </tr>
                            </tbody>
                        </v-table>

                        <v-divider></v-divider>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AuthenticatedLayout.vue'
import Pagination from "@/Components/Common/Pagination.vue";
import CardTitle from "@/Components/Common/CardTitle.vue";
import Delete from "@/Components/Common/Delete.vue";
import Badge from "@/Components/Common/Badge.vue";
import {Link, Head, usePage} from '@inertiajs/vue3';

const props = defineProps(['tokens'])

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
