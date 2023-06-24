<template>
    <v-navigation-drawer
        class="sidebar"
    >
        <v-list v-model:opened="state.open" nav>
            <v-list-item>
                <Link class="v-list-item-title v-list-item--variant-text" :href="route('backend.dashboard', $page.props.auth.tenant)">
                    Client Dashboard
                </Link>
            </v-list-item>
            <v-divider></v-divider>

            <v-list-item prepend-icon="mdi-home">
                <Link class="v-list-item-title v-list-item--variant-text" :href="route('backend.dashboard', $page.props.auth.tenant)">Home</Link>
            </v-list-item>

            <v-list-item
                v-for="([title, icon, routeName], i) in state.product.menus"
                :key="i"
                :value="title"
                :prepend-icon="icon"
            >
                <Link class="v-list-item-title v-list-item--variant-text" :href="route(routeName, $page.props.auth.tenant)">{{ title }}</Link>
            </v-list-item>

            <v-list-group :value="state.orders.title">
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        :prepend-icon="state.orders.icon"
                        :title="state.orders.title"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="([title, icon, routeName], i) in state.orders.menus"
                    :key="i"
                    :value="title"
                    :prepend-icon="icon"
                    class="pa-0"
                >
                    <Link class="v-list-item-title v-list-item--variant-text" :href="route(routeName, $page.props.auth.tenant)">{{ title }}</Link>
                </v-list-item>
            </v-list-group>

            <v-list-item prepend-icon="mdi-cog">
                <Link class="v-list-item-title v-list-item--variant-text"
                    :href="route('backend.store-details.index', $page.props.auth.tenant)">Settings</Link>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script setup>
import {reactive} from "vue";
import { Head, Link } from '@inertiajs/vue3';

const state = reactive({
    open: ['Users'],
    product: {
        title: 'Catalogs',
        icon: 'mdi-view-list',
        menus: [
            ['Products', 'mdi-alpha-p-box', 'backend.product.index'],
            ['Categories', 'mdi-alpha-c-box', 'backend.categories.index'],
            ['Attributes', 'mdi-alpha-a-box', 'backend.attributes.index'],
            ['Tags', 'mdi-tag-multiple', 'backend.tags.index'],
            ['Taxes', 'mdi-percent-box', 'backend.taxes.index'],
        ],
    },
    orders: {
        title: 'Order',
        icon: 'mdi-cart',
        menus: [
            ['Order List', 'mdi-circle-small', 'backend.taxes.index'],
            ['Customer List', 'mdi-circle-small', 'backend.taxes.index'],
            ['Inventory', 'mdi-circle-small', 'backend.taxes.index'],
        ],
    },
})
</script>

<style scoped>

</style>
