<template>
    <AdminLayout>
        <Head title="Create Client"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Create New Client"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'admin.users.index'}"
                    />
                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="8">
                                <v-card-item>
                                    <Input type="text" label="Name" v-model="form.name"
                                           :error-messages="form.errors.name"/>
                                    <Input v-if="form.client_type === 'pkce'" type="text" label="Redirect URL"
                                           v-model="form.redirect"
                                           :error-messages="form.errors.redirect"/>
                                </v-card-item>
                            </v-col>

                            <v-col cols="4">
                                <v-card-item>
                                    <div class="text-subtitle-2">Client Type</div>
                                    <Select chips label="Select Permission" :items="['pkce','password']"
                                            v-model="form.client_type"
                                            :error-messages="form.errors.client_type"></Select>

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
import AdminLayout from '@/Layouts/AdminLayout.vue'
import CardTitle from "@/Components/Common/CardTitle.vue";
import Input from "@/Components/Form/BaseInput.vue";
import Select from "@/Components/Form/Select.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import {useForm, Head, router} from '@inertiajs/vue3';
import {useToast} from "vue-toastification";
import {reactive} from "vue";


const toast = useToast();
const props = defineProps(['userId'])

const form = useForm({
    name: '',
    client_type: 'pkce',
    redirect: '',
});

const submit = () => {
    console.log(props.userId)
    form.post(route('admin.client.store', props.userId), {
        onSuccess: (success) => {
            toast('Data has been added successfully.');
        },
        onError: (error) => {
            toast.error('Something is wrong. Please try again.');
        }
    });
};
</script>
