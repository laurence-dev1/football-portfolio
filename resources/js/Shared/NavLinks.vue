<script>
import { defineComponent } from 'vue'
import { useMatchListRequestStore } from "@/store/ListRequest/useMatchListRequestStore.js";
import { Link } from "@inertiajs/vue3";

export default defineComponent({
    name: "NavLinks",
    components: { Link },
    data() {
        return {
            navLinks: [
                { name: 'Matches',      url: '/search/matches' },
                { name: 'Competitions', url: '/search/competitions' },
                { name: 'Teams',        url: '/search/teams' },
                { name: 'Persons',      url: '/search/persons' },
            ]
        }
    },

    computed: {
        hasUser() {
            return this.$page.props.auth.user !== null;
        }
    },

    methods: {
        resetLists(type) {
            let stores = {
                matches: useMatchListRequestStore()
            }

            // when navigating via navbar, used (if any) search filters are not persisted,
            // with this, for ui consistency, the lists from store will be reset
            stores[type].$reset();
        }
    }
})
</script>

<template>
    <Link v-if="hasUser === true"
          class="nav__a"
          :class="{'nav-active' : $page.component === 'Dashboard/MainDashboard'}"
          href="/">Dashboard</Link>
    <Link v-for="(navLink, index) in navLinks" :key="index"
        :href="navLink.url"
        class="nav__a"
        @click="resetLists(navLink.name.toLowerCase())"
        :class="{'nav-active': $page.url === navLink.url }">
        {{ navLink.name }}
    </Link>
</template>

<style scoped>

</style>
