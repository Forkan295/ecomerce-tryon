<template>
    <AuthenticatedLayout>
        <Head title="Site Setting"/>
        <v-row no-gutters>
            <v-col cols="12">
                <v-card>
                    <CardTitle
                        title="Site Setting"
                        icon="mdi-plus"
                        :router="{title:'Group', route:'backend.groups.index'}"
                    />

                    <v-tabs center-active>
                        <template v-for="(item, index) in groups" :key="index">
                            <v-tab>
                                <Link :href="route('backend.settings.form', item.slug)" class="px-3 mt-3">{{ item.title }}</Link>
                            </v-tab>
                        </template>
                    </v-tabs>

                    <v-card-text v-if="isItems()">
                        <form @submit.prevent="submit">
                            <v-row>
                                <v-col cols="8">
                                    <v-card-item>
                                        <template v-for="(item, index) in rows.fieldRows" :key="index">
                                            <Input v-if="isInput(item, 'text')" type="text" :label="item.title" v-model="rows.fieldRows[index].slug"/>
                                            <TextArea v-if="isInput(item, 'textarea')" :label="item.title" v-model="rows.fieldRows[index].slug"></TextArea>
                                        </template>
                                    </v-card-item>
                                </v-col>

                                <v-col cols="4">
                                    <v-card-item>
                                        <template v-for="(item, index) in rows.fieldRows" :key="index">
                                            <v-file-input v-if="isInput(item, 'image')"
                                                :label="item.title"
                                                density="compact"
                                                variant="outlined"
                                                accept="image/*"
                                                prepend-icon="mdi-paperclip"
                                                v-model="rows.fieldRows[index].slug"
                                            />
                                        </template>
                                    </v-card-item>
                                </v-col>
                            </v-row>

                            <v-divider></v-divider>
                            <v-card-actions>
                                <v-btn v-if="isItems()"
                                    type="submit"
                                    class="text-none mb-4 mx-auto"
                                    color="indigo-darken-3"
                                    variant="flat"
                                >
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </form>
                    </v-card-text>

                    <v-card-text v-else>
                        <v-alert
                            variant="outlined"
                            type="warning"
                        >
                            Group items does not found!
                            <Link class="v-btn bg-indigo-darken-2
                                v-btn--density-default
                                v-btn--size-default
                                px-2 ml-2"
                                :href="route('backend.groups.form', setting.id)"
                            >
                                Add Items
                            </Link>
                        </v-alert>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import CardTitle from "@/Components/Common/CardTitle.vue";
    import Input from "@/Components/Form/BaseInput.vue";
    import TextArea from "@/Components/Form/TextArea.vue";
    import { Link, Head, useForm } from '@inertiajs/vue3';
    import {onMounted, reactive} from "vue";

    const props = defineProps(['groups', 'setting', 'items'])

    const isItems = () => {
        return props.items.length !== 0;
    }

    const isInput = (item, type) => {
        return item.input_type === type;
    }

    // let slug = [];
    //
    // props.items.map(function(item) {
    //     slug.push(item.slug);
    // });

    // let result = Object.fromEntries(slug.map(e => e.split(":")));


    // let fieldItems = reactive()
    // console.log(result);

    let rows = reactive({
        fieldRows: [],
    });

    // console.log(rows);

    const form = useForm(rows);

    const submit = () => {
        console.log(rows)
        console.log(rows.fieldRows)

        form.post(route('backend.settings.store_setting', props.setting), {
            onSuccess: (success) => {
                toast('Data has been added successfully.');
            },
            onError: (error) => {
                toast.error('Something is wrong. Please try again.');
            }
        });
    };

    onMounted(() => {
        Object.assign(rows.fieldRows, props.items);
    })
</script>
