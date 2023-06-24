<template>
    <AuthenticatedLayout>
        <Head title="Add Attribute"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Add New"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'backend.attributes.index', queryParam: $page.props.auth.tenant}"
                    />

                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="8" class="mt-3 ">
                                <v-card flat>
                                    <v-tabs v-model="tab" color="deep-purple-accent-4">
                                        <v-tab value="one">English</v-tab>
                                        <v-tab value="two">Bangla</v-tab>
                                    </v-tabs>

                                    <v-divider></v-divider>

                                    <v-card-text>
                                        <v-window v-model="tab">
                                            <v-window-item value="one">
                                                <Input type="text" label="Title" v-model="form.title_en"
                                                       :error-messages="form.errors.title_en"/>
                                                <TextArea v-model="form.content_en" label="Content"
                                                          :error-messages="form.errors.content_en"></TextArea>
                                            </v-window-item>

                                            <v-window-item value="two">
                                                <Input type="text" label="Title" v-model="form.title_bn"
                                                       :error-messages="form.errors.title_bn"/>
                                                <TextArea v-model="form.content_bn" label="Content"
                                                          :error-messages="form.errors.content_bn"></TextArea>
                                            </v-window-item>
                                        </v-window>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            <v-col cols="4" class="mt-10">
                                <v-card-item>
                                    <Input v-model="form.order" label="Order" type="number"/>

                                    <div class="text-subtitle-2">
                                        Default
                                        <v-switch
                                            v-model="form.is_default"
                                            color="info"
                                            density="comfortable"
                                            inset
                                            :label="form.is_default ? 'Yes' : 'No'"
                                        />
                                    </div>

                                    <div class="text-subtitle-2">
                                        Status
                                        <v-switch
                                            v-model="form.status"
                                            color="info"
                                            density="comfortable"
                                            inset
                                            :label="form.status ? 'Active' : 'Inactive'"
                                        />
                                    </div>
                                </v-card-item>
                            </v-col>
                        </v-row>

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
                    </form>
                </v-card>
            </v-col>
        </v-row>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CardTitle from "@/Components/Common/CardTitle.vue";
import Input from "@/Components/Form/BaseInput.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import {useForm, Head, usePage} from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
import {computed, ref} from "vue";

const page = usePage();
const toast = useToast();

const tenantData = computed(() => page.props.auth.tenant);

const tenant = tenantData ? tenantData.value : '';

const tab = ref(null)

const form = useForm({
    title_en: '',
    title_bn: '',
    content_en: '',
    content_bn: '',
    order: 0,
    is_default: false,
    status: true,
});

const submit = () => {
    form.post(route('backend.attributes.store', tenant), {
        onSuccess: (success) => {
            toast('Data has been added successfully.');
        },
        onError: (error) => {
            toast.error('Something is wrong. Please try again.');
        }
    });
};
</script>
