<script>
import { defineComponent } from 'vue'
import { Head } from "@inertiajs/vue3";

export default defineComponent({
    name: "Search",
    components: { Head },
    props: { type: String },
    computed: {
        pageTitle() {
            return 'Search ' + (this.type.charAt(0).toUpperCase() + this.type.slice(1));
        }
    }
})
</script>

<template>
    <Head>
        <title>{{ pageTitle }}</title>
    </Head>
    <h2>{{ pageTitle }}</h2>

    <section class="main__group">
        <h4>Players to Watch</h4>
        <a href="./view/view-player.html" class="list__item player__item">
            <div class="player__data w-40p">Gareth Bale</div>
            <div class="player__data w-30p text-center">Wales</div>
            <div class="player__data w-30p text-center">Retired</div>
        </a>

        <a href="./view/view-player.html" class="list__item player__item">
            <div class="player__data w-40p">Cristiano Ronaldo</div>
            <div class="player__data w-30p text-center">Portugal</div>
            <div class="player__data w-30p text-center">Al Nassr / Saudi</div>
        </a>
    </section>

    <section class="main__group">
        <h4><label for="input__search">
            Looking for a player?
        </label></h4>
        <div class="search__bar">
            <input type="text" class="input__search" id="input__search" placeholder="Name">
            <button>Search</button>
        </div>
        <a href="./view/view-player.html" class="list__item player__item">
            <div class="player__data w-40p">Gareth Bale</div>
            <div class="player__data w-30p text-center">Wales</div>
            <div class="player__data w-30p text-center">Retired</div>
        </a>

        <a href="./view/view-player.html" class="list__item player__item">
            <div class="player__data w-40p">Cristiano Ronaldo</div>
            <div class="player__data w-30p text-center">Portugal</div>
            <div class="player__data w-30p text-center">Al Nassr / Saudi</div>
        </a>

        <div class="list__item">
            <p>No player found.</p>
        </div>
    </section>
</template>

<style scoped>
    @import "../../css/search.css";
</style>
