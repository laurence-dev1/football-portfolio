<script>
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/vue3'
import MatchItem from "@/Shared/ListItem/MatchItem.vue";
import MatchDashboard from "@/Pages/Dashboard/MatchDashboard.vue";

export default defineComponent({
    name: "Dashboard",
    components: { MatchDashboard, MatchItem, Head },
    data() {
        return {
            bookmarkTabs: ['Matches', 'Competitions', 'Teams', 'Persons'],
            activeTab: 'Matches',
        }
    }
})
</script>

<template>
    <div>
        <Head>
            <title>Dashboard</title>
        </Head>

        <h2>Here {{ $page.props.auth.user.name }}, Your Bookmarks!</h2>

        <div class="db__tabs">
            <button v-for="(tab, index) in bookmarkTabs"
                    :class="{'active_tab': tab === activeTab}"
                    :key="index"
                    @click="activeTab = tab">{{ tab }}</button>
        </div>

        <div class="contents">
            <Transition name="rollDown" mode="out-in">
                <MatchDashboard v-show="activeTab === 'Matches'" />
            </Transition>
        </div>
    </div>
</template>

<style scoped>
    .db__tabs {
        margin-top: 1em;

        display: flex;
        justify-content: space-evenly;
    }

    .db__tabs button {
        width: 20%;
        padding: 0.4em;

        background-color: transparent;
        border: 2px solid transparent;
        cursor: pointer;

        transition-property: border-bottom;
        transition-duration: 0.1s;
    }

    .db__tabs button:hover {
        border-bottom: 2px solid var(--btn-active-bg);
    }

    button.active_tab {
        border-bottom: 2px solid var(--border-bg);
        font-weight: bolder;
        color: var(--btn-hover-bg);
    }

    div.contents {
        margin-top: 0.4em;
        width: 100%;
        padding: 0.4em;
        border-radius: var(--border-radius);
        box-shadow: 0 0 15px 8px #dddddd;
    }
</style>
