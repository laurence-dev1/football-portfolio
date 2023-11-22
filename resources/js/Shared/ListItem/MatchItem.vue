<script>
import {defineComponent} from 'vue'
import { Link } from "@inertiajs/vue3";

export default defineComponent({
    name: "MatchItem",
    components: { Link },
    props: {
        matchData: {
            required: true,
            type: Object
        }
    },

    methods: {
        formatDate(rawDate) {
            let date = new Date(rawDate);
            let values = [date.getMonth() + 1, date.getDate(), date.getFullYear()]

            return values.join(' / ');
        },
    }
})
</script>

<template>
    <Link :href="'/match/' + matchData.id"
          class="list__item match__item">

        <div class="match__data w-35p">
            <img class="club__crest"
                 :src="matchData.homeTeam.crest"
                 :alt="matchData.homeTeam.name"
                 :title="matchData.homeTeam.name">

            <span>vs</span>

            <img class="club__crest"
                 :src="matchData.awayTeam.crest"
                 :alt="matchData.awayTeam.name"
                 :title="matchData.awayTeam.name">

        </div>
        <div class="match__data w-10p text-center">{{ matchData.score.fullTime.home }} - {{ matchData.score.fullTime.away }}</div>
        <div class="match__data w-20p text-center">
            <img class="competition__emblem"
                 :src="matchData.competition.emblem"
                 :alt="matchData.competition.name"
                 :title="matchData.competition.name">
        </div>
        <div class="match__data w-35p text-center">
            {{ matchData.status + ' | ' + formatDate(matchData.utcDate) }}
        </div>
    </Link>
</template>

<style scoped>
    .match__data .club__crest {
        width: 50px;
    }

    .match__data .competition__emblem {
        width: 70px;
    }

    .match__data{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }

    @media screen and (max-width: 580px) {
        .match__item {
            font-size: 0.6rem;
        }

        .match__data .club__crest {
            width: 35px;
        }

        .match__data .competition__emblem {
            width: 45px;
        }
    }
</style>
