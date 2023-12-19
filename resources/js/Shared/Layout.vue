<script>
import { defineComponent } from 'vue'
import { Link } from "@inertiajs/vue3";
import { useUserAuthStore } from "@/store/User/useUserAuthStore.js";
import { useMessageStore } from "@/store/useMessageStore.js";
import ErrorCard from "@/Shared/Util/ErrorCard.vue";
import SuccessCard from "@/Shared/Util/SuccessCard.vue";
import NavLinks from "@/Shared/NavLinks.vue";
import UserIcon from "@/Shared/Util/Icons/UserIcon.vue";
import HeaderIcon from "@/Shared/Util/Icons/HeaderIcon.vue";

export default defineComponent({
    name: "Layout",
    components: { HeaderIcon, UserIcon, NavLinks, SuccessCard, ErrorCard, Link },
    data() {
        return {
            showNavLinks: false,
            showNavUsers: false
        }
    },

    computed: {
        hasUser() {
            return this.$page.props.auth.user !== null;
        }
    },

    methods: {
        toggleNav(event, link) {
            let iconRefs = {
                showNavLinks: 'burgerIcon',
                showNavUsers: 'userIcon'
            }

            const triggerElement = this.$refs[iconRefs[link]];

            if (triggerElement.contains(event.target) === false) {
                return;
            }

            this[link] = !this[link];
            triggerElement.classList.toggle('active', this[link] === true);

            // display only one at a time
            const oppositeNav = link === 'showNavLinks' ? 'showNavUsers' : 'showNavLinks';
            this[oppositeNav] = false;
        },

        detectOutsideClick(event) {
            const burgerIcon = this.$refs.burgerIcon;
            const userIcon = this.$refs.userIcon;
            if (burgerIcon.contains(event.target) === false
                && userIcon.contains(event.target) === false) {

                this.showNavLinks = false;
                this.showNavUsers = false;
                burgerIcon.classList.remove('active');
                userIcon.classList.remove('active');
            }
        },

        abortRequestsOnLogout() {
            axios.defaults.abortController.abort('logout');

            // Reset the used AbortController, since they are one-time use only.
            const newAbortController = new AbortController();
            axios.defaults.abortController = newAbortController;
            axios.defaults.signal = newAbortController.signal;
        }
    },

    beforeMount() {
        // in case of page reload
        useUserAuthStore().$patch({ isAuthenticated: this.$page.props.auth.user !== null })
    },

    mounted() {
        document.addEventListener('click', this.detectOutsideClick);
    },

    beforeDestroy() {
        document.removeEventListener('click', this.detectOutsideClick);
    },

    watch: {
        // watch inertia's $page.props.auth.user (from shared)
        // can change when logging out/in
        '$page.props.auth.user': {
            handler(user) {
                useUserAuthStore().$patch({ isAuthenticated: user !== null })
            },
            deep: true
        },

        // watch inertia's $page.props.errors (from shared)
        // feed the value to useMessageStore() to be accessed by <ErrorCard>
        '$page.props.errors': {
            handler(errors) {
                useMessageStore().$patch({ errorMessages: errors })
            },
            deep: true
        }
    }
})
</script>

<template>
    <header class="header">
        <div class="header__left">
            <div class="header__burger" ref="burgerIcon" @click="toggleNav($event, 'showNavLinks')">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="header__logo">
                <!-- Logo -->
                <HeaderIcon />
                <strong>Football Portfolio</strong>
            </div>
        </div>
        <div class="header__right">
            <div class="header__nav-full">
                <!-- Nav Links -->
                <NavLinks />
            </div>
            <div class="header__user" ref="userIcon" @click="toggleNav($event, 'showNavUsers')">
                <!-- Auth -->
                <UserIcon width="35" height="35" viewBox="0 4 256 256" />
            </div>
        </div>
    </header>

    <Transition name="rollDown">
        <!-- v-show and :key is added together when toggling transition to avoid flickering when on "leave" transition state (??) -->
        <nav v-show="showNavLinks === true" :key="showNavLinks" class="nav__common" ref="navCommon">
            <NavLinks />
        </nav>
    </Transition>

    <Transition name="rollDown">
        <nav v-show="showNavUsers === true" :key="showNavUsers" class="nav__auth" ref="navAuth">
            <Link v-if="hasUser === true"
                  class="nav__a"
                  :class="{ 'nav-active' : $page.component === 'User/Settings' }"
                  href="/settings">User Settings</Link>
            <Link v-else
                  class="nav__a"
                  href="/login">Login</Link>

            <Link v-if="hasUser === true"
                  class="button__logout"
                  href="/logout"
                  method="delete"
                  as="button"
                  @click="abortRequestsOnLogout">Logout</Link>
            <Link v-else
                  class="nav__a"
                  href="/register">Register</Link>
        </nav>
    </Transition>
    <main class="main">
        <slot></slot>

        <SuccessCard />
        <ErrorCard />
    </main>

    <footer class="footer text-center">
        <p>Football data provided by the Football-Data.org API | Free Tier</p>
        <small>This application is for portfolio purposes only - Laurence Suarez</small>
    </footer>
</template>

<style scoped>
    .header {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 100;

        box-shadow: -1px -8px 14px 3px #dddddd;
        background-color: var(--header-bg);
        color: var(--body-bg);
        padding: 0.6em;

        display: flex;
        justify-content: space-between;
    }

    .header__left,
    .header__right {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        gap: 0.8em;
    }

    .header__burger {
        display: none;
        cursor: pointer;
    }

    .header__burger div {
        background-color: var(--body-bg);
        width: 20px;
        height: 3px;

        transition-property: transform, display;
        transition-duration: 0.2s;
    }

    .header__burger div:nth-child(2),
    .header__burger div:nth-child(3) {
        margin-top: 3px;
    }

    .header__burger.active div:nth-child(2) {
        display: none;
    }

    .header__burger.active div:first-child {
        transform: rotate(45deg) translateY(4px);
    }

    .header__burger.active div:last-child {
        transform: rotate(-45deg) translateY(-4px);
    }

    .header__logo {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        gap: 0.4em;
        font-size: 1.5rem;
    }

    .header__logo img {
        width: 40px;
    }

    .header__nav-full {
        display: flex;
        align-items: center;
        gap: 1em;
    }

    .header__user {
        height: 35px;
        background-color: var(--body-bg);
        border: 1px solid var(--body-bg);
        border-radius: 50%;
        cursor: pointer;
    }

    .nav__common,
    .nav__auth {
        z-index: 99;
        position: fixed;
        top: 0;
        width: 100%;

        background-color: var(--header-bg);
        border: none;

        display: flex;
        flex-direction: column;
        padding-top: 3.5em;

        transition-property: display;
        transition-duration: 0.2s;
    }

    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #000;
        color: var(--btn-text-color);
        padding: 0.8em;
        font-size: 0.7em;

        clear: both;
    }

    @media screen and (max-width: 860px) {
        .header__burger {
            display: block;
        }

        .header__nav-full {
            display: none;
        }

        .nav__common,
        .nav__auth {
            font-size: 1.2rem;
            padding-top: 3em;
        }
    }
</style>
