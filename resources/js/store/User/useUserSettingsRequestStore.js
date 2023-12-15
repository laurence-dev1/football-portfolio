import { defineStore } from "pinia";
import axios from "axios";
import {useMessageStore} from "@/store/useMessageStore.js";

export const useUserSettingsRequestStore = defineStore('userSettingsRequest', {
    state() {
        return {
            loadingState: {
                info: false,
                password: false
            }
        }
    },

    actions: {
        isLoading() {
            return this.loadingState.info === true || this.loadingState.info === true;
        },

        /**
         * requestUpdateInfo
         * Send ajax request to update user info
         * @param userInfo
         * @returns {Promise<{}|boolean>}
         */
        async requestUpdateInfo(userInfo) {
            if (this.isLoading() === true) {
                return false;
            }

            this.loadingState.info = true;

            try {
                await axios.patch('/settings/info', userInfo);
                useMessageStore().successMessages = { success: 'Your user information has been updated!' }

            } catch (error) {
                this.handleException(error);

            } finally {
                this.loadingState.info = false;
            }
        },

        /**
         * requestUpdatePassword
         * @param passwordInfo
         * @returns {Promise<{}|boolean>}
         */
        async requestUpdatePassword(passwordInfo) {
            if (this.isLoading() === true || confirm('Proceed with updating password?') === false) {
                return false;
            }

            this.loadingState.password = true;
            try {
                await axios.patch('/settings/password', passwordInfo);
                useMessageStore().successMessages = { success: 'Your password has been updated!' }

            } catch (error) {
                this.handleException(error);

            } finally {
                this.loadingState.password = false;
            }
        },

        /**
         * handleException
         * @param error
         * @returns {{}}
         */
        handleException(error) {
            let errorResponse = error.response;
            if (errorResponse.status === 422) {
                let errorBag = errorResponse.data.errors;
                let errorMessages = {};
                for (const errorKey in errorBag) {
                    errorMessages[errorKey] = errorBag[errorKey][0];
                }
                return useMessageStore().errorMessages = errorMessages;
            }

            useMessageStore().errorMessages = errorResponse.data.data
        }
    }
})
