<script>
import { defineComponent } from 'vue'
import { Head, Link } from "@inertiajs/vue3";
import date from "@/mixins/date.js";
import CardMatchDetails from "@/Shared/Cards/Match/CardMatchDetails.vue";
import CardMatchStats from "@/Shared/Cards/Match/CardMatchStats.vue";

export default defineComponent({
    name: "MatchDetails",
    components: { CardMatchDetails, CardMatchStats, Head, Link },
    props: { matchDetails: Object },
    mixins: [ date ],
    computed: {
        date() {
            return date;
        },

        resourceFound() {
            return this.matchDetails.hasOwnProperty('errorCode') === false;
        }
    },

    mounted() {
        console.log(this.matchDetails)
    }
})
</script>

<template>
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
</template>

<style scoped>
    .main__group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    @media screen and (max-width: 580px) {
        .main__group {
            flex-direction: column-reverse;
        }
    }
</style>
