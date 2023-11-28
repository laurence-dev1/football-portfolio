<script>
import { defineComponent } from 'vue'
import { Head, Link, useForm } from "@inertiajs/vue3";
import PlayerIcon from "@/Shared/Util/PlayerIcon.vue";
import LockIcon from "@/Shared/Util/LockIcon.vue";
import LoadingIcon from "@/Shared/Util/LoadingIcon.vue";

export default defineComponent({
    name: "Login",
    components: {LoadingIcon, Head, Link, LockIcon, PlayerIcon },

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
            if (this.username === '' || this.password === '') {
                alert('Fill out the login form');
                return;
            }

            this.loginForm.post('/login');
        }
    }
})
</script>

<template>
    <div>
        <Head>
            <title>User Login</title>
        </Head>

        <section class="login__banner">
            <div class="banner__img">
                <img src="../../../img/login_banner_img.jpg" alt="Login Banner">
            </div>
            <div class="banner__form">
                <p class="text_info">Login to bookmark matches, competitions, teams etc.</p>

                <form @submit.prevent="doLogin">
                    <div class="div__icon-label-input">
                        <PlayerIcon />
                        <input type="text" name="username" id="username" v-model="loginForm.username" placeholder="Username">
                    </div>

                    <div class="div__icon-label-input">
                        <LockIcon />
                        <input type="text" name="password" id="password" v-model="loginForm.password" placeholder="Password">
                    </div>

                    <LoadingIcon v-if="loginForm.processing === true" />
                    <button type="submit" class="btn btn_common" :disabled="loginForm.processing === true">
                        {{ loginForm.processing === true ? 'Please wait...' : 'Login' }}
                    </button>
                </form>

                <div class="div__register">
                    <hr>
                    <Link href="/register" >Create account?</Link>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
    section.login__banner {
        width: 60%;
        margin: 10rem auto 0 auto;
    }

    .login__banner {
        display: flex;
        flex-wrap: wrap;
        box-shadow: 0 0 15px 4px #d5d5d5;
    }

    .banner__img img {
        width: 250px;
    }

    .banner__form {
        flex-grow: 1;
        text-align: center;
        background-color: var(--primary-bg);
        padding: 1em;

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .div__icon-label-input {
        display: flex;
        align-items: center;
        gap: 0.5em;

        margin-top: 1em;
        border: 1px solid var(--border-bg);
        border-radius: var(--border-radius);

        padding-left: 0.4em;
        background-color: #FFF;
    }

    .div__icon-label-input input[type=text] {
        padding: 0.7em;
        border: none;
        border-top-right-radius: var(--border-radius);
        border-bottom-right-radius: var(--border-radius);
    }

    .div__icon-label-input input[type=text]:focus {
        outline: none;
    }

    button[type=submit] {
        width: 70%;
        margin-top: 1em;
    }

    .div__register {
        margin-top: 1rem;
        font-size: 0.7rem;
        width: 100%;
    }

    @media screen and (max-width: 580px) {
        section.login__banner {
            width: 80%;
        }

        .banner__img {
            display: none;
        }
    }

    @media screen and (max-width: 1151px) {
        .banner__img {
            display: none;
        }
    }

</style>
