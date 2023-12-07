<script>
import {defineComponent} from 'vue'
import BookmarkCheckIcon from "@/Shared/Util/Icons/BookmarkCheckIcon.vue";
import BookmarkIcon from "@/Shared/Util/Icons/BookmarkIcon.vue";
import {mapActions} from "pinia";
import {useMatchDashboardRequestStore} from "@/store/Dashboard/useMatchDashboardRequestStore.js";

export default defineComponent({
    name: "BookmarkButton",
    components: {BookmarkIcon, BookmarkCheckIcon},
    props: {
        type: {
            required: true,
            type: String
        },

        dataToBookmark: {
            required: true,
            type: Object
        },

        isBookmarked: {
            required: true,
            type: Boolean
        }
    },

    methods: {
        ...mapActions(useMatchDashboardRequestStore, {
            matchAddBookmark: 'addBookmark',
            matchDelBookmark: 'removeBookmark'
        }),

        toggleBookmark() {
            const storeMethod = (this.isBookmarked === true) ? `${this.type}DelBookmark` : `${this.type}AddBookmark`;
            this[storeMethod](this.dataToBookmark);
        }
    }
})
</script>

<template>
    <button class="btn" @click="toggleBookmark">
        <Transition name="fade" mode="out-in">
            <BookmarkCheckIcon v-if="isBookmarked === true" />
            <BookmarkIcon v-else />
        </Transition>
    </button>
</template>

<style scoped>
    button {
        padding: 0.6em 0.5em 0.4em;
    }
</style>
