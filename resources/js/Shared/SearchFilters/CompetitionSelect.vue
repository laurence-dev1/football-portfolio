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
                { id: 2014, code: 'PD', caption: 'La Liga'},
                { id: 2021, code: 'PL', caption: 'Premier League' },
                { id: 2002, code: 'BL1', caption: 'Bundesliga' },
                { id: 2019, code: 'SA', caption: 'Serie A' },
                { id: 2015, code: 'FL1', caption: 'Ligue 1' },
                { id: 2001, code: 'CL', caption: 'UEFA Champion\'s League' },
                { id: 2000, code: 'WC', caption: 'FIFA World Cup' }
            ]
        }
    },

    methods: {
        add(event) {
            let bag = this.selectedBag;
            let selectedVal = event.target.value;

            bag.push(selectedVal);
            if (bag.indexOf(selectedVal) > -1 && event.target.checked === false) {
                bag = bag.filter(comp => comp !== selectedVal);
            }

            this.$emit('update:selectedBag', bag);
        }
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
                    :value="comp.id"
                    @change="add" >
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

    input[type=checkbox] {
        display: none;
    }

    input[name=compFilter] + label {
        padding: 0.5em;
        font-weight: bold;
        border: 1px solid var(--border-bg);
        border-radius: var(--border-radius);
        background-color: var(--primary-bg);

        transition-property: background-color;
        transition-duration: 0.1s;
    }

    input[name=compFilter]:checked + label {
        background-color: var(--btn-bg);
        color: var(--btn-text-color);
    }
</style>
