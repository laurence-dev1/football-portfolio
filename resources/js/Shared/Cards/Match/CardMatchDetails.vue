<script>
import { defineComponent } from 'vue'
import date from "@/mixins/date.js";
import BookmarkButton from "@/Shared/Util/BookmarkButton.vue";

export default defineComponent({
    name: "CardMatchDetails",
    components: { BookmarkButton },
    props: {
        matchDetails: {
            type: Object,
            required: true
        }
    },

    computed: {
        formattedDate() {
            return date.formatUtcDate(this.matchDetails.utcDate);
        }
    }
})
</script>

<template>
    <div class="match__details card">
        <div class="details__head">
            <h4>Match Details</h4>
            <BookmarkButton :dataToBookmark="matchDetails" type="match" />
        </div>
        <hr>

        <div class="details__item flex">
            <div>
                <h5>Home Team</h5>
                {{ matchDetails.homeTeam.name }} ({{ matchDetails.homeTeam.tla }})
            </div>
            <img :src="matchDetails.homeTeam.crest" alt="">
        </div>

        <div class="details__item flex">
            <div>
                <h5>Away Team</h5>
                {{ matchDetails.awayTeam.name }} ({{ matchDetails.awayTeam.tla }})
            </div>
            <img :src="matchDetails.awayTeam.crest" alt="">
        </div>

        <div class="details__item flex">
            <div>
                <h5>Area</h5>
                {{ matchDetails.area.name }}
            </div>
            <img :src="matchDetails.area.flag" alt="">
        </div>

        <div class="details__item flex">
            <div>
                <h5>Competition</h5>
                {{ matchDetails.competition.name }}
            </div>
            <img :src="matchDetails.competition.emblem" alt="">
        </div>

        <div class="details__item" v-if="matchDetails.hasOwnProperty('venue') === true">
            <h5>Venue</h5>
            {{ matchDetails.venue }}
        </div>

        <div class="details__item">
            <h5>Type</h5>
            {{ matchDetails.competition.type }}
        </div>

        <div class="details__item">
            <h5>Match Day</h5>
            No. {{ matchDetails.matchday }}
        </div>

        <div class="details__item">
            <h5>Status</h5>
            {{ matchDetails.status }}
        </div>

        <div class="details__item">
            <h5>Date</h5>
            {{ formattedDate }}
        </div>

        <div class="details__item" v-if="matchDetails.hasOwnProperty('referees') === true && matchDetails.referees.length > 0">
            <h5>Referee/s</h5>
            <ul>
                <li v-for="referees in matchDetails.referees" :key="referees.id">
                    {{ referees.name }}
                </li>
            </ul>
        </div>

        <hr>

        <h4>Season Details</h4>
        <hr>

        <div class="details__item">
            <h5>Current Match Day</h5>
            No. {{ matchDetails.season.currentMatchday }}
        </div>

        <div class="details__item">
            <h5>Duration</h5>
            {{ matchDetails.season.startDate.replaceAll('-', ' / ') }} - {{ matchDetails.season.endDate.replaceAll('-', ' / ') }}
        </div>

    </div>
</template>

<style scoped>
    .match__details h4 {
        margin-bottom: 0.7em;
    }

    .match__details {
        width: 40%;
    }

    .details__head {
        display: flex;
        justify-content: space-between;
        flex-wrap: nowrap;
    }

    .match__details .details__item {
        margin-bottom: 1em;
    }

    .details__item.flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .details__item img {
        width: 50px;
    }

    ul {
        list-style-type: none;
    }

    @media screen and (max-width: 580px) {
        .match__details {
            width: 100%;
        }
    }
</style>
