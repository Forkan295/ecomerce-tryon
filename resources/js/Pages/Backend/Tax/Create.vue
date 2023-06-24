<template>
    <AuthenticatedLayout>
        <Head title="Add Tax"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Add New"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'backend.taxes.index',  queryParam:$page.props.auth.tenant}"
                    />

                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="8">
                                <v-card-item>
                                    <Input type="text" label="Title" v-model="form.title"
                                           :error-messages="form.errors.title"/>
                                    <Input type="number" label="Percentage" v-model="form.percentage"
                                           :error-messages="form.errors.percentage"/>
                                    <Input type="number" label="Priority" v-model="form.priority"
                                           :error-messages="form.errors.priority"/>
                                </v-card-item>
                            </v-col>

                            <v-col cols="4">
                                <v-card-item>
                                    <div class="text-subtitle-2">Status</div>
                                    <v-switch
                                        v-model="form.status"
                                        color="info"
                                        density="comfortable"
                                        inset
                                        :label="form.status ? 'Active' : 'Inactive'"
                                    />
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
    import {useForm, Head, usePage} from '@inertiajs/vue3';
    import { useToast } from "vue-toastification";
    import {computed} from "vue";

    const page = usePage();
    const toast = useToast();

    const tenantData = computed(() => page.props.auth.tenant);

    const tenant = tenantData ? tenantData.value : '';

    const form = useForm({
        title: '',
        percentage: 0,
        priority: 0,
        status: true,
    });

    const submit = () => {
        form.post(route('backend.taxes.store', tenant), {
            onSuccess: (response) => {
                toast('Data has been added successfully');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };
</script>
