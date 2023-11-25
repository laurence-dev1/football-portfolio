import {defineStore} from "pinia";
import axios from "axios";

export const useMatchListRequestStore = defineStore('matchListRequest', {
    state() {
        return {
            loadingState: {
                initialList: false,
                filteredList: false
            },

            responses: {
                initialList: [],
                filteredList: []
            }
        }
    },

    getters: {

    },

    actions: {
        async requestInitialList(type) {
            this.loadingState.initialList = true;
            let response = await axios.get('/' + type);
            this.loadingState.initialList = false;

            if (response.status !== 200) {
                alert('Something went wrong, kindly refresh the page to try again.');
                return [];
            }

            this.responses.initialList = response.data.matches;
        },

        async requestFilteredLlist(filters) {
            this.loadingState.filteredList = true;
            let response = await axios.get('/matches/filter?' + new URLSearchParams(filters).toString())
            this.loadingState.filteredList = false;

            response = response.data;
            if (response.hasOwnProperty('errorCode') === true) {
                alert(response.message);
                return;
            }

            if (response.matches.length === 0) {
                alert('No match found with the filter, try other.');
                return;
            }

            this.responses.filteredList = response.matches;
        }
    }
})
