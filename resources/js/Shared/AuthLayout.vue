<script>
import { defineComponent } from 'vue'
import { Link } from "@inertiajs/vue3";
import GmailIcon from "@/Shared/Util/Icons/GmailIcon.vue";
import FacebookIcon from "@/Shared/Util/Icons/FacebookIcon.vue";

export default defineComponent({
    name: "AuthLayout",
    components: {FacebookIcon, GmailIcon, Link },
    computed: {
        currentPage() {
            return this.$page.component === 'User/Login' ? 'Login' : 'Register';
        }
    },

    methods: {
        redirectOauth(provider) {
            // document object is used to prevent CORS issue
            document.location = '/oauth/' + provider;
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

                <p class="text_info mt-1">Other Sign In Options</p>
                <div class="div__oauth mt-1">
                    <button class="btn btn_common" @click="redirectOauth('google')">
                        <GmailIcon />
                    </button>
                    <button class="btn btn_common" @click="redirectOauth('facebook')">
                        <FacebookIcon />
                    </button>
                </div>

                <div class="div__switch">
                    <hr>
                    <Link :href="currentPage === 'Login' ? '/register' : '/login'">
                        {{ currentPage === 'Login' ? 'Create' : 'Already got' }} an account?
                    </Link>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
    section.login__banner {
        width: 60%;
        margin: 7rem auto 0 auto;
    }

    .login__banner {
        display: flex;
        flex-wrap: nowrap;
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

    .div__oauth {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .div__oauth button {
        display: block;
        text-decoration: none;
        padding: 0.6em 1em;
        font-size: 0.7em;
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
