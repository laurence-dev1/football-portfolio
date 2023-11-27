<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "MatchStatsTable"
})
</script>

<template>
    <!-- Real Madrid v Napoli | R16 | UCL -->
    <div class="stats_table">
        <div class="table__row">
            <div class="text-left">54%</div>
            <div class="text-center">BALL POSSESSION</div>
            <div class="text-right">46%</div>
        </div>

        <div class="table__row">
            <div class="text-left">19</div>
            <div class="text-center">TOTAL ATTEMPTS</div>
            <div class="text-right">8</div>
        </div>

        <div class="table__row">
            <div class="text-left">6</div>
            <div class="text-center">ATTEMPTS ON TARGET</div>
            <div class="text-right">2</div>
        </div>

        <div class="table__row">
            <div class="text-left">1</div>
            <div class="text-center">SAVES</div>
            <div class="text-right">2</div>
        </div>

        <div class="table__row">
            <div class="text-left">5</div>
            <div class="text-center">CORNERS</div>
            <div class="text-right">1</div>
        </div>

        <div class="table__row">
            <div class="text-left">7</div>
            <div class="text-center">OFFSIDES</div>
            <div class="text-right">1</div>
        </div>

        <div class="table__row">
            <div class="text-left">106.54km</div>
            <div class="text-center">DISTANCE</div>
            <div class="text-right">116.30km</div>
        </div>

        <div class="table__row">
            <div class="text-left">533 (88%)</div>
            <div class="text-center">TOTAL PASSES</div>
            <div class="text-right">533 (87%)</div>
        </div>

        <div class="table__row">
            <div class="text-left">9</div>
            <div class="text-center">FOULS COMIMITED</div>
            <div class="text-right">12</div>
        </div>

        <div class="table__row">
            <div class="text-left">2 / 0</div>
            <div class="text-center">YELLOW/RED CARDS</div>
            <div class="text-right">2 / 0</div>
        </div>
    </div>
</template>

<style scoped>
    .stats_table {
        margin-top: 1em;
    }

    .stats_table .table__row {
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;

        padding: 0.7em;
        border-bottom: 1px solid var(--border-bg);
    }

    .table__row div:nth-child(2) {
        width: 70%;
        font-weight: bolder;
    }

    .table__row div:nth-child(1),
    .table__row div:nth-child(3) {
        width: 20%;
    }
</style>
