<script>
import {defineComponent} from 'vue'
import MatchItem from "@/Shared/ListItem/MatchItem.vue";
import {mapActions, mapState} from "pinia";
import { useMatchDashboardRequestStore } from "@/store/Dashboard/useMatchDashboardRequestStore.js";
import LoadingIcon from "@/Shared/Util/LoadingIcon.vue";
import { Link } from "@inertiajs/vue3";

export default defineComponent({
    name: "MatchDashboard",
    components: { LoadingIcon, MatchItem, Link },

    computed: { ...mapState(useMatchDashboardRequestStore, ['isLoading', 'matchBookmarks']) },
    methods: { ...mapActions(useMatchDashboardRequestStore, ['requestBookmarks']) },

    async mounted() {
        await this.requestBookmarks();
    }
})
</script>

<template>
    <div>
        <LoadingIcon v-if="isLoading === true" />
        <MatchItem
            v-for="match in matchBookmarks"
            :match-data="match" />

        <div v-if="isLoading === false && matchBookmarks.length === 0"
             class="text-center list__item">
            No bookmarked matches, check out some <Link href="/search/matches">here</Link>
        </div>
    </div>
</template>

<style scoped>

</style>
