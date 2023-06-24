<template>
    <AdminLayout>
        <Head title="Edit User"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Edit"
                        icon="mdi-arrow-left-bold"
                        :router="{title:'Back', route:'admin.users.index'}"
                    />

                    <form @submit.prevent="submit">
                        <v-row>
                            <v-col cols="8">
                                <v-card-item>
                                    <Input type="text" label="Name" v-model="form.name"
                                           :error-messages="form.errors.name"/>
                                    <Input type="text" label="Email" v-model="form.email"
                                           :error-messages="form.errors.email"/>
                                    <Input type="text" label="Phone Number" v-model="form.phone_number"
                                           :error-messages="form.errors.phone_number"/>
                                    <Input type="text" label="Domain" v-model="form.domain"
                                           :error-messages="form.errors.domain"/>
                                    <TextArea type="text" label="Address" v-model="form.address"
                                              :error-messages="form.errors.address"/>
                                </v-card-item>
                            </v-col>

                            <v-col cols="4">
                                <v-card-item>
                                    <div class="text-subtitle-2">Roles</div>
                                    <Select chips label="Select Permission" :items="roles" multiple
                                            itemKey="display_name"
                                            v-model="form.roles"></Select>
                                </v-card-item>

                                <v-card-item>
                                    <v-card-title class="mb-3">
                                        Additional Permissions <input id="loadPermission" type="checkbox"
                                                                      @click="loadMore($event)">
                                    </v-card-title>

                                    <v-card-text v-show="data.showAdditionalPermission">
                                        <v-table
                                            density="compact"
                                            class="border"
                                            fixed-header
                                            height="250px">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th class="text-left">Display Name</th>
                                                <th class="text-left">Name</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr v-for="(permission, index) in data.permissions.data"
                                                :key="permission.id">
                                                <td>
                                                    <input class="v-checkbox" type="checkbox"
                                                           :id="permission.display_name"
                                                           :checked="handleChecked(permission.id)"
                                                           @click="handlePermissions($event,permission.id)">
                                                </td>
                                                <td>
                                                    <p><label :for="permission.display_name">{{
                                                            permission.display_name
                                                        }}</label></p></td>
                                                <td><p><label :for="permission.display_name">{{
                                                        permission.name
                                                    }}</label></p></td>
                                            </tr>
                                            </tbody>
                                        </v-table>

                                        <v-row justify="center" class="pa-3">
                                            <v-col cols="auto">
                                                <v-btn
                                                    v-if="data.permissions.prev_page_url"
                                                    @click="getPaginatePermissions(data.permissions.prev_page_url)"
                                                    density="compact"
                                                >
                                                    prev
                                                </v-btn>
                                            </v-col>

                                            <v-col cols="auto">
                                                <v-btn
                                                    v-if="data.permissions.next_page_url"
                                                    @click="getPaginatePermissions(data.permissions.next_page_url)"
                                                    density="compact"
                                                    :ripple="false"
                                                >
                                                    next
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card-item>


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

                                <v-card-item v-if="!$page.props.auth.is_admin">
                                    <Link :href="route('admin.client.index',user.id)">
                                        <v-btn
                                            type="button"
                                            class="text-none mb-4 mx-auto"
                                            color="indigo-darken-3"
                                            variant="flat"
                                        >
                                            Client List
                                        </v-btn>
                                    </Link>
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
import Input from "@/Components/Form/BaseInput.vue";
import Select from "@/Components/Form/Select.vue";
import TextArea from "@/Components/Form/TextArea.vue";
import {useForm, Head, Link} from '@inertiajs/vue3';
import {useToast} from "vue-toastification";
import {onMounted, reactive} from "vue";

const toast = useToast();

const props = defineProps(['user', 'roles', 'permissions'])

const data = reactive({
    permissions: [],
    showAdditionalPermission: false
})

let form = useForm({
    name: '',
    email: '',
    phone_number: '',
    domain: '',
    address: '',
    status: true,
    roles: [],
    permissions: []
});

const fetchItems = async () => {

    let url = route('admin.user.permissions')
    axios
        .get(url)
        .then(response => (
            data.permissions = response.data
        ))

};

const loadMore = (e) => {
    data.showAdditionalPermission = e.target.checked
    fetchItems();
    form.permissions = props.permissions
};

function getPaginatePermissions(url) {
    axios
        .get(url)
        .then(response => (
            console.log(response),
                data.permissions = response.data
        ))
}

function handlePermissions(e, id) {
    if (e.target.checked) {
        form.permissions.push(id)
    } else {
        const index = form.permissions.findIndex(object => {
            return object === id;
        });

        console.log(index, id)

        form.permissions.splice(index, 1)
    }
}

function handleChecked(id) {
    let isChecked = false;

    for (const pId of form.permissions) {
        if (id === pId) {
            isChecked = id === pId
            break;
        }
    }

    return isChecked
}

const submit = () => {
    form.put(route('admin.users.update', props.user.id), {
        onSuccess: (success) => {
            toast('Data has been updated successfully.');
        },
        onError: (error) => {
            toast.error('Something is wrong. Please try again.');
        }
    });
};

onMounted(() => {
    let data = props.user;

    form = Object.assign(form, data)
    form.status = data.status === 1

    if (form.permissions.length !== 0) {
        document.getElementById('loadPermission').click();
    }
})
</script>
