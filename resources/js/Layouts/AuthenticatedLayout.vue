<template>
    <v-app id="inspire">
        <SideBar v-model="drawer" />
        <TopBar @click="drawer = !drawer"/>

        <!-- content -->
        <v-main class="bg-grey-lighten-3">
            <v-container fluid>
                <slot/>
            </v-container>
        </v-main>
    </v-app>
</template>
<script setup>
import {ref, reactive} from 'vue';
import TopBar from "@/Components/Layouts/TopBar.vue";
import SideBar from "@/Components/Layouts/SideBar.vue";
import SideBarBackup from "@/Components/Layouts/SideBarBackup.vue";

const drawer = ref(null)
const state = reactive({
    links: [
        'Dashboard',
        'Messages',
        'Profile',
        'Updates',
    ],
    open: ['Users'],
    admins: [
        ['Management', 'mdi-circle-small'],
        ['Settings', 'mdi-circle-small'],
    ],
    cruds: [
        ['Create', 'mdi-plus-outline'],
        ['Read', 'mdi-file-outline'],
        ['Update', 'mdi-update'],
        ['Delete', 'mdi-delete'],
    ],
})
</script>
