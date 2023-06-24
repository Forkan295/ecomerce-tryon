<template>
    <AuthenticatedLayout>
        <Head title="Add Category"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Add New Category"
                        icon="mdi-arrow-left-bold"
                        :router="{
                            title:'Back',
                            route:'backend.categories.index',
                            queryParam:$page.props.auth.tenant
                        }"
                        :extraRoute="{
                            title:'Add Type',
                            icon:'mdi-plus',
                            route:'backend.category-types.index',
                            queryParam:$page.props.auth.tenant
                        }"
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
                                <v-card flat>
                                    <v-card-text>
                                        <v-file-input
                                            label="Banner"
                                            density="compact"
                                            variant="outlined"
                                            accept="image/*"
                                            prepend-icon="mdi-paperclip"
                                            v-model="form.image"
                                            :error-messages="form.errors.image"
                                            counter
                                        />
                                        <v-select
                                            label="Select type"
                                            density="compact"
                                            variant="outlined"
                                            v-model="form.category_type_id"
                                            :items="categoryType"
                                            :error-messages="form.errors.category_type_id"
                                            item-title="title"
                                            item-value="id"
                                        />

                                        <v-select
                                            label="Select Parent"
                                            density="compact"
                                            variant="outlined"
                                            v-model="form.parent_id"
                                            :items="parentCategories"
                                            item-title="title_en"
                                            item-value="id"
                                        />

                                        <Input v-model="form.order" label="Order Index" type="number"/>
                                        <div class="text-subtitle-2">
                                            Status
                                            <v-switch
                                                v-model="form.status"
                                                color="info"
                                                density="comfortable"
                                                inset
                                                :label="form.status === true ? 'Active' : 'Inactive'"
                                            />
                                        </div>
                                    </v-card-text>
                                </v-card>


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
    import TextArea from "@/Components/Form/TextArea.vue";
    import Input from "@/Components/Form/BaseInput.vue";
    import {useForm, Head, usePage} from '@inertiajs/vue3';
    import { useToast } from "vue-toastification";
    import {computed, ref} from "vue";

    const page = usePage();
    const toast = useToast();

    const tenantData = computed(() => page.props.auth.tenant);

    const tenant = tenantData ? tenantData.value : '';

    const props = defineProps(['parentCategories', 'categoryType'])

    const tab = ref(null)

    const form = useForm({
        title_en: '',
        title_bn: '',
        content_en: '',
        content_bn: '',
        parent_id: '',
        category_type_id: '',
        image: '',
        order: 0,
        status: true,
    });

    const submit = () => {
        form.post(route('backend.categories.store', tenant), {
            onSuccess: (success) => {
                toast('Data has been added successfully.');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };
</script>
