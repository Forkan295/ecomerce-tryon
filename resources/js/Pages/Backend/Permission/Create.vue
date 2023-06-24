<template>
    <AuthenticatedLayout>
        <Head title="Add Permission"/>
        <form @submit.prevent="handleForm">
            <v-row no-gutters>
                <v-col cols="12" class="my-3">
                    <CardTitle
                        title="Add New Permission"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'backend.permission.index'}"
                    />
                </v-col>

                <v-col cols="12" sm="8" class="pr-2 mb-3">
                    <v-sheet rounded="lg" class="mb-3">
                        <v-card>
                            <v-card-item>
                                <Input type="text" label="Display Name" v-model="form.display_name"
                                       :errorMessage="errors.display_name"/>
                                <Input type="text" label="Description" v-model="form.description"
                                       :errorMessage="errors.description"/>
                            </v-card-item>
                        </v-card>
                    </v-sheet>
                </v-col>
                <v-col col="12" sm="4">
                    <v-sheet>
                        <v-card>
                            <v-card-item title="Parent">
                                <Select label="Select Parent" :items="parents" itemKey="display_name"
                                        v-model="form.parent_id"></Select>
                            </v-card-item>
                            <v-divider/>
                            <v-card-item title="Status">
                                <Switch :errorMessage="errors.status" v-model="form.status"
                                        :label="form.status?'On':'Off'"
                                        @click="form.status = !form.status"></Switch>
                            </v-card-item>
                        </v-card>
                    </v-sheet>
                </v-col>
            </v-row>
            <v-divider/>
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
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CardTitle from "@/Components/Common/CardTitle.vue";
import Switch from "@/Components/Form/Switch.vue";
import Select from "@/Components/Form/Select.vue";
import Input from "@/Components/Form/BaseInput.vue";
import {useForm, Head} from '@inertiajs/vue3';
import {useToast} from "vue-toastification";
import {ref} from "vue";

const toast = useToast();

const props = defineProps(['parents', 'errors'])

const tab = ref(null)

const form = useForm({
    display_name: '',
    name: '',
    description: '',
    parent_id: null,
    status: true,
});

const handleForm = () => {
    form.name = form.display_name.replace(/\s+/g, '_').toLowerCase();

    if (form.parent_id === null) {
        form.parent_id = 0
    }
    form.post(route('backend.permission.store'), {

        onSuccess: (success) => {
            toast('Data has been added successfully.');
            form.reset()
        },
        onError: (error) => {
            toast.error('Something is wrong. Please try again.');
            form.reset()
        }
    });
};
</script>
