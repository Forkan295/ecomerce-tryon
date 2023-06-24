<template>
    <AdminLayout>
        <Head title="Add new admin"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Add New"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'admin.admins.index'}"
                    />
                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="8">
                                <v-card-item>
                                    <Input type="text" label="Name" v-model="form.name"
                                           :error-messages="form.errors.name"/>
                                    <Input type="text" label="Email" v-model="form.email"
                                           :error-messages="form.errors.email"/>
                                    <Input type="text" label="Phone Number" v-model="form.phone_number"
                                           :error-messages="form.errors.phone_number"/>
                                    <Input type="password" label="Password" v-model="form.password"
                                           :error-messages="form.errors.password"/>
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
                                        :label="form.status === true ? 'Active' : 'Inactive'"
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
    </AdminLayout>
</template>

<script setup>
    import CardTitle from "@/Components/Common/CardTitle.vue";
    import AdminLayout from '@/Layouts/AdminLayout.vue'
    import Input from "@/Components/Form/BaseInput.vue";
    import { useForm, Head } from '@inertiajs/vue3';
    import { useToast } from "vue-toastification";

    const toast = useToast();

    const form = useForm({
        name: '',
        email: '',
        phone_number: '',
        password: '',
        status: true,
    });

    const submit = () => {
        form.post(route('admin.admins.store'), {
            onSuccess: (success) => {
                toast('Data has been added successfully.');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };
</script>
