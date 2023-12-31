<script>
import { defineComponent } from 'vue'
import { Head, Link } from "@inertiajs/vue3";
import CardMatchDetails from "@/Shared/Cards/Match/CardMatchDetails.vue";
import CardMatchStats from "@/Shared/Cards/Match/CardMatchStats.vue";
import MatchItem from "@/Shared/ListItem/MatchItem.vue";
import { mapActions, mapState } from "pinia";
import { useMatchListRequestStore } from "@/store/ListRequest/useMatchListRequestStore.js";
import { useMatchBookmarkRequestStore } from "@/store/Bookmark/useMatchBookmarkRequestStore.js";
import LoadingIcon from "@/Shared/Util/Icons/LoadingIcon.vue";

export default defineComponent({
    name: "MatchDetails",
    components: {LoadingIcon, MatchItem, CardMatchDetails, CardMatchStats, Head, Link },
    props: { matchDetails: Object },
    computed: {
        ...mapState(useMatchListRequestStore, {
            matchList: 'responses',
            matchLoadingState: 'loadingState'
        }),
        recentMatches() {
            return this.matchList.initialList.filter(match => match.id !== this.matchDetails.id);
        },

        resourceFound() {
            return this.matchDetails.hasOwnProperty('errorCode') === false;
        }
    },

    methods: {
        ...mapActions(useMatchListRequestStore, { matchReqInitialList: 'requestInitialList' }),
        ...mapActions(useMatchBookmarkRequestStore, { matchRequestBookmarks: 'requestBookmarks' })
    },

    mounted() {
        this.matchRequestBookmarks();
        this.matchReqInitialList();
    }
})
</script>

<template>
    <div>
        <Head>
            <title>{{ matchDetails.homeTeam.name }} - {{ matchDetails.awayTeam.name }} | View Match</title>
        </Head>

        <template v-if="resourceFound === true">
            <h2>Match Details</h2>
            <p class="text_info">Due to API Limitations (on free tier), limited details are retrieved.</p>

            <section class="main__group">
                <CardMatchStats :matchDetails="matchDetails" />
                <CardMatchDetails :matchDetails="matchDetails" />
            </section>
        </template>
        <div v-else class="list__item text-center">
            Match not found. Go Back to searching matches <Link href="/search/matches">here</Link>.
        </div>

        <div class="recent_matches">
            <h2>Check out other recent matches!</h2>
            <div class="list__card">
                <Transition name="fade" mode="out-in">
                    <LoadingIcon v-if="matchLoadingState.initialList === true" />
                    <div class="list" v-else-if="recentMatches.length > 0">
                        <MatchItem v-for="match in recentMatches"
                                   :matchData="match" :do-preserve-scroll="false" />
                    </div>
                    <div v-else class="list__item">
                        <p>No matches found.</p>
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .main__group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .recent_matches {
        margin-top: 1em;
    }

    @media screen and (max-width: 580px) {
        .main__group {
            flex-direction: column-reverse;
        }
    }
</style>
