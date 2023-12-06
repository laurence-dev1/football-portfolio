<script>
import {defineComponent} from 'vue'
import Layout from "@/Shared/Layout.vue";
import AuthLayout from "@/Shared/AuthLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import LockIcon from "@/Shared/Util/Icons/LockIcon.vue";
import PlayerIcon from "@/Shared/Util/Icons/PlayerIcon.vue";
import LoadingIcon from "@/Shared/Util/Icons/LoadingIcon.vue";

export default defineComponent({
    name: "Register",
    components: {Link, LoadingIcon, PlayerIcon, LockIcon, Head },
    layout: [ Layout, AuthLayout ],

    data() {
        return {
            registerForm: useForm({
                name: '',
                email: '',
                username: '',
                password: ''
            })
        }
    },

    methods: {
        doRegister() {
            if (this.registerForm.name === '' || this.registerForm.email === ''
                || this.registerForm.username === '' || this.registerForm.password === '') {
                return this.$page.props.errors.name = 'Fill out the form.';
            }

            this.registerForm.post('/register', { preserveScroll: true })
        }
    }
})
</script>

<template>
    <div>
        <Head>
            <title>Register</title>
        </Head>

        <form @submit.prevent="doRegister" class="form__auth">
            <div class="div__icon-label-input">
                <PlayerIcon />
                <input type="text"
                       name="name"
                       id="name"
                       v-model="registerForm.name"
                       placeholder="Name"
                       autocomplete="name">
            </div>

            <div class="div__icon-label-input">
                <PlayerIcon />
                <input type="text"
                       name="email"
                       id="email"
                       v-model="registerForm.email"
                       placeholder="Email Address"
                       autocomplete="email">
            </div>

            <div class="div__icon-label-input">
                <PlayerIcon />
                <input type="text"
                       name="username"
                       id="username"
                       v-model="registerForm.username"
                       placeholder="Username"
                       autocomplete="username">
            </div>

            <div class="div__icon-label-input">
                <LockIcon />
                <input type="password"
                       name="password"
                       id="password"
                       v-model="registerForm.password"
                       placeholder="Password"
                       autocomplete="current-password">
            </div>

            <LoadingIcon v-if="registerForm.processing === true" />
            <button type="submit" class="btn btn_common" :disabled="registerForm.processing === true">
                {{ registerForm.processing === true ? 'Please wait...' : 'Register' }}
            </button>
        </form>
    </div>
</template>

<style scoped>

</style>
