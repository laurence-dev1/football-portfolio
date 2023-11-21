<script>
import {defineComponent} from 'vue'
import { Link } from "@inertiajs/vue3";

export default defineComponent({
    name: "Layout",
    components: { Link },
    data() {
        return {
            showLinks: false
        }
    },

    methods: {
        toggleNav() {
            this.showLinks = !this.showLinks;
            this.$refs.links.style.display = (this.showLinks === true) ? 'flex' : 'none';
        }
    }
})
</script>

<template>

    <header class="header">
        <h1 class="header__title text-center">🏃‍♂️ Football Portfolio ⚽</h1>
        <nav class="header__nav">
            <section class="header__dashboard">
                <Link href="/">Dashboard</Link>
            </section>
            <section class="header__browse">
                <p @click="toggleNav">Browse</p>
                <ul class="header__links" ref="links">
                    <li><Link href="/search/matches">Matches</Link></li>
                    <li><Link href="/search/competitions">Competitions</Link></li>
                    <li><Link href="/search/teams">Teams</Link></li>
                    <li><Link href="/search/persons">Person</Link></li>
                    <!--<li><Link class="auth__link" href="/login">Login</Link></li>-->
                </ul>
            </section>

        </nav>
    </header>

    <main class="main">
        <slot></slot>
    </main>

    <footer class="footer text-center">
        <p>For Portfolio Purposes - Laurence Suarez | Credit - All Data from www.football-data.org (Free)</p>
    </footer>
</template>

<style scoped>

</style>
