<template>
    <v-badge
        :color="status ? 'info' : 'red'"
        :content="status ? 'Active' : 'Inactive'"
        inline
    ></v-badge>
</template>

<script setup>
    const props = defineProps({
        status: Boolean,
    })
</script>
