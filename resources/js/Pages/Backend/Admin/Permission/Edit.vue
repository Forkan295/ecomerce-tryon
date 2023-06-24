<template>
    <AdminLayout>
        <Head title="Edit Permission"/>

        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Edit Permission"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'admin.permission.index'}"
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

                            <v-col cols="4">
                                <v-card-item>
                                    <div>Parent</div>
                                    <Select
                                        label="Select Parent"
                                        :items="parents"
                                        itemKey="display_name"
                                        v-model="form.parent_id">
                                    </Select>

                                    <div>Status</div>
                                    <Switch
                                        :error-messages="form.errors.status"
                                        v-model="form.status"
                                        :label="form.status?'On':'Off'"
                                        @click="form.status = !form.status">
                                    </Switch>
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
    import Switch from "@/Components/Form/Switch.vue";
    import Select from "@/Components/Form/Select.vue";
    import Input from "@/Components/Form/BaseInput.vue";
    import {useForm, Head} from '@inertiajs/vue3';
    import {useToast} from "vue-toastification";
    import {onMounted, ref} from "vue";

    const toast = useToast();

    const props = defineProps(['parents', 'permission'])

    const tab = ref(null)

    const form = useForm({
        display_name: '',
        name: '',
        description: '',
        parent_id: null,
        status: null,
    });

    const handleForm = () => {
        form.name = form.display_name.replace(/\s+/g, '_').toLowerCase();

        if (form.parent_id === null) {
            form.parent_id = 0
        }
        form.post(route('admin.permission.update', props.permission.id), {
            onSuccess: (success) => {
                toast('Data has been updated successfully.');
                setDisablePatentOption()
                form.parent_id = form.parent_id === 0 ? null : form.parent_id
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };

    function setDisablePatentOption() {
        props.parents.unshift({
            id: 0,
            display_name: "Disable Parent"

        })
    }

    onMounted(() => {
        let data = props.permission;
        Object.assign(form, data)
        form.status = !!data.status
        setDisablePatentOption()
        form.parent_id = data.parent_id !== 0 ? data.parent_id : null
    })
</script>

