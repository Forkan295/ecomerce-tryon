<template>
    <AuthenticatedLayout>
        <Head title="Edit Role"/>
        <form @submit.prevent="handleForm">
            <v-row no-gutters>
                <v-col cols="12" class="my-3">
                    <CardTitle
                        title="Edit Role"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'backend.role.index'}"
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
                            <v-card-item title="Permission">
                                <Select chips label="Select Permission" :items="permissions" multiple itemKey="display_name"
                                        v-model="form.permissions"></Select>
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
import {onMounted, ref} from "vue";

const toast = useToast();

const props = defineProps(['role', 'permissions', 'errors'])

const tab = ref(null)

const form = useForm({
    display_name: '',
    name: '',
    description: '',
    permissions: []
});

const handleForm = () => {
    form.name = form.display_name.replace(/\s+/g, '_').toLowerCase();

    form.put(route('backend.role.update',props.role.id), {

        onSuccess: (success) => {
            toast('Data has been added successfully.');
        },
        onError: (error) => {
            toast.error('Something is wrong. Please try again.');
            form.reset()
        }
    });
};

onMounted(() => {
    let data = props.role;
    console.log(data)
    Object.assign(form, data)
})
</script>
