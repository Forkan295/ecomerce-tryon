<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer permanent absolute>
                <v-list-item title="Client Setting" />
                <v-divider></v-divider>

                <v-list
                    :lines="false"
                    density="compact"
                    nav
                >
                    <v-list-item
                        v-for="(item, index) in state.menu"
                        :key="index"
                        :value="item"
                        :class="isRoute(item.route)"
                    >
                        <template v-slot:prepend>
                            <v-icon :icon="item.icon"></v-icon>
                        </template>

                        <Link class="v-list-item--variant-text v-btn" :href="route(item.route, $page.props.auth.tenant)">
                            <v-list-item-title v-text="item.text"></v-list-item-title>
                        </Link>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-main style="height: 640px;"></v-main>
        </v-layout>
    </v-card>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import { reactive } from "vue";

    const state = reactive({
        menu: [
            {
                text: 'Store Details',
                icon: 'mdi-store',
                route: 'backend.store-details.index'
            },
            {
                text: 'Gateways',
                icon: 'mdi-credit-card-settings-outline',
                route: 'backend.gateway.create',
            },
            {
                text: 'Shipping',
                icon: 'mdi-truck-cargo-container',
                route: 'backend.shipping.create',
            },
        ],
    });

    const isRoute = (routeName) => {
        let router = routeName.slice(0, -6);

        return route().current(router + '*') ? 'bg-blue-grey-lighten-4' : '';
    }
</script>
