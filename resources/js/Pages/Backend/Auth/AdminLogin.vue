<template>
    <Head title="Log in" />

    <v-container fluid class="auth_wrapper d-flex align-center justify-center pa-3 position-relative">
        <v-sheet width="400" class="mx-auto pa-5 pa-sm-8 rounded-lg login_section">
            <div class="heading_section mb-8 d-flex align-center justify-center">
                <div>
                    <v-img src="images/swt-logo.png" class="brand_logo mr-2" />
                </div>
                <h4 class="title">Softwind Tech Ltd.</h4>
            </div>

            <v-form @submit.prevent="submit">
                <v-text-field
                    class="text-black"
                    variant="underlined"
                    v-model="form.email"
                    label="Email"
                    :error-messages="form.errors.email"
                />

                <v-text-field
                    class="text-black w-100 password_section"
                    variant="underlined"
                    v-model="form.password"
                    label="password"
                    type="password"
                    :error-messages="form.errors.password"
                />

                <div class="d-flex justify-space-between align-center mb-5">
                    <v-checkbox
                        class="text-body-2 font-weight-regular d-inline-flex"
                        label="Remember me"
                        color="primary"
                        v-model:checked="form.remember"
                    />
                </div>
                <v-btn :ripple="false" type="submit" variant="outlined" block class="sign_in">Sign in</v-btn>
            </v-form>
        </v-sheet>

        <div>
            <v-img width="300" class="auth_footer_start_tree d-none d-md-block" src="images/auth-v1-tree.png" alt="" />
        </div>

        <div>
            <v-img width="300" class="auth_footer_end_tree d-none d-md-block" src="images/auth-v2-tree-2.png" alt="" />
        </div>

        <div class="auth_footer_mask d-none d-md-block"></div>
    </v-container>
</template>

<script setup>
    import { Head, useForm } from '@inertiajs/vue3';
    import { reactive } from "vue";

    const state = reactive({
        formModel : {},
    })

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = () => {
        form.post(route('admin-login.request'));
    };
</script>
