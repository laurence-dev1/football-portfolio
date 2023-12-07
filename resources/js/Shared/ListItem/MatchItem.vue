<script>
import {defineComponent} from 'vue'
import {Link, router} from "@inertiajs/vue3";
import date from "../../mixins/date.js";
import { useMatchDashboardRequestStore } from "@/store/Dashboard/useMatchDashboardRequestStore.js";
import {mapState} from "pinia";
import BookmarkButton from "@/Shared/Util/BookmarkButton.vue";

export default defineComponent({
    name: "MatchItem",
    components: {BookmarkButton, Link },
    props: {
        doPreserveScroll: true,

        matchData: {
            required: true,
            type: Object
        }
    },

    computed: {
        ...mapState(useMatchDashboardRequestStore, ['matchBookmarks']),

        formattedDate() {
            return date.formatUtcDate(this.matchData.utcDate);
        },

        isBookmarked() {
             return this.matchBookmarks.some(matchBookmark => matchBookmark.id === this.matchData.id);
        }
    },

    methods: {
        goToDetails(event) {
            if (this.$refs.hasOwnProperty('bookmarkDiv') === true &&
                this.$refs.bookmarkDiv.contains(event.target) === true) {
                // if the click event is within the bookmark button, redirection will not happen
                return;
            }

            router.get('/matches/' + this.matchData.id, {}, { preserveScroll: this.doPreserveScroll })
        }
    }
})
</script>

<template>
    <div class="list__item match__item" @click="goToDetails">

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
        <div class="match__data match__time text-center"
            :class="$page.props.auth.user !== null ? 'w-20p' : 'w-35p'">
            <strong>{{ matchData.status }}</strong>
            <span class="nowrap">{{ formattedDate }}</span>
        </div>
        <div v-if="$page.props.auth.user !== null" class="match__data w-15p" ref="bookmarkDiv">
            <BookmarkButton type="match" :dataToBookmark="matchData" :isBookmarked="isBookmarked" />
        </div>
    </div>
</template>

<style scoped>
    .match__data .club__crest {
        width: 50px;
    }

    .match__data .competition__emblem {
        width: 70px;
    }

    .match__data {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }

    .match__time {
        flex-direction: column
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
