<template>
    <Link
        class="v-btn mx-1 v-btn--elevated bg-blue-darken-3 v-btn--icon
        v-theme--light v-btn--density-comfortable v-btn--size-default
        v-btn--variant-elevated"
        :href="queryParam != null ? route(router, queryParam) : route(router)"
    >
        <i :class="icon" class="mdi v-icon" aria-hidden="true"></i>
    </Link>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    icon: String,
    router: String,
    queryParam: Number
});
</script>

<style scoped>

</style>
