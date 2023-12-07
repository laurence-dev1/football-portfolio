<script>
import {defineComponent, onUpdated} from 'vue'

export default defineComponent({
    name: "DateRangePicker",
    props: {
        dateFrom: { type: String, required: true },
        dateTo: { type: String, required: true }
    },

    data() {
        return {
            // update emits on prop references are not reflecting on current cycle (?),
            // as workaround, local state are declared for reference during validation
            dateFromSelect: '',
            dateToSelect: ''
        }
    },

    methods: {
        validateDates(event) {
            let target = event.target;
            if (this.dateFromSelect !== '' && this.dateToSelect !== '') {
                let dateFrom = new Date(this.dateFromSelect);
                let dateTo = new Date(this.dateToSelect);

                if (dateFrom > dateTo) {
                    this.$page.props.errors.date = '"From Date" should be less than "To Date"';
                    this[target.id + 'Select'] = '';

                } else if (new Date(dateTo.getTime() - dateFrom.getTime()).getUTCDate() > 10) {
                    this.$page.props.errors.date = 'Date difference should be less than or equal to 10 days.';
                    this[target.id + 'Select'] = '';
                }
            }

            this.$emit('update:' + target.id, this[target.id + 'Select']);
        },
    },

    mounted() {
        if (this.dateFrom !== '') {
            this.dateFromSelect = this.dateFrom
        }

        if (this.dateTo !== '') {
            this.dateToSelect = this.dateTo
        }
    }
})
</script>

<template>
    <div id="date_range_picker">
        <div class="filter__item">
            <label for="dateFrom">From:</label>
            <input type="date" id="dateFrom" v-model="dateFromSelect" @change="validateDates">
        </div>

        <div class="filter__item">
            <label for="dateTo">To:</label>
            <input type="date" id="dateTo"  v-model="dateToSelect" @change="validateDates">
        </div>
    </div>
</template>

<style scoped>
    #date_range_picker {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    #date_range_picker .filter__item {
        position: relative;
    }

    label[for=dateFrom],
    label[for=dateTo] {
        position: absolute;
        font-size: 0.85em;
        top: -11px;
        left: 3px;
        font-weight: bolder;
        background-color: var(--primary-bg);
        padding: 0.15em 1em;
        border: 1px solid var(--border-bg);
        border-radius: var(--border-radius);
    }

    .filter__item input[type=date] {
        border: 1px solid var(--border-bg);
        border-radius: var(--border-radius);
        background-color: var(--primary-bg);
        padding: 0.8em;
        font-size: inherit;
        font-family: inherit;
    }
</style>
