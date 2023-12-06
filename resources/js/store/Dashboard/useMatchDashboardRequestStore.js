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
        async requestBookmarks() {
            this.isLoading = true;

            try {
                let response = await axios.get('/bookmarks/matches');
                this.matchBookmarks = response.data.data;

            } catch (error) {
                this.$page.props.errors = {error: 'Something went wrong in retrieving your bookmarked matches, kindly refresh the page to try again.'}

            } finally {
                this.isLoading = false;
            }
        },

        async addBookmark(matchId) {
            this.isLoading = true;

            try {
                await axios.post('/bookmarks/matches', {matchId: matchId});
                alert('Match added!');

            } catch (error) {
                this.$page.props.errors = {error: 'Something went wrong in adding the match into your bookmarks, kindly refresh the page to try again.'}

            } finally {
                this.isLoading = false;
            }
        },

        async removeBookmark(matchId) {
            this.isLoading = true;

            try {
                await axios.delete('/bookmarks/matches', {
                    data: {matchId: matchId}
                });
                alert('Match removed!');

            } catch (error) {
                this.$page.props.errors = {error: 'Something went wrong in removing the match into your bookmarks, kindly refresh the page to try again.'}

            } finally {
                this.isLoading = false;
            }
        }
    }
})
