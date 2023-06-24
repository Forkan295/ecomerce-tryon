<template>
    <div class="text-center">
        <v-container>
            <v-row justify="center">
                <div v-if="items.links.length > 3">
                    <div class="flex flex-wrap -mb-1">
                        <template v-for="(link, index) in items.links" :key="index">
                            <Link v-if="index == 0" class="py-3 v-btn v-btn--density-default"
                                  :href="link.url">
                                <i class="mdi-menu-left mdi v-icon notranslate v-theme--light v-icon--size-default" aria-hidden="true"></i>
                            </Link>

                            <Link v-if="index == (items.links.length - 1)" class="ml-6 py-3 v-btn v-btn--density-default"
                                  :href="link.url">
                                <i class="mdi-menu-right mdi v-icon notranslate v-theme--light v-icon--size-default" aria-hidden="true"></i>
                            </Link>

                            <Link class="mr-1 mb-1 px-4 py-3 v-btn v-btn--density-default"
                                  :class="{ 'bg-grey-lighten-2 text-black': link.active }"
                                  :href="link.url"
                                  v-html="index != 0 && index != (items.links.length - 1) ? link.label : '' " />
                        </template>
                    </div>
                </div>
            </v-row>
        </v-container>
    </div>
</template>


<script setup>
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        items: Array,
    })
</script>
