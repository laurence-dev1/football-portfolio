import { defineStore } from "pinia";
import axios from "axios";

export const useMatchDashboardRequestStore = defineStore('matchDashboardRequest', {
    state() {
        return {
            isLoading: false,
            matchBookmarks: []
        }
    },

    actions: {
        /**
         * requestBookmarks
         * Request list of match bookmarks
         * @returns {Promise<void>}
         */
        async requestBookmarks() {
            if (this.matchBookmarks.length > 0) {
                return;
            }

            this.isLoading = true;

            try {
                let response = await axios.get('/bookmarks/matches');
                this.matchBookmarks = response.data.data;

            } catch (error) {
                alert('Something went wrong in retrieving your bookmarked matches, kindly refresh the page to try again.');

            } finally {
                this.isLoading = false;
            }
        },

        /**
         * addBookmark
         * Do request of adding bookmakr
         * @param matchData
         * @returns {Promise<void>}
         */
        async addBookmark(matchData) {
            this.isLoading = true;

            try {
                await axios.post('/bookmarks/matches', {matchId: matchData.id});
                this.matchBookmarks.unshift(matchData);
                alert('Match bookmark added!');

            } catch (error) {
                alert(error.response.data.data.message);

            } finally {
                this.isLoading = false;
            }
        },

        /**
         * removeBookmark
         * Do request of removing bookmark
         * @param matchData
         * @returns {Promise<void>}
         */
        async removeBookmark(matchData) {
            this.isLoading = true;

            try {
                await axios.delete('/bookmarks/matches', {data: {matchId: matchData.id}});
                this.matchBookmarks = this.matchBookmarks.filter(bookmark => bookmark.id !== matchData.id);
                alert('Match bookmark removed!');

            } catch (error) {
                alert(error.response.data.data.message);

            } finally {
                this.isLoading = false;
            }
        }
    }
})
