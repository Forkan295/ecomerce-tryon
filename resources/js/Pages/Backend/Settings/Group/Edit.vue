<template>
    <AuthenticatedLayout>
        <Head title="Edit"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Edit"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'backend.groups.index'}"
                    />

                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="8">
                                <v-card-item>
                                    <Input type="text" label="Name" v-model="form.title" :error-messages="form.errors.title" />
                                    <Input type="number" label="Order" v-model="form.order" :error-messages="form.errors.order" />
                                    <TextArea v-model="form.description" label="Content" :error-messages="form.errors.description"></TextArea>
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
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import CardTitle from "@/Components/Common/CardTitle.vue";
    import TextArea from "@/Components/Form/TextArea.vue";
    import Input from "@/Components/Form/BaseInput.vue";
    import { useForm, Head } from '@inertiajs/vue3';
    import { useToast } from "vue-toastification";
    import { onMounted } from "vue";

    const toast = useToast();

    const props = defineProps(['group'])

    let form = useForm({
        title: '',
        order: '',
        description: '',
        status: true,
    });

    const submit = () => {
        form.put(route('backend.groups.update', props.group.id), {
            onSuccess: (success) => {
                toast('Data has been updated successfully.');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };

    onMounted(() => {
        let data = props.group;
        form = Object.assign(form, data)
        form.status = data.status === 1
    })
</script>
