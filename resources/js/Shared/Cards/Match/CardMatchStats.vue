<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CardMatchStats",
    props: {
        matchDetails: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            showScore: 'half'
        }
    },

    methods: {
        score(team) {
            return this.matchDetails.score[this.showScore + 'Time'][team];
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
                <input type="radio" id="half_time_radio" name="time_score" checked value="half" v-model="showScore">
                <label for="half_time_radio">Half Time</label>
            </div>

            <div>
                <input type="radio" id="half_full_radio" name="time_score" value="full" v-model="showScore">
                <label for="half_full_radio">Full Time</label>
            </div>
        </div>
        <div class="stats__item flex" ref="full_score">
            <img :src="matchDetails.homeTeam.crest" alt="">
            <span class="score">
                {{ score('home') }}
            </span> -
            <span class="score">
                {{ score('away') }}
            </span>
            <img :src="matchDetails.awayTeam.crest" alt="">
        </div>
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
        margin: 1em 0;
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

    input[type=radio] {
        display: none;
    }

    input[name=time_score] + label {
        padding: 0.5em;
        font-weight: bold;
        border: 1px solid var(--border-bg);
        border-radius: var(--border-radius);
        background-color: var(--primary-bg);

        transition-property: background-color;
        transition-duration: 0.2s;
    }

    input[name=time_score]:checked + label {
        background-color: var(--btn-bg);
        color: var(--btn-text-color);
    }

    @media screen and (max-width: 580px) {
        .match__stats {
            width: 100%;
        }
    }
</style>
