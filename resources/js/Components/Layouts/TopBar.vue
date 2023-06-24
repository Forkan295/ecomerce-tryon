<template>
    <v-app-bar density="comfortable">
        <v-app-bar-nav-icon />
<!--        <v-autocomplete-->
<!--            v-model="select"-->
<!--            v-model:search="search"-->
<!--            :loading="loading"-->
<!--            :items="items"-->
<!--            class=" mx-auto"-->
<!--            density="compact"-->
<!--            hide-no-data-->
<!--            hide-details-->
<!--            label="Search"-->
<!--            style="max-width: 400px;"-->
<!--        ></v-autocomplete>-->

        <v-spacer class="pa-0"></v-spacer>


        <!--        <v-tabs-->
        <!--            centered-->
        <!--            color="grey-darken-2"-->
        <!--        >-->
        <!--            <v-tab-->
        <!--                v-for="link in state.links"-->
        <!--                :key="link"-->
        <!--            >-->
        <!--                {{ link }}-->
        <!--            </v-tab>-->
        <!--        </v-tabs>-->



        <div class="text-center mr-3">
            <v-menu
                v-model="state.menu"
                open-on-hover
                transition="slide-y-transition"
            >
                <template v-slot:activator="{ props }">
                    <div v-bind="props">
                        <v-avatar color="info">
                            <v-icon icon="mdi-account-circle"></v-icon>
                        </v-avatar>
                    </div>
                </template>

                <v-card min-width="250">
                    <v-list>
                        <v-list-item
                            prepend-avatar="https://cdn.vuetifyjs.com/images/john.jpg"
                            :title="$page.props.auth.user.name"
                            :subtitle="$page.props.auth.user.name"
                        >
                        </v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                    <v-list>
                        <v-list-item>
                            <Link v-if="!$page.props.auth.is_admin" class="v-btn v-theme--light
                            primary v-btn--density-default
                            v-btn--size-default
                            v-btn--variant-text"
                              :href="route('backend.profile.index', $page.props.auth.tenant)">
                                Profile
                            </Link>
                        </v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <Link v-if="$page.props.auth.is_admin"
                            class="v-btn v-theme--light
                            primary v-btn--density-default
                            v-btn--size-default
                            v-btn--variant-text"
                            :href="route('admin.admin-logout')" method="post">
                            Logout
                        </Link>

                        <Link v-else
                              class="v-btn v-theme--light
                            primary v-btn--density-default
                            v-btn--size-default
                            v-btn--variant-text"
                              :href="route('logout')" method="post">
                            Logout
                        </Link>
                    </v-card-actions>
                </v-card>
            </v-menu>
        </div>
    </v-app-bar>
</template>

<script setup>
import {reactive, ref} from "vue";
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    drawer: Boolean,
})

// const drawer = ref(null)
const state = reactive({
    links: [
        'Dashboard',
        'Messages',
        'Profile',
        'Updates',
    ],
    fav: true,
    menu: false,
    message: false,
    hints: true,
})
</script>

<style scoped>

</style>
