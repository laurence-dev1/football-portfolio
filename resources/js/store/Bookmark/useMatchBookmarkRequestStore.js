import { defineStore } from "pinia";
import axios from "axios";
import { useUserAuthStore } from "@/store/User/useUserAuthStore.js";
import { useMessageStore } from "@/store/useMessageStore.js";

export const useMatchBookmarkRequestStore = defineStore('matchBookmarkRequest', {
    state() {
        return {
            isListLoading: false,
            // isToggleLoading will serve as loadingState for when adding/removing bookmark
            // will be saved as an object { id: bool } to prevent other instances of <BookmarkButton> to update
            // added keys will be deleted after request so that keys will not stack when toggling multiple bookmarks
            isToggleLoading: {},
            bookmarks: []
        }
    },

    actions: {
        /**
         * requestBookmarks
         * Request list of match bookmarks
         * @returns {Promise<void>}
         */
        async requestBookmarks() {
            if (this.bookmarks.length > 0 || useUserAuthStore().isAuthenticated === false) {
                return;
            }

            this.isListLoading = true;

            try {
                let response = await axios.get('/bookmarks/matches');
                this.bookmarks = response.data.data;

            } catch (error) {
                useMessageStore().$patch({
                    errorMessages: { exception: 'Something went wrong in retrieving your bookmarked matches, kindly refresh the page to try again.' }
                });

            } finally {
                this.isListLoading = false;
            }
        },

        /**
         * addBookmark
         * Do request of adding bookmark
         * @param matchData
         * @returns {Promise<void>}
         */
        async addBookmark(matchData) {
            this.isToggleLoading[matchData.id] = true;

            try {
                await axios.post('/bookmarks/matches', {matchId: matchData.id});
                this.bookmarks.unshift(matchData);
                useMessageStore().$patch({
                    successMessages: { success: 'Match bookmark added!' }
                });

            } catch (error) {
                useMessageStore().$patch({
                    errorMessages: { exception: error.response.data.data.message }
                });

            } finally {
                delete this.isToggleLoading[matchData.id]
            }
        },

        /**
         * removeBookmark
         * Do request of removing bookmark
         * @param matchData
         * @returns {Promise<void>}
         */
        async removeBookmark(matchData) {
            if (confirm('Are you sure you want to remove the bookmark?') === false) {
                return;
            }

            this.isToggleLoading[matchData.id] = true;

            try {
                await axios.delete('/bookmarks/matches', {data: {matchId: matchData.id}});
                this.bookmarks = this.bookmarks.filter(bookmark => bookmark.id !== matchData.id);
                useMessageStore().$patch({
                    successMessages: { success: 'Match bookmark removed!' }
                });

            } catch (error) {
                useMessageStore().$patch({
                    errorMessages: { exception: error.response.data.data.message }
                });

            } finally {
                delete this.isToggleLoading[matchData.id]
            }
        }
    }
})
