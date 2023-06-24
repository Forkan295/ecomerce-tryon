<template>
    <v-navigation-drawer
        class="sidebar"
    >
        <v-list v-model:opened="state.open" nav>
            <v-list-item>
                <Link class="v-list-item-title v-list-item--variant-text" :href="route('backend.')">
                    Softwind Tech
                </Link>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item prepend-icon="mdi-home">
                <Link class="v-list-item-title v-list-item--variant-text" :href="route('backend.')" >Home</Link>
            </v-list-item>
            <template v-for="menu in menuList">
                <v-list-group v-if="menu.has_child" :value="menu.title" v-show="menu.isPermissible">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            :prepend-icon="menu.icon"
                            :title="menu.title"
                        ></v-list-item>
                    </template>

                    <v-list-item
                        v-for="(item, i) in menu.items"
                        :key="i"
                        :value="item.title"
                        :prepend-icon="item.icon"
                        class="pa-0"
                        v-show="item.isPermissible"
                    >
                        <Link class="v-list-item-title v-list-item--variant-text" :href="route(item.route)">{{ item.title }}</Link>
                    </v-list-item>
                </v-list-group>
                <v-list-item
                    v-else
                    :value="menu.title"
                    :prepend-icon="menu.icon"
                    v-show="menu.isPermissible"
                >
                    <Link class="v-list-item-title v-list-item--variant-text" :href="route(menu.route)">{{ menu.title }}</Link>
                </v-list-item>

            </template>
        </v-list>
    </v-navigation-drawer>
</template>

<script setup>
import {reactive} from "vue";
import { Head, Link,usePage,router  } from '@inertiajs/vue3';

const menuList = usePage().props.menuList

const state = reactive({
    links: [
        'Dashboard',
        'Messages',
        'StoreDetails',
        'Updates',
    ],
    open: ['Users'],
})

</script>

<style scoped>

</style>
