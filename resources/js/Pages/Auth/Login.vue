<script>
import { defineComponent } from 'vue'
import { Head, Link, useForm } from "@inertiajs/vue3";
import PlayerIcon from "@/Shared/Util/Icons/PlayerIcon.vue";
import LockIcon from "@/Shared/Util/Icons/LockIcon.vue";
import LoadingIcon from "@/Shared/Util/Icons/LoadingIcon.vue";
import AuthLayout from "@/Shared/AuthLayout.vue";
import Layout from "@/Shared/Layout.vue";
import { useMatchBookmarkRequestStore } from "@/store/Bookmark/useMatchBookmarkRequestStore.js";
import { useMessageStore } from "@/store/useMessageStore.js";

export default defineComponent({
    name: "Login",
    components: { LoadingIcon, Head, Link, LockIcon, PlayerIcon },
    layout: [ Layout, AuthLayout ],

    data() {
        return {
            loginForm: useForm({
                username: '',
                password: ''
            })
        }
    },

    methods: {
        doLogin() {
            if (this.loginForm.username === '' || this.loginForm.password === '') {
                return useMessageStore().$patch({
                    errorMessages: { username: 'Fill out the form.' }
                });
            }

            this.loginForm.post('/login', { preserveScroll: true });
        }
    },

    mounted() {
        // reset bookmarks store so that in case of coming from logging out,
        // the bookmarks of previous user will not persist on next one
        // (provided that account switching is within same client)
        useMatchBookmarkRequestStore().$reset();
    }
})
</script>

<template>
    <div>
        <Head>
            <title>User Login</title>
        </Head>

        <form @submit.prevent="doLogin" class="form__auth">
            <div class="div__icon-label-input">
                <PlayerIcon />
                <input type="text"
                       name="username"
                       id="username"
                       v-model="loginForm.username"
                       placeholder="Username"
                       autocomplete="username">
            </div>

            <div class="div__icon-label-input">
                <LockIcon />
                <input type="password"
                       name="password"
                       id="password"
                       v-model="loginForm.password"
                       placeholder="Password"
                       autocomplete="current-password">
            </div>

            <LoadingIcon class="mt-1" v-if="loginForm.processing === true" />
            <button type="submit" class="btn btn_common" :disabled="loginForm.processing === true">
                {{ loginForm.processing === true ? 'Please wait...' : 'Login' }}
            </button>
        </form>
    </div>
</template>

<style scoped>



</style>
