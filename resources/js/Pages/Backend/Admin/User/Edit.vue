<template>
    <AdminLayout>
        <Head title="Edit User"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Edit"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'admin.admins.index'}"
                    />

                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="8">
                                <v-card-item>
                                    <Input type="text" label="Name" v-model="form.name" :error-messages="form.errors.name" />
                                    <Input type="text" label="Email" v-model="form.email" :error-messages="form.errors.email" />
                                    <Input type="text" label="Phone Number" v-model="form.phone_number" :error-messages="form.errors.phone_number" />
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
                                Update
                            </v-btn>
                        </v-card-actions>
                    </form>
                </v-card>
            </v-col>
        </v-row>
    </AdminLayout>
</template>

<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue'
    import CardTitle from "@/Components/Common/CardTitle.vue";
    import Input from "@/Components/Form/BaseInput.vue";
    import { useForm, Head } from '@inertiajs/vue3';
    import { useToast } from "vue-toastification";
    import { onMounted } from "vue";

    const toast = useToast();

    const props = defineProps(['user'])

    let form = useForm({
        name: '',
        email: '',
        phone_number: '',
        status: true,
    });

    const submit = () => {
        form.put(route('admin.admins.update', props.user.id), {
            onSuccess: (success) => {
                toast('Data has been updated successfully.');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };

    onMounted(() => {
        let data = props.user;
        form = Object.assign(form, data)
        form.status = data.status === 1
    })
</script>
