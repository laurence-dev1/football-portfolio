import { defineStore } from "pinia";

export const useMessageStore = defineStore('messageStore', {
    state() {
        return {
            errorMessages: {},
            successMessages: {}
        }
    }
})
