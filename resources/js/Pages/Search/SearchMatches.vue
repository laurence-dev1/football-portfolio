<script>
import { defineComponent } from 'vue'
import { Head, Link, useRemember } from "@inertiajs/vue3";
import CompetitionSelect from "@/Shared/SearchFilters/CompetitionSelect.vue";
import DateRangePicker from "@/Shared/SearchFilters/DateRangePicker.vue";
import LoadingIcon from "@/Shared/Util/LoadingIcon.vue";
import MatchItem from "@/Shared/ListItem/MatchItem.vue";

import { mapActions, mapState } from "pinia";
import { useMatchListRequestStore } from "@/store/ListRequest/useMatchListRequestStore.js";

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
            matchResponses: 'responses'
        }),

        competitionFilterCount() {
            return this.filters.competitions.length;
        }
    },

    methods: {
        ...mapActions(useMatchListRequestStore, {
            matchReqInitialList: 'requestInitialList',
            matchReqFilteredList: 'requestFilteredLlist'
        }),

        filterMatches() {
            this.matchReqFilteredList(this.filters);
        }
    },

    async mounted() {
        await this.matchReqInitialList('matches');
    }
})
</script>

<template>
    <div>
        <Head>
            <title>Search Matches</title>
        </Head>

        <h2>Filter Matches</h2>
        <p class="text_info">API Features does not allow search (only filters), and date filter only allow 10-day difference.</p>

        <section class="main__group">
            <h4>Recent Matches (Last 3 Matches, from last 3 days)</h4>
        </section>

        <div v-if="matchResponses.initialList.length > 0">
            <template v-for="match in matchResponses.initialList">
                <MatchItem :matchData="match" />
            </template>
        </div>
        <div v-else class="list__item">
            <LoadingIcon v-if="matchLoadingState.initialList === true" />
            <p v-else>No matches found.</p>
        </div>

        <hr>

        <h2>Filters</h2>
        <p class="text_info">If date filters are not set, 1-week difference are applied by default.</p>
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
            <div v-if="matchResponses.filteredList.length > 0">
                <template v-for="match in matchResponses.filteredList">
                    <MatchItem :matchData="match" />
                </template>
            </div>
            <div v-else class="list__item">
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

    .section__filters button {
        padding: 0.8em;
    }

    .section__filters button:disabled {
        background-color: var(--btn-disable-bg);
        cursor: not-allowed;
    }
</style>
