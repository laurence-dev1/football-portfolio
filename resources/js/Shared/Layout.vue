<script>
import {defineComponent} from 'vue'
import { Link } from "@inertiajs/vue3";
import { useMatchListRequestStore } from "@/store/ListRequest/useMatchListRequestStore.js";

export default defineComponent({
    name: "Layout",
    components: { Link },
    data() {
        return {
            navLinks: ['Matches', 'Competitions', 'Teams', 'Persons'],
            showLinks: false
        }
    },

    computed: {
        hasUser() {
            return this.$page.props.auth.user !== null;
        }
    },

    methods: {
        toggleNav() {
            this.showLinks = !this.showLinks;
            this.$refs.links.style.display = (this.showLinks === true) ? 'flex' : 'none';
        },

        resetLists(type) {
            let stores = {
                matches: useMatchListRequestStore()
            }

            stores[type].$reset();
        }
    }
})
</script>

<template>

    <header class="header">
        <h3 class="header__title text-center">
            <img src="../../img/header_icon.png" alt="">
            Football Portfolio
        </h3>
        <nav class="header__nav">
            <section class="header__dashboard">
                <div v-if="hasUser === true">
                    <Link href="/">Dashboard</Link>
                    <Link class="auth__link btn_logout"
                          href="/logout"
                          method="delete" as="button">Logout</Link>
                </div>

                <div v-else>
                    <Link class="auth__link" href="/login">Login</Link>
                    <Link class="auth__link" href="/register">Register</Link>
                </div>
            </section>
            <section class="header__browse">
                <p @click="toggleNav">Browse</p>
                <ul class="header__links" ref="links">
                    <li v-for="(link, index) in navLinks" :key="index">
                        <Link
                            :href="'/search/' + link.toLowerCase()"
                            @click="resetLists(link.toLowerCase())">
                            {{ link }}
                        </Link>
                    </li>
                </ul>
            </section>

        </nav>
    </header>

    <main class="main">
        <slot></slot>
    </main>

    <footer class="footer text-center">
        <p>For Portfolio Purposes - Laurence Suarez | Credit - All Data from www.football-data.org (Free Tier)</p>
    </footer>
</template>

<style scoped>

</style>
