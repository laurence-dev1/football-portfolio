<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "BookmarkCheckIcon",
    props: {
        width: { default: 20 },
        height: { default: 20 }
    }
})
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" :width="width" :height="height" viewBox="0 0 256 256" xml:space="preserve">
        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
            <path d="M 71.803 0 c 2.436 0 4.411 1.975 4.411 4.411 v 82.637 c 0 2.546 -3.011 3.893 -4.909 2.197 L 48.79 68.275 c -2.135 -1.989 -5.445 -1.989 -7.58 0 l -22.515 20.97 c -1.898 1.696 -4.909 0.349 -4.909 -2.197 V 4.411 C 13.786 1.975 15.761 0 18.197 0 H 71.803 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(81,221,69); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
        </g>
    </svg>
</template>

<style scoped>

</style>
