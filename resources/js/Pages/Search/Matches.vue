<script>
import { defineComponent } from 'vue'
import { Head, Link } from "@inertiajs/vue3";
import axios from "axios";

export default defineComponent({
    name: "SearchMatches",
    components: { Head, Link },
    props: { initialList: Array },

    data() {
        return {
            filters: {
                dateFrom: '',
                dateTo: ''
            },
            searchResults: []
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

        formatDate(rawDate) {
            let date = new Date(rawDate);
            let values = [date.getMonth(), date.getDate(), date.getFullYear()]

            return values.join(' / ');
        },

        searchMatch() {
            axios.get('/matches?' + new URLSearchParams(this.filters).toString())
                .then(response => response.data)
                .then(response => {
                    if (response.matches.length === 0) {
                        alert('No match found with the filter, try again');
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
        }
    }
})
</script>

<template>
    <Head>
        <title>Search Matches</title>
    </Head>

    <h2>Search Matches</h2>
    <p class="main__p">* API Features only allow filters, and date filter only allow 10-day difference.</p>

    <section class="main__group">
        <h4>Recent Matches (Last 3 Days)</h4>
    </section>

    <div v-if="initialList.length > 0">
        <Link v-for="item in initialList"
              :href="'/match/' + item.id"
              class="list__item match__item">

            <div class="match__data w-25p">
                <img class="club__crest"
                     :src="item.homeTeam.crest"
                     :alt="item.homeTeam.name"
                     :title="item.homeTeam.name">

                <span>vs</span>

                <img class="club__crest"
                     :src="item.awayTeam.crest"
                     :alt="item.awayTeam.name"
                     :title="item.awayTeam.name">
            </div>
            <div class="match__data w-15p text-center">{{ item.score.fullTime.away }} - {{ item.score.fullTime.home }}</div>
            <div class="match__data w-20p text-center">
                <img class="competition__emblem"
                    :src="item.competition.emblem"
                    :alt="item.competition.name"
                    :title="item.competition.name">
            </div>
            <div class="match__data w-40p text-center">
                {{ item.status + ' | ' + formatDate(item.utcDate) }}
            </div>
        </Link>
    </div>
    <div v-else class="list__item">
        <p>No matches found.</p>
    </div>

    <hr>

    <h4>Filter Matches</h4>
    <section class="section__filters">
        <div class="filter__item">
            <label for="dateFrom">From:</label>
            <input type="date" id="dateFrom" v-model="filters.dateFrom" @change="validateDates">
        </div>

        <div class="filter__item">
            <label for="dateTo">To:</label>
            <input type="date" id="dateTo" v-model="filters.dateTo" @change="validateDates">
        </div>
        <button class="btn btn_unique" @click="searchMatch">Filter</button>
    </section>

    <section>
        <div v-show="searchResults.length > 0">
            <Link v-for="item in searchResults"
                  :href="'/match/' + item.id"
                  class="list__item match__item">

                <div class="match__data w-25p">
                    <img class="club__crest"
                         :src="item.homeTeam.crest"
                         :alt="item.homeTeam.name"
                         :title="item.homeTeam.name">

                    <span>vs</span>

                    <img class="club__crest"
                         :src="item.awayTeam.crest"
                         :alt="item.awayTeam.name"
                         :title="item.awayTeam.name">
                </div>
                <div class="match__data w-15p text-center">{{ item.score.fullTime.home }} - {{ item.score.fullTime.away }}</div>
                <div class="match__data w-20p text-center">
                    <img class="competition__emblem"
                         :src="item.competition.emblem"
                         :alt="item.competition.name"
                         :title="item.competition.name">
                </div>
                <div class="match__data w-40p text-center">
                    {{ item.status + ' | ' + formatDate(item.utcDate) }}
                </div>
            </Link>
        </div>
    </section>

</template>

<style scoped>
    /* common */
    .main__p {
        font-size: 0.8rem;
        margin-top: 0.2em;
        font-style: italic;
    }

    .section__filters {
        margin-top: 1em;
        display: flex;
        gap: 1rem;
    }

    .filter__item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .section__filters input[type=date] {
        border: 2px solid var(--darkHover);
        border-radius: var(--borderRadius);
        padding: 0.8em;
        font-size: inherit;
    }

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


</style>
