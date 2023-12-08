<script>
import { defineComponent } from 'vue'
import { Head, Link, useRemember } from "@inertiajs/vue3";
import CompetitionSelect from "@/Shared/SearchFilters/CompetitionSelect.vue";
import DateRangePicker from "@/Shared/SearchFilters/DateRangePicker.vue";
import LoadingIcon from "@/Shared/Util/Icons/LoadingIcon.vue";
import MatchItem from "@/Shared/ListItem/MatchItem.vue";

import { mapActions, mapState } from "pinia";
import { useMatchListRequestStore } from "@/store/ListRequest/useMatchListRequestStore.js";
import { useMatchBookmarkRequestStore } from "@/store/Bookmark/useMatchBookmarkRequestStore.js";

export default defineComponent({
    name: "SearchMatches",
    components: { CompetitionSelect, DateRangePicker, Head, Link, LoadingIcon, MatchItem },

    data() {
        return {
            filters: {
                dateFrom: useRemember('', 'DateFrom'),
                dateTo: useRemember('', 'DateTo'),
                competitions: useRemember([], 'SelectedCompetitions')
            },

            showCompetitionFilters: useRemember(false, 'ShowCompetitionFilters')
        }
    },

    computed: {
        ...mapState(useMatchListRequestStore, {
            matchLoadingState: 'loadingState',
            matchResponses: 'responses',
            recent3Matches: 'recent3Matches'
        }),

        competitionFilterCount() {
            return this.filters.competitions.length;
        }
    },

    methods: {
        ...mapActions(useMatchListRequestStore, {
            matchReqInitialList: 'requestInitialList',
            matchReqFilteredList: 'requestFilteredList'
        }),

        ...mapActions(useMatchBookmarkRequestStore, { matchRequestBookmarks: 'requestBookmarks' }),

        filterMatches() {
            this.matchReqFilteredList(this.filters);
        }
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
            <title>Search Matches</title>
        </Head>

        <h2>Filter Matches</h2>
        <p class="text_info">API Features does not allow search (only filters), and date filter only allow 10-Day Difference.</p>

        <section class="main__group">
            <h4>Recent/Upcoming Matches (From the last 3 days)</h4>
        </section>

        <div v-if="recent3Matches.length > 0">
            <div class="list mt-1">
                <MatchItem v-for="match in recent3Matches" :matchData="match" />
            </div>
        </div>
        <LoadingIcon v-else-if="matchLoadingState.initialList === true" />
        <div v-else class="list__item mt-1">
            <p>No matches found.</p>
        </div>

        <hr>

        <h2>Filters</h2>
        <p class="text_info">If date filters are not set, 1-Week Difference are applied by default.</p>
        <section class="section__filters">
            <DateRangePicker v-model:dateFrom="filters.dateFrom" v-model:dateTo="filters.dateTo" />

            <button class="btn btn_common"
                    @click="showCompetitionFilters = !showCompetitionFilters">
                Filter Competition ({{ competitionFilterCount }})
            </button>
            <button class="btn btn_common" @click="filterMatches" :disabled="matchLoadingState.filteredList === true">
                {{ matchLoadingState.filteredList === true ? 'Loading...' : 'Filter' }}
            </button>

        </section>

        <CompetitionSelect v-model:selectedBag="filters.competitions" v-show="showCompetitionFilters" />

        <section>
            <LoadingIcon v-if="matchLoadingState.filteredList === true" />
            <div class="list mt-1" v-if="matchResponses.filteredList.length > 0">
                <template v-for="match in matchResponses.filteredList">
                    <MatchItem :matchData="match" />
                </template>
            </div>
            <div v-else class="list__item mt-1">
                <p>Try searching for matches using the filters above.</p>
            </div>
        </section>
    </div>

</template>

<style scoped>
    .section__filters {
        margin-top: 1.5em;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .section__filters button:disabled {
        background-color: var(--btn-disable-bg);
        cursor: not-allowed;
    }
</style>
