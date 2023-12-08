<script>
import {defineComponent} from 'vue'
import BookmarkCheckIcon from "@/Shared/Util/Icons/BookmarkCheckIcon.vue";
import BookmarkIcon from "@/Shared/Util/Icons/BookmarkIcon.vue";
import {useMatchBookmarkRequestStore} from "@/store/Bookmark/useMatchBookmarkRequestStore.js";
import LoadingIcon from "@/Shared/Util/Icons/LoadingIcon.vue";

export default defineComponent({
    name: "BookmarkButton",
    components: {LoadingIcon, BookmarkIcon, BookmarkCheckIcon},
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

    data() {
        return {
            bookmarkStore: {
                match: useMatchBookmarkRequestStore()
            }
        }
    },

    computed: {
        isToggleLoading() {
            return this.bookmarkStore[this.type].isToggleLoading[this.dataToBookmark.id];
        }
    },

    methods: {
        toggleBookmark() {
            const action = (this.isBookmarked === true) ? 'removeBookmark' : 'addBookmark'
            this.bookmarkStore[this.type][action](this.dataToBookmark);
        }
    }
})
</script>

<template>
    <button class="btn" @click="toggleBookmark">
        <Transition name="fade" mode="out-in">
            <LoadingIcon margin="0" width="20" height="20" v-if="isToggleLoading === true" />
            <BookmarkCheckIcon v-else-if="isBookmarked === true" />
            <BookmarkIcon v-else />
        </Transition>
    </button>
</template>

<style scoped>
    button {
        padding: 0.6em 0.5em 0.4em;
    }
</style>
