<template>
    <v-toolbar density="compact" :elevation="1" color="white">
        <v-toolbar-title  class="text-uppercase text-subtitle-2 font-weight-bold">
            {{ title }}
            {{ getTotalItem() }}
        </v-toolbar-title>
        <v-spacer></v-spacer>

        <Link v-if="extraRoute"
            class="v-btn bg-green
            v-btn--density-default
            v-btn--size-default mx-2"
            :href="extraRoute.queryParam != null ? route(extraRoute.route, extraRoute.queryParam) : route(extraRoute.route)">
            <v-icon :icon="extraRoute.icon"></v-icon>
            {{extraRoute.title}}
        </Link>

        <Link
            class="v-btn bg-indigo-darken-3
            v-btn--density-default
            v-btn--size-default"
            :href="router.queryParam != null ? route(router.route, router.queryParam) : route(router.route)">
            <v-icon :icon="icon"></v-icon>
            {{router.title}}
        </Link>
    </v-toolbar>
</template>

<script setup>
    import {Link} from '@inertiajs/vue3';

    const props = defineProps({
        totalItem: Number,
        title: String,
        icon: String,
        router: {
            title: String,
            route: String,
            queryParam: String,
        },
        extraRoute: {
            title: String,
            route: String,
            icon: String,
            queryParam: String,
        }
    });

    function getTotalItem() {
        return props.totalItem ? '(' + props.totalItem + ')' : '';
    }
</script>

<style scoped>

</style>
