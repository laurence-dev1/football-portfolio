import { defineStore } from "pinia";

export const useUserAuthStore = defineStore('userAuthStore', {
    state() {
        return {
            isAuthenticated: false
        }
    }
})
