<template>
<!--    <v-snackbar v-if="success" :model-value="success" :timeout="5000" color="success">-->
    <v-snackbar v-if="success" :timeout="5000" color="success">
        {{ success }}

        <template v-slot:actions>
            <v-btn color="white" variant="text" @click="success = ''">x</v-btn>
        </template>
    </v-snackbar>
</template>

<script setup>
    const data = defineProps(['success'])
</script>
