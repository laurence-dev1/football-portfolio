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

            showBookmarkColumns: false
        }
    },

    methods: {
        toggleTabs(tabName) {
            this.activeTab = tabName;
            this.showBookmarkColumns = false;
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

        <section class="section__tabs-full mt-1">
            <div class="div__tab-full text-center"
                 :class="{ 'tab_active': tab === activeTab }"
                 v-for="(tab, index) in bookmarkTabs"
                 :key="index"
                 @click="activeTab = tab">
                {{ tab }}
            </div>
        </section>

        <section class="section__tabs-select mt-1">
            <div class="div__tab-toggle text-center" @click="showBookmarkColumns = !showBookmarkColumns">
                {{ activeTab }}
                <div class="down" :class="{ 'active' : showBookmarkColumns === true }">
                    <div></div>
                    <div></div>
                </div>
            </div>
            <Transition name="fade" mode="out-in">
                <div class="div__tab-column" v-if="showBookmarkColumns === true">
                    <div class="div__tab-select text-center"
                         :class="{ 'tab_active': tab === activeTab }"
                         v-for="(tab, index) in bookmarkTabs"
                         :key="index"
                         @click="toggleTabs(tab)">
                        {{ tab }}
                    </div>
                </div>
            </Transition>
        </section>

        <div class="list__card">
            <Transition name="fade" mode="out-in">
                <MatchDashboard v-show="activeTab === 'Matches'" />
            </Transition>
        </div>
    </div>
</template>

<style scoped>
    .section__tabs-full {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
    }

    .div__tab-full {
        width: 20%;
        background-color: var(--btn-bg);
        border: 1px solid var(--btn-bg);
        border-radius: var(--border-radius);
        padding: 0.5em;
        color: var(--body-bg);
        cursor: pointer;

        transition-property: background-color;
        transition-duration: 0.2s;
    }

    .div__tab-full:hover {
        background-color: var(--btn-hover-bg);
    }

    :is(.div__tab-full, .div__tab-select).tab_active {
        background-color: var(--btn-active-bg);
    }

    .section__tabs-select {
        display: none;
        width: 100%;

        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: var(--body-bg);

        position: relative;
    }

    .div__tab-column,
    .div__tab-toggle {
        width: 80%;
    }

    .div__tab-toggle {
        position: relative;
    }

    .down {
        position: absolute;
        transition-property: transform;
        transition-duration: 0.2s;
    }

    .down.active {
        transform: rotate(180deg) translate(-8px, 4px);
    }

    .down div {
        width: 15px;
        height: 3px;
        background-color: var(--body-bg);
    }

    .down div:first-child {
        transform: rotate(50deg);
    }

    .down div:last-child {
        transform: rotate(-50deg) translate(8px, 4px);
    }

    .div__tab-column {
        position: absolute;
        top: 3em;
    }

    .div__tab-select {
        background-color: var(--btn-hover-bg);
        border-top: 1px solid var(--body-bg);
    }

    .div__tab-select:hover,
    .div__tab-select:focus-visible {
        background-color: var(--btn-bg);
    }

    .div__tab-toggle {
        background-color: var(--btn-bg);
        border-radius: var(--border-radius);
    }

    .div__tab-column .div__tab-select:last-child {
        border-bottom-left-radius: var(--border-radius);
        border-bottom-right-radius: var(--border-radius);
    }

    @media screen and (max-width: 430px) {
        .section__tabs-full {
            display: none;
        }

        .section__tabs-select {
            display: flex;
        }

        .down {
            top: 1em;
            right: 1.2em;
        }

        .div__tab-column {
            top: 2em;
        }

        .div__tab-select,
        .div__tab-toggle {
            padding: 0.5em;
        }
    }

    @media screen and (min-width: 431px) and (max-width: 700px) {
        .section__tabs-full {
            display: none;
        }

        .section__tabs-select {
            display: flex;
        }

        .down {
            top: 1.5em;
            right: 1.2em;
        }

        .div__tab-select,
        .div__tab-toggle {
            padding: 1em;
        }
    }
</style>
