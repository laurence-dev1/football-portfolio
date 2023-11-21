<script>
import { defineComponent } from 'vue'
import { Head, Link } from "@inertiajs/vue3";
import MatchItem from "@/Shared/ListItem/MatchItem.vue";
import axios from "axios";
import CompetitionSelect from "@/Shared/SearchFilters/CompetitionSelect.vue";
import LoadingIcon from "@/Shared/Util/LoadingIcon.vue";

export default defineComponent({
    name: "SearchMatches",
    components: { CompetitionSelect, Head, Link, LoadingIcon, MatchItem },
    props: { initialList: Array },

    data() {
        return {
            filters: {
                dateFrom: '',
                dateTo: '',
                competitions: []
            },
            showCompFilters: false,
            isSearching: false,
            searchResults: []
        }
    },

    computed: {
        compFilterCnt() {
            return this.filters.competitions.length;
        }
    },

    methods: {
        validateDates() {
            if (this.filters.dateFrom === '' || this.filters.dateTo === '') {
                return null;
            }

            let dateFrom = new Date(this.filters.dateFrom);
            let dateTo = new Date(this.filters.dateTo);

            if (dateFrom > dateTo) {
                alert('"From Date" should be less than "To Date"');
                return false;
            }

            if (new Date(dateTo.getTime() - dateFrom.getTime()).getUTCDate() > 10) {
                alert('Date difference should be less than or equal to 10');
                return false;
            }

            return true;
        },


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
    <p class="main__p">API Features does not allow search (only filters), and date filter only allow 10-day difference.</p>

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
    <p class="main__p">If date filters are not set, 1-week difference are applied by default.</p>
    <section class="section__filters">
        <div class="filter__item">
            <label for="dateFrom">From:</label>
            <input type="date" id="dateFrom" v-model="filters.dateFrom" @change="validateDates">
        </div>

        <div class="filter__item">
            <label for="dateTo">Up To:</label>
            <input type="date" id="dateTo" v-model="filters.dateTo" @change="validateDates">
        </div>

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
    .main__p {
        font-size: 0.8rem;
        margin-top: 0.2em;
    }

    .section__filters {
        margin-top: 1em;
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

    .filter__item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section__filters input[type=date] {
        border: 1px solid var(--border-bg);
        border-radius: var(--border-radius);
        background-color: var(--primary-bg);
        padding: 0.8em;
        font-size: inherit;
    }

</style>
