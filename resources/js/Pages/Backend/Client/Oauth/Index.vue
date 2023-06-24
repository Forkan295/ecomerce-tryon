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
                        :extra-route="{title:'profile',icon:'mdi-account',route:'backend.profile.index',queryParam:{tenant:$page.props.auth.tenant}}"
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
                                <td nowrap>
                                    <v-dialog
                                        open-delay="1000"
                                        v-model="data.isGenerate"
                                        transition="dialog-top-transition"
                                        width="auto"
                                    >
                                        <template v-slot:activator="{ props }">
                                            <v-btn
                                                class="v-btn mx-1 v-btn--elevated bg-green-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                                v-bind="props"
                                                @click="generateAccessToken(item)"
                                            ><i class="mdi-key-variant mdi v-icon" aria-hidden="true">
                                                <v-tooltip
                                                    activator="parent"
                                                    location="start"
                                                >Generate Access Token
                                                </v-tooltip>
                                            </i>
                                            </v-btn>
                                        </template>
                                        <template v-slot:default="{ props }" v-if="data.isGenerate">

                                            <v-card>
                                                <v-toolbar
                                                    color="primary"
                                                    title="Token Details"
                                                ></v-toolbar>
                                                <v-card-item>
                                                    <div class="description" v-if="data.isCheckingAuthorization"
                                                         v-html="data.tokenDetails"></div>
                                                    <div class="pa-12" v-else>
                                                        <div class="text-h6 mb-1">
                                                            Expired at
                                                        </div>
                                                        <div class="text-caption"> {{
                                                                data.tokenDetails ? getDate(data.tokenDetails.expires_in) : "Please wait"
                                                            }}
                                                        </div>
                                                        <v-divider class="my-5"/>

                                                        <div class="text-h6 mb-1">
                                                            Access Token
                                                        </div>
                                                        <div class="text-caption"> {{
                                                                data.tokenDetails ? data.tokenDetails.access_token : "Please wait"
                                                            }}
                                                            <br>
                                                            <v-btn @click="copyText('access_token')"
                                                                   icon="mdi-content-copy"></v-btn>
                                                        </div>
                                                        <v-divider class="my-5"/>
                                                        <div class="text-h6 mb-1">
                                                            Refresh Token
                                                        </div>
                                                        <div class="text-caption"> {{
                                                                data.tokenDetails ? data.tokenDetails.refresh_token : "Please wait"
                                                            }}
                                                            <br>
                                                            <v-btn @click="copyText('refresh_token')"
                                                                   icon="mdi-content-copy"></v-btn>
                                                        </div>
                                                    </div>
                                                </v-card-item>
                                                <v-card-text>
                                                    <v-alert
                                                        v-model="data.alert"
                                                        border="start"
                                                        variant="tonal"
                                                        density="compact"
                                                        closable
                                                        icon="mdi-alert"
                                                        close-label="Close Alert"
                                                        color="deep-orange-accent-4"
                                                        title="Caution"
                                                    >
                                                        Copy access token and refresh token before close the dialog.
                                                        If you forget your tokens, there is no direct way to retrieve them.
                                                    </v-alert>
                                                </v-card-text>

                                                <v-card-text>
                                                    <v-alert
                                                        v-model="data.alert"
                                                        border="start"
                                                        variant="tonal"
                                                        density="compact"
                                                        closable
                                                        icon="mdi-information-slab-circle-outline "
                                                        close-label="Close Alert"
                                                        color="deep-purple-accent-4"
                                                        title="Info"
                                                    >
                                                        If you forgets your OAuth access token, you can
                                                        revoke it by accessing the revocation endpoint in token list.
                                                    </v-alert>
                                                </v-card-text>
                                                <v-card-actions class="justify-end">
                                                    <v-btn
                                                        variant="text"
                                                        @click="data.isGenerate = false; data.alert=true"
                                                    >Close
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </template>
                                    </v-dialog>
                                    <Link
                                        class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated"
                                        :href="route('backend.oauth.getToken',{tenant:$page.props.auth.tenant,clientID:item.id})">
                                        <i class="mdi-hand-coin mdi v-icon" aria-hidden="true">
                                            <v-tooltip
                                                activator="parent"
                                                location="start"
                                            >Tokens
                                            </v-tooltip>
                                        </i>
                                    </Link>
                                    <Delete :id="item.id" :routeName="'backend.client.delete'" :tenantName="$page.props.auth.tenant" />
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
import CardTitle from "@/Components/Common/CardTitle.vue";
import Delete from "@/Components/Common/Delete.vue";
import {Head, Link, usePage} from '@inertiajs/vue3';
import {reactive} from "vue";

const props = defineProps(['user', 'clients'])
const data = reactive({
    tokenDetails: null,
    isGenerate: false,
    isCheckingAuthorization: false,
    alert: true,
})

function getSecret(index, clientId) {
    console.log(usePage().props.auth.tenant)
    axios
        .get(route('backend.client.get-secret', {tenant: usePage().props.auth.tenant, id: clientId}))
        .then(response => (
            console.log(response.data),
                props.clients[index].secret = response.data !== '' ? response.data : "PKCE doesn't contain secret key"
        ))
}

function generateAccessToken(item) {
    axios
        .get(route('backend.oauth.authorize', item))
        .then(response => {
            console.log(response.data);
            if (!response.data.access_token) {
                data.isCheckingAuthorization = true
            }
            data.tokenDetails = response.data;
            data.isGenerate = true
        })
}

function copyText(tokenType) {
    const text = data.tokenDetails[tokenType];
    console.log(text)
    navigator.clipboard.writeText(text);
}

function getDate(milisec) {
    let asiaDhaka = new Date().toLocaleString([], {timeZone: "Asia/Dhaka"})
    let date = new Date(asiaDhaka);
    let days = milisec / 86400;
    date.setDate(date.getDate() + days);
    return date;
}

</script>
