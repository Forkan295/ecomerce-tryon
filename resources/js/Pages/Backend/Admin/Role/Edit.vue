<template>
    <AdminLayout>
        <Head title="Add Role"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Edit"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'admin.role.index'}"
                    />

                    <form @submit.prevent="handleForm">
                        <v-row>
                            <v-col cols="8">
                                <v-card-item>
                                    <Input type="text" label="Display Name" v-model="form.display_name"
                                           :error-messages="form.errors.display_name"/>
                                    <Input type="text" label="Description" v-model="form.description"
                                           :error-messages="form.errors.description"/>
                                </v-card-item>
                            </v-col>

                            <v-col col="4">
                                <v-card-item>
                                    <div class="text-subtitle-2">Permission</div>
                                    <Select
                                        chips
                                        label="Select Permission"
                                        :items="permissions"
                                        multiple
                                        itemKey="display_name"
                                        v-model="form.permissions"
                                        :error-messages="form.errors.permissions">
                                    </Select>

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
    import Select from "@/Components/Form/Select.vue";
    import Input from "@/Components/Form/BaseInput.vue";
    import {useForm, Head} from '@inertiajs/vue3';
    import {useToast} from "vue-toastification";
    import {onMounted, ref} from "vue";

    const toast = useToast();

    const props = defineProps(['role', 'permissions'])

    const tab = ref(null)

    const form = useForm({
        display_name: '',
        name: '',
        description: '',
        permissions: [],
        status: true,
    });

    const handleForm = () => {
        form.name = form.display_name.replace(/\s+/g, '_').toLowerCase();

        form.put(route('admin.role.update',props.role.id), {
            onSuccess: (success) => {
                toast('Data has been updated successfully.');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
                form.reset()
            }
        });
    };

    onMounted(() => {
        let data = props.role;

        Object.assign(form, data)
        form.status = data.status == 1;
    })
</script>
