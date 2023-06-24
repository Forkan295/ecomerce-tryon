<template>
    <AdminLayout>
        <Head title="Client Setting"/>
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
                                :router="{title:'List', route:'admin.store-detail.index'}"
                            />

                            <v-card-text>
                                <form @submit.prevent="submit">
                                    <v-card>
                                        <v-card-title>Profile</v-card-title>
                                        <v-divider></v-divider>
                                        <v-card-item>
                                            <v-row>
                                                <v-col cols="6" class="mt-2">
                                                    <v-select
                                                        label="Select Client"
                                                        density="compact"
                                                        variant="outlined"
                                                        v-model="form.user_id"
                                                        :items="users"
                                                        :error-messages="form.errors.user_id"
                                                        item-title="name"
                                                        item-value="id"
                                                    />
                                                    <Input type="text" class="mt-2" label="Store Name" v-model="form.store_name" :error-message="form.errors.store_name" />
                                                    <Input type="text" label="Contact Email" v-model="form.contact_email" :error-message="form.errors.contact_email"/>
                                                    <v-file-input
                                                        label="Logo"
                                                        density="compact"
                                                        variant="outlined"
                                                        accept="image/*"
                                                        v-model="form.logo"
                                                        :error-messages="form.errors.logo"
                                                    />
                                                </v-col>

                                                <v-col cols="6" >
                                                    <Input type="text" label="Phone" v-model="form.phone_number" :error-message="form.errors.phone_number" />
                                                    <Input type="text" label="Slogan" v-model="form.slogan" :error-message="form.errors.slogan" />
                                                    <Input type="text" label="Sender Email" v-model="form.sender_email" :error-message="form.errors.sender_email" />
                                                </v-col>
                                            </v-row>
                                        </v-card-item>
                                    </v-card>

                                    <v-card class="mt-4">
                                        <v-card-title>Billing Information</v-card-title>
                                        <v-divider></v-divider>
                                        <v-card-item>
                                            <v-row>
                                                <v-col cols="6">
                                                    <Input type="text" label="Legal Business Name" v-model="form.legal_business_name" />
                                                    <Input type="text" label="City" v-model="form.city" />
                                                </v-col>

                                                <v-col cols="6" class="mt-2">
                                                    <v-autocomplete
                                                        label="Select Country"
                                                        density="compact"
                                                        variant="outlined"
                                                        v-model="form.country_id"
                                                        :items="countries"
                                                        :error-messages="form.errors.country_id"
                                                        item-title="name"
                                                        item-value="id"
                                                     />
                                                    <Input type="text" class="mt-2" label="Postal Code" v-model="form.post_code" />
                                                </v-col>

                                                <v-col cols="12">
                                                    <TextArea label="Address" v-model="form.address" />
                                                </v-col>
                                            </v-row>
                                        </v-card-item>
                                    </v-card>

                                    <v-card class="mt-4">
                                        <v-card-title>Order ID Format</v-card-title>
                                        <v-card-subtitle>Shown on the Orders page, customer pages, and customer order notifications to identify orders.</v-card-subtitle>
                                        <v-divider class="mt-2"></v-divider>
                                        <v-card-item>
                                            <v-row>
                                                <v-col cols="6">
                                                    <Input type="text" label="Prefix" v-model="form.order_id_prefix" />
                                                </v-col>

                                                <v-col cols="6">
                                                    <Input type="text" label="Suffix" v-model="form.order_id_suffix" />
                                                </v-col>
                                            </v-row>
                                        </v-card-item>
                                    </v-card>

                                    <v-card class="mt-4">
                                        <v-card-title>Meta Information</v-card-title>
                                        <v-divider class="mt-2"></v-divider>
                                        <v-card-item>
                                            <v-row>
                                                <v-col cols="12">
                                                    <Input type="text" label="Meta Title" v-model="form.meta_title" />
                                                </v-col>

                                                <v-col cols="12">
                                                    <TextArea label="Meta Description" v-model="form.meta_content" />
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
    const props = defineProps(['users', 'countries'])

    let form = useForm({
        store_name: '',
        slogan: '',
        user_id: '',
        phone_number: '',
        contact_email: '',
        sender_email: '',
        logo: '',
        legal_business_name: '',
        country_id: '',
        city: '',
        address: '',
        post_code: '',
        order_id_prefix: '',
        order_id_suffix: '',
        meta_title: '',
        meta_content: '',
    });

    // console.log(route('admin.store-details.store'));

    const submit = () => {
        form.post(route('admin.store-detail.store'), {
            onSuccess: (success) => {
                toast('Data has been added successfully.');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };
</script>
