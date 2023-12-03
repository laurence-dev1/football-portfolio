<script>
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/vue3'

export default defineComponent({
    name: "Dashboard",
    components: { Head },
    data() {
        return {

        }
    }
})
</script>

<template>
    <Head>
        <title>Dashboard</title>
    </Head>

    <h2>Here {{ $page.props.auth.user.name }}, Your Bookmarks!</h2>
</template>

<style scoped>

</style>
