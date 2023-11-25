<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "CompetitionSelect",
    props: {
        selectedBag: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            competitions: [
                { id: 2014, code: 'PD', caption: 'La Liga', checked: false },
                { id: 2021, code: 'PL', caption: 'Premier League', checked: false },
                { id: 2002, code: 'BL1', caption: 'Bundesliga', checked: false },
                { id: 2019, code: 'SA', caption: 'Serie A', checked: false },
                { id: 2015, code: 'FL1', caption: 'Ligue 1', checked: false },
                { id: 2001, code: 'CL', caption: 'UEFA Champion\'s League', checked: false },
                { id: 2000, code: 'WC', caption: 'FIFA World Cup', checked: false }
            ]
        }
    },

    methods: {
        add() {
            let selectedCompetitions = this.competitions.filter(competition => competition.checked === true);
            this.$emit('update:selectedBag', selectedCompetitions.map(competitions => competitions.id))
        }
    },

    mounted() {
        this.competitions.map(competition => {
            competition.checked = this.selectedBag.includes(competition.id) === true;
        })
    }
})
</script>

<template>
    <div>
        <fieldset class="comp__filter">
            <legend>Select Competitions</legend>
            <div v-for="comp in competitions">
                <input
                    type="checkbox"
                    name="compFilter"
                    :id="`compFilter${comp.code}`"
                    v-model="comp.checked"
                    @change="add"
                    :checked="comp.checked">
                <label
                    class="comp__label"
                    :for="`compFilter${comp.code}`">
                    {{ comp.caption }}
                </label>
            </div>
        </fieldset>
    </div>
</template>

<style scoped>
    fieldset {
        padding: 1em;
        border: 1px solid var(--border-bg);
        border-radius: var(--border-radius);
    }

    fieldset legend {
        font-weight: bolder;
    }

    .comp__filter {
        margin-top: 1em;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .comp__filter div {
        display: flex;
        gap: 0.5em;
    }

</style>
