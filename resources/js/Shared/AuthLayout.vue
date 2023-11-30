<script>
import { defineComponent } from 'vue'
import ErrorCard from "@/Shared/Util/ErrorCard.vue";
import Layout from "@/Shared/Layout.vue";
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    name: "AuthLayout",
    components: { Link, ErrorCard },
    computed: {
        currentPage() {
            return this.$page.component === 'Auth/Login' ? 'Login' : 'Register';
        }
    }
})
</script>

<template>
    <div>
        <section class="login__banner">
            <div class="banner__img">
                <img src="../../img/login_banner_img.jpg" alt="Auth Banner">
            </div>
            <div class="banner__form">
                <p class="text_info">{{ currentPage }} an account to bookmark matches, competitions, teams etc.</p>

                <slot></slot>

                <div class="div__switch">
                    <hr>
                    <Link :href="currentPage === 'Login' ? '/register' : '/login'">
                        {{ currentPage === 'Login' ? 'Create' : 'Already got' }} an account?
                    </Link>
                </div>
            </div>
        </section>

        <ErrorCard />
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

    .div__icon-label-input input {
        padding: 0.7em;
        border: none;
        border-top-right-radius: var(--border-radius);
        border-bottom-right-radius: var(--border-radius);
    }

    .div__icon-label-input input:focus {
        outline: none;
    }

    button[type=submit] {
        width: 70%;
        margin-top: 1em;
    }

    .div__switch {
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
