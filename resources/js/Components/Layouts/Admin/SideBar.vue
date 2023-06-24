<template>
    <v-navigation-drawer
        class="sidebar"
    >
        <v-list v-model:opened="state.open" nav>
            <v-list-item>
                <Link class="v-list-item-title v-list-item--variant-text" :href="route('admin.dashboard')">
                    Super Admin
                </Link>
            </v-list-item>
            <v-divider></v-divider>

            <v-list-item prepend-icon="mdi-home">
                <Link class="v-list-item-title v-list-item--variant-text" :href="route('admin.dashboard')">Home</Link>
            </v-list-item>

            <v-list-group :value="state.clients.title">
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        :prepend-icon="state.clients.icon"
                        :title="state.clients.title"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="([title, icon, routeName], i) in state.clients.menus"
                    :key="i"
                    :value="title"
                    :prepend-icon="icon"
                    class="pa-0"
                >
                    <Link class="v-list-item-title v-list-item--variant-text" :href="route(routeName)">{{ title }}</Link>
                </v-list-item>
            </v-list-group>


            <v-list-group :value="state.admins.title">
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        :prepend-icon="state.admins.icon"
                        :title="state.admins.title"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="([title, icon, routeName], i) in state.admins.menus"
                    :key="i"
                    :value="title"
                    :prepend-icon="icon"
                    class="pa-0"
                >
                    <Link class="v-list-item-title v-list-item--variant-text" :href="route(routeName)">{{ title }}</Link>
                </v-list-item>
            </v-list-group>

            <v-list-item prepend-icon="mdi-cog">
                <Link class="v-list-item-title v-list-item--variant-text"
                      :href="route('admin.store-detail.index')">Settings</Link>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script setup>
    import {reactive} from "vue";
    import { Link } from '@inertiajs/vue3';

    const state = reactive({
        clients: {
            title: 'Clients',
            icon: 'mdi-account-group',
            menus: [
                ['Client List', 'mdi-circle-small', 'admin.users.index'],
                ['Roles', 'mdi-circle-small', 'admin.role.index'],
                ['Permissions', 'mdi-circle-small', 'admin.permission.index'],
            ],
        },
        admins: {
            title: 'Admin',
            icon: 'mdi-account-circle',
            menus: [
                ['Admin List', 'mdi-circle-small', 'admin.admins.index'],
            ],
        }
    })
</script>

<style scoped>

</style>
