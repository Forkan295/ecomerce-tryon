<template>
    <AuthenticatedLayout>
        <Head title="Generate Form"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        :title="group.title"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'backend.groups.index'}"
                    />

                    <form @submit.prevent="submit">
                        <div class="px-3 py-3">
                            <v-row v-for="(item, index) in data.fieldRows" :key="item">
                                <v-col>
                                    <Input type="text" label="Field Title" v-model="item.title" />
                                </v-col>

                                <v-col>
                                    <v-select
                                        v-model="item.input_type"
                                        :items="attributes"
                                        item-title="label"
                                        item-value="name"
                                        label="Input Type"
                                        variant="outlined"
                                        density="compact"
                                        class="mt-2"
                                    />
                                </v-col>

                                <v-col>
                                    <Input type="number" label="Order" v-model="item.order" />
                                </v-col>

                                <v-col>
                                    <v-switch
                                        v-model="item.status"
                                        color="info"
                                        density="comfortable"
                                        inset
                                        :true-value="1"
                                        :false-value="0"
                                        :label="item.status === 1 ? 'Active' : 'Inactive'"
                                    />
                                </v-col>

                                <v-col cols="auto">
                                    <v-btn class="bg-red-darken-3 mt-2 text-none" flat @click="removeRow(index)" variant="flat">Delete</v-btn>
                                </v-col>
                            </v-row>

                            <v-btn @click="addRow" variant="flat" class="bg-indigo-darken-3 text-none">Add</v-btn>
                        </div>

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
    import { useForm, Head } from '@inertiajs/vue3';
    import { useToast } from "vue-toastification";
    import { onMounted, reactive } from "vue";

    const toast = useToast();

    let data = reactive({
        fieldRows: [{
            'title': '',
            'input_type': '',
            'order': '',
            'status': 1,
        }],
    })

    const props = defineProps(['group', 'attributes']);

    const addRow = () => {
        data.fieldRows.push({
            title: '',
            input_type: '',
            order: '',
            status: 1,
        });
    }

    const removeRow = (index) => {
        data.fieldRows.splice(index, 1);
    }

    let form = useForm(data);

    const submit = () => {
        form.put(route('backend.groups.store_form', props.group), {
            onSuccess: (success) => {
                toast('Data has been added successfully.');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };

    onMounted(() => {
        Object.assign(data.fieldRows, props.group.children);
    })
</script>
