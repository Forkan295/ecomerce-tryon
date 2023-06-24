<template>
    <AuthenticatedLayout>
        <Head title="Shipping"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-row>
                    <v-col cols="2">
                        <SettingsMenu />
                    </v-col>

                    <v-col cols="10">
                        <v-card>
                            <CardTitle
                                title="Add New"
                                icon="mdi-format-list-bulleted"
                                :router="{title:'List', route:'backend.shipping.index'}"
                            />

                            <v-card-text>
                                <form @submit.prevent="submit">
                                    <v-card class="mt-4">
                                        <v-card-title>Shipping Information</v-card-title>
                                        <v-divider></v-divider>
                                        <v-card-item>
                                            <v-row>
                                                <v-col cols="12">
                                                    <Input type="text" label="Name" v-model="form.name" />


                                                    <TextArea label="Address" v-model="form.address" />
                                                </v-col>
                                            </v-row>
                                        </v-card-item>

                                        <v-divider></v-divider>

                                        <v-card-actions>
                                            <v-btn
                                                type="submit"
                                                class="text-none mb-4 mx-auto"
                                                color="indigo-darken-3"
                                                variant="flat"
                                            >
                                                Save
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>

                                </form>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import SettingsMenu from "@/Components/Layouts/SettingsMenu.vue";
import CardTitle from "@/Components/Common/CardTitle.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import Input from "@/Components/Form/BaseInput.vue";
import { useForm, Head } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";

const toast = useToast();

let form = useForm({
    name: '',
    address: '',
});

const submit = () => {
    form.post(route('backend.shipping.store'), {
        onSuccess: (success) => {
            toast('Data has been added successfully.');
        },
        onError: (error) => {
            toast.error('Something is wrong. Please try again.');
        }
    });
};
</script>
