import { defineStore } from "pinia";

export const useAuthStore = defineStore('authStore', {
    state() {
        return {
            isAuthenticated: false
        }
    }
})
