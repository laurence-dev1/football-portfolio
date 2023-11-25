<script>
import { defineComponent } from 'vue'
import { Head, Link, useRemember } from "@inertiajs/vue3";
import axios from "axios";
import CompetitionSelect from "@/Shared/SearchFilters/CompetitionSelect.vue";
import DateRangePicker from "@/Shared/SearchFilters/DateRangePicker.vue";
import LoadingIcon from "@/Shared/Util/LoadingIcon.vue";
import MatchItem from "@/Shared/ListItem/MatchItem.vue";

export default defineComponent({
    name: "SearchMatches",
    components: { CompetitionSelect, DateRangePicker, Head, Link, LoadingIcon, MatchItem },
    props: { initialList: Array },

    data() {
        return {
            filters: {
                dateFrom: useRemember('', 'DateFrom'),
                dateTo: useRemember('', 'DateTo'),
                competitions: useRemember([], 'SelectedCompetitions')
            },
            showCompFilters: useRemember(false, 'ShowCompetitionFilter'),
            isSearching: false,
            searchResults: useRemember([], 'SearchResults')
        }
    },

    computed: {
        compFilterCnt() {
            return this.filters.competitions.length;
        }
    },

    methods: {
        searchMatch() {
            this.isSearching = true;
            axios.get('/matches?' + new URLSearchParams(this.filters).toString())
                .then(response => response.data)
                .then(response => {
                    if (response.matches.length === 0) {
                        alert('No match found with the filter, try other.');
                        return;
                    }

                    this.searchResults = response.matches;
                })
                .catch(response => {
                    let errorBag = response.response.data.errors;
                    let messages = [];
                    for (const input in errorBag) {
                        messages.push(errorBag[input]);
                    }

                    alert(messages.join("\n"))
                })
                .finally(() => this.isSearching = false);
        }
    }
})
</script>

<template>
    <Head>
        <title>Search Matches</title>
    </Head>

    <h2>Filter Matches</h2>
    <p class="text_info">API Features does not allow search (only filters), and date filter only allow 10-day difference.</p>

    <section class="main__group">
        <h4>Recent Matches (Last 3 Days)</h4>
    </section>

    <div v-if="initialList.length > 0">
        <template v-for="match in initialList">
            <MatchItem :matchData="match" />
        </template>
    </div>
    <div v-else class="list__item">
        <p>No matches found.</p>
    </div>

    <hr>

    <h2>Filters</h2>
    <p class="text_info">If date filters are not set, 1-week difference are applied by default.</p>
    <section class="section__filters">
        <DateRangePicker v-model:dateFrom="filters.dateFrom" v-model:dateTo="filters.dateTo" />

        <button class="btn btn_common"
                @click="showCompFilters = !showCompFilters">
            Filter Competition ({{ compFilterCnt }})
        </button>
        <button class="btn btn_common" @click="searchMatch" :disabled="isSearching">
            {{ isSearching === true ? 'Loading...' : 'Filter' }}
        </button>

    </section>

    <CompetitionSelect v-model:selectedBag="filters.competitions" v-show="showCompFilters" />

    <section>
        <LoadingIcon width="40" height="40" v-show="isSearching" />
        <div v-if="searchResults.length > 0">
            <template v-for="match in searchResults">
                <MatchItem :matchData="match" />
            </template>
        </div>
        <div v-else class="list__item">
            <p>Try searching for matches using the filters above.</p>
        </div>
    </section>

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
