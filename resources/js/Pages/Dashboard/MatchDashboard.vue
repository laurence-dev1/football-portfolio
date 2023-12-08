<script>
import { defineComponent } from 'vue'
import MatchItem from "@/Shared/ListItem/MatchItem.vue";
import { mapActions, mapState } from "pinia";
import { useMatchBookmarkRequestStore } from "@/store/Bookmark/useMatchBookmarkRequestStore.js";
import LoadingIcon from "@/Shared/Util/Icons/LoadingIcon.vue";
import { Link } from "@inertiajs/vue3";

export default defineComponent({
    name: "MatchDashboard",
    components: { LoadingIcon, MatchItem, Link },

    computed: {
        ...mapState(useMatchBookmarkRequestStore, {
            isListLoading: 'isListLoading',
            matchBookmarks: 'bookmarks'
        })
    },
    methods: { ...mapActions(useMatchBookmarkRequestStore, ['requestBookmarks']) },

    async mounted() {
        await this.requestBookmarks();
    }
})
</script>

<template>
    <div>
        <LoadingIcon margin="1rem" v-if="isListLoading === true" />

        <div v-if="isListLoading === false && matchBookmarks.length === 0"
             class="text-center list__item">
            No bookmarked matches, check out some <Link href="/search/matches">here</Link>.
        </div>
        <div class="list" v-else>
            <MatchItem
                v-for="match in matchBookmarks"
                :match-data="match" />
        </div>
    </div>
</template>

<style scoped>

</style>
