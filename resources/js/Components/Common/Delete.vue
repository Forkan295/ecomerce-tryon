<template>
    <v-dialog width="auto">
        <template v-slot:activator="{ props }">
            <v-btn v-bind="props" tabIndex="-1" type="button" class="v-btn v-btn--elevated bg-red-darken-3 v-btn--icon v-theme--light v-btn--density-comfortable v-btn--size-default v-btn--variant-elevated">
                <i class="mdi-delete mdi v-icon" aria-hidden="true"></i>
            </v-btn>
        </template>

        <template v-slot:default="{ isActive }">
            <v-card class="bg-grey-lighten-4">
                <v-toolbar color="red-darken-4" title="Delete Confirmation"></v-toolbar>

                <v-card-text>
                    <div class="text-h6 ">Are you sure want to delete this ?</div>
                </v-card-text>

                <v-card-actions class="justify-end">
                    <Link
                        :href="tenantName != null ? route(routeName, [tenantName, id]) : route(routeName, id)"
                        method="delete"
                        type="button"
                        @click="isActive.value = false"
                        @success="onDeleteSuccess"
                        class="v-btn mx-1 py-2 v-btn--elevated bg-blue-darken-3 v-theme--light v-btn--size-default v-btn--variant-elevated"
                    >
                        Yes
                    </Link>

                    <v-btn  class="v-btn v-btn--elevated bg-red-darken-3 v-btn--size-default v-btn--variant-elevated" @click="isActive.value = false">No</v-btn>
                </v-card-actions>
            </v-card>
        </template>
    </v-dialog>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import {useToast} from "vue-toastification";

    const toast = useToast();
    const props = defineProps({
        id: Number,
        routeName: String,
        tenantName: String,
    })

    function onDeleteSuccess(){
        toast.success('Data has been Deleted successfully.');
    }
</script>
