<template>
    <AdminLayout>
        <Head title="Gateway"/>
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
                                :router="{title:'List', route:'admin.gateway.index'}"
                            />

                            <v-card-text>
                                <form @submit.prevent="submit">
                                    <v-card class="mt-4">
                                        <v-card-title>Gateway</v-card-title>
                                        <v-divider></v-divider>
                                        <v-card-item>
                                            <v-row>
                                                <v-col cols="12">
                                                    <Input type="text" label="Method Name" v-model="form.method_name" />
                                                    <TextArea label="Content" v-model="form.content" />
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
    </AdminLayout>
</template>

<script setup>
    import SettingsMenu from "@/Components/Layouts/Admin/SettingsMenu.vue";
    import AdminLayout from '@/Layouts/AdminLayout.vue'
    import CardTitle from "@/Components/Common/CardTitle.vue";
    import TextArea from "@/Components/Form/TextArea.vue";
    import Input from "@/Components/Form/BaseInput.vue";
    import { useForm, Head } from '@inertiajs/vue3';
    import { useToast } from "vue-toastification";

    const toast = useToast();

    let form = useForm({
        method_name: '',
        content: '',
    });

    const submit = () => {
        form.post(route('admin.gateway.store'), {
            onSuccess: (success) => {
                toast('Data has been added successfully.');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };
</script>
