import { defineStore } from "pinia";
import axios from "axios";
import { useMessageStore } from "@/store/useMessageStore.js";

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
        /**
         * recent3Matches
         * Retrieve 3 latest matches
         * @returns {*[]}
         */
        recent3Matches() {
            return this.responses.initialList.slice(0, 3);
        }
    },

    actions: {
        /**
         * requestInitialList
         * Request recent matches
         * @returns {Promise<void>}
         */
        async requestInitialList() {
            if (this.responses.initialList.length > 0) {
                return;
            }

            this.loadingState.initialList = true;
            try {
                let response = await axios.get('/matches/recent/');
                this.responses.initialList = response.data.data

            } catch (error) {
                useMessageStore().$patch({
                    errorMessages: { exception: 'Something went wrong, kindly refresh the page to try again.' }
                });

            } finally {
                this.loadingState.initialList = false;
            }
        },

        /**
         * requestFilteredList
         * Do Request filter results
         * @param filters
         * @returns {Promise<void>}
         */
        async requestFilteredList(filters) {
            this.loadingState.filteredList = true;

            try {
                let response = await axios.get('/matches/filter?' + new URLSearchParams(filters).toString())
                let filteredList = response.data.data;

                if (filteredList.length === 0) {
                    useMessageStore().$patch({
                        errorMessages: { exception: 'No match found with the filter, try other.' }
                    });
                }

                this.responses.filteredList = filteredList;

            } catch (error) {
                let errorBag = error.response.data;
                if (errorBag.hasOwnProperty('errors') === true) {
                    let errorMessages = [];
                    for (const item in errorBag.errors) {
                        errorMessages.push(errorBag.errors[item]);
                    }

                    errorMessages.flat(Infinity).forEach(function (message, index)  {
                        useMessageStore().errorMessages[index] = message;
                    })
                    return;
                }

                useMessageStore().$patch({
                    errorMessages: { exception: 'Something went wrong, kindly refresh the page before trying again.' }
                });

            } finally {
                this.loadingState.filteredList = false;

            }
        }
    }
})
