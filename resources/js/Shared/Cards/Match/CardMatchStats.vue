<script>
import {defineComponent, ssrContextKey} from 'vue'
import MatchStatsTable from "@/Shared/Cards/Match/MatchStatsTable.vue";

export default defineComponent({
    name: "CardMatchStats",
    components: { MatchStatsTable },
    props: {
        matchDetails: {
            type: Object,
            required: true
        }
    },

    computed: {
        homeScore() {
            return this.matchDetails.score[this.showScore + 'Time'].home;
        },

        awayScore() {
            return this.matchDetails.score[this.showScore + 'Time'].away;
        }
    },

    data() {
        return {
            showScore: 'full'
        }
    }
})
</script>

<template>
    <div class="match__stats card">
        <h4>Match Stats</h4>
        <hr>

        <h5>Scores</h5>
        <div class="score_toggle">
            <div>
                <input type="radio" id="half_time_radio" name="time_score" value="half" v-model="showScore">
                <label for="half_time_radio">Half Time</label>
            </div>

            <div>
                <input type="radio" id="half_full_radio" name="time_score" checked value="full" v-model="showScore">
                <label for="half_full_radio">Full Time</label>
            </div>
        </div>
        <div class="stats__item flex" ref="full_score">
            <img :src="matchDetails.homeTeam.crest" alt="">
            <Transition name="rollDown" mode="out-in">
                <span :key="homeScore" class="score">
                    {{ homeScore }}
                </span>
            </Transition>
            -
            <Transition name="rollDown" mode="out-in">
                <span :key="awayScore" class="score">
                    {{ awayScore }}
                </span>
            </Transition>
            <img :src="matchDetails.awayTeam.crest" alt="">
        </div>

        <hr>

        <h5>Stats Table</h5>
        <p class="text-info">Stats below are hard-coded data, not from API (due to free tier limitations)</p>

        <MatchStatsTable />
    </div>
</template>

<style scoped>
    .match__stats h4, h5 {
        margin-bottom: 0.7em;
    }

    .match__stats {
        width: 55%;
    }

    .stats__item.flex {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .score_toggle {
        margin: 1em 0 2em 0;
        display: flex;
        gap: 1rem;
    }

    .score_toggle button {
        margin-right: 1em;
    }

    .stats__item img {
        width: 100px;
    }

    .score {
        font-weight: bold;
        font-size: 2rem;
    }

    .text-info {
        color: red;
    }

    @media screen and (max-width: 580px) {
        .match__stats {
            width: 100%;
        }
    }
</style>
