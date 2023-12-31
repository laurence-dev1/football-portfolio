<script>
import { defineComponent } from 'vue'
import { Link } from "@inertiajs/vue3";
import { useUserAuthStore } from "@/store/User/useUserAuthStore.js";
import { useMessageStore } from "@/store/useMessageStore.js";
import ErrorCard from "@/Shared/Util/ErrorCard.vue";
import SuccessCard from "@/Shared/Util/SuccessCard.vue";
import NavLinks from "@/Shared/NavLinks.vue";
import UserIcon from "@/Shared/Util/Icons/UserIcon.vue";

export default defineComponent({
    name: "Layout",
    components: { UserIcon, NavLinks, SuccessCard, ErrorCard, Link },
    data() {
        return {
            showNavLinks: false,
            showNavUsers: false
        }
    },

    computed: {
        hasUser() {
            return this.$page.props.auth.user !== null;
        }
    },

    methods: {
        toggleNav(event, link) {
            let iconRefs = {
                showNavLinks: 'burgerIcon',
                showNavUsers: 'userIcon'
            }

            const triggerElement = this.$refs[iconRefs[link]];

            if (triggerElement.contains(event.target) === false) {
                return;
            }

            this[link] = !this[link];
            triggerElement.classList.toggle('active', this[link] === true);

            // display only one at a time
            const oppositeNav = link === 'showNavLinks' ? 'showNavUsers' : 'showNavLinks';
            this[oppositeNav] = false;
        },

        detectOutsideClick(event) {
            const burgerIcon = this.$refs.burgerIcon;
            const userIcon = this.$refs.userIcon;
            if (burgerIcon.contains(event.target) === false
                && userIcon.contains(event.target) === false) {

                this.showNavLinks = false;
                this.showNavUsers = false;
                burgerIcon.classList.remove('active');
                userIcon.classList.remove('active');
            }
        },

        abortRequestsOnLogout() {
            axios.defaults.abortController.abort('logout');

            // Reset the used AbortController, since they are one-time use only.
            const newAbortController = new AbortController();
            axios.defaults.abortController = newAbortController;
            axios.defaults.signal = newAbortController.signal;
        }
    },

    beforeMount() {
        // in case of page reload
        useUserAuthStore().$patch({ isAuthenticated: this.$page.props.auth.user !== null })
    },

    mounted() {
        document.addEventListener('click', this.detectOutsideClick);
    },

    beforeDestroy() {
        document.removeEventListener('click', this.detectOutsideClick);
    },

    watch: {
        // watch inertia's $page.props.auth.user (from shared)
        // can change when logging out/in
        '$page.props.auth.user': {
            handler(user) {
                useUserAuthStore().$patch({ isAuthenticated: user !== null })
            },
            deep: true
        },

        // watch inertia's $page.props.errors (from shared)
        // feed the value to useMessageStore() to be accessed by <ErrorCard>
        '$page.props.errors': {
            handler(errors) {
                useMessageStore().$patch({ errorMessages: errors })
            },
            deep: true
        }
    }
})
</script>

<template>
    <header class="header">
        <div class="header__left">
            <div class="header__burger" ref="burgerIcon" @click="toggleNav($event, 'showNavLinks')">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="header__logo">
                <!-- Logo -->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="35" height="35" viewBox="0 0 256 256" xml:space="preserve">
                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
	                    <path d="M 89.317 52.775 C 89.757 50.248 90 47.653 90 45 c 0 -0.564 -0.01 -1.125 -0.031 -1.683 c -0.138 -3.747 -3.734 -7.378 -4.734 -10.837 c -1.112 -3.848 0.275 -7.484 -1.762 -10.833 C 75.579 8.668 61.302 0 45 0 c -7.942 0 -15.404 2.058 -21.881 5.669 c -4.293 2.393 -6.153 6.469 -9.434 10.081 c -3.307 3.64 -8.026 6.824 -10.006 11.402 C 1.312 32.624 0 38.659 0 45 c 0 2.653 0.243 5.248 0.683 7.775 C 28.51 59.795 57.948 60.231 89.317 52.775 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(190,235,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 83.473 21.647 h -7.697 c -2.245 0 -4.178 1.312 -5.091 3.208 H 49.155 c -3.122 0 -5.652 2.531 -5.652 5.653 c 0 3.122 2.531 5.653 5.652 5.653 h 14.427 c -0.132 0.48 -0.209 0.983 -0.209 1.504 c 0 3.122 2.531 5.653 5.652 5.653 h 20.932 C 89.666 35.402 87.341 28.006 83.473 21.647 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(225,249,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 3.598 27.347 h 33.224 c 3.122 0 5.652 -2.531 5.652 -5.653 c 0 -3.122 -2.531 -5.653 -5.652 -5.653 h -8.13 c 1.526 -1.012 2.534 -2.744 2.534 -4.712 c 0 -3.122 -2.531 -5.653 -5.653 -5.653 h -2.45 C 14.443 10.516 7.529 18.14 3.598 27.347 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(225,249,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 0.683 52.775 C 4.369 73.92 22.8 90 45 90 s 40.631 -16.08 44.317 -37.225 H 0.683 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(171,225,123); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 64.843 11.258 h -0.498 c -0.239 -2.185 -2.069 -3.893 -4.319 -3.893 c -2.249 0 -4.08 1.707 -4.319 3.893 h -0.719 c -1.876 0 -3.397 1.521 -3.397 3.397 c 0 1.876 1.521 3.397 3.397 3.397 h 9.854 c 1.876 0 3.397 -1.521 3.397 -3.397 C 68.24 12.779 66.719 11.258 64.843 11.258 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(225,249,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <circle cx="54.8" cy="39.84" r="25.5" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(241,241,241); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
                        <path d="M 42.073 39.84 c 0 -10.165 4.916 -19.279 12.695 -25.499 C 40.699 14.359 29.3 25.768 29.3 39.84 S 40.699 65.322 54.768 65.34 C 46.989 59.12 42.073 50.005 42.073 39.84 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(219,219,219); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 79.8 39.226 l -6.643 0.5 l -7.671 -6.85 v -7.547 l 7.876 -2.276 c -0.428 -0.474 -0.878 -0.927 -1.341 -1.367 l -7.79 2.251 l -7.459 -3.057 l -1.464 -6.057 c -0.166 -0.003 -0.33 -0.013 -0.496 -0.013 c -0.414 0 -0.825 0.011 -1.233 0.031 l 1.523 6.297 l -5.722 6.799 l -4.859 1.01 l 0 0 l -5.694 1.183 l -4.035 -5.297 c -0.002 0.002 -0.003 0.004 -0.005 0.006 c -1.618 2.22 -2.817 4.519 -3.635 6.89 c -0.02 0.06 -0.041 0.12 -0.061 0.18 c -0.035 0.101 -0.07 0.202 -0.103 0.304 c -0.045 0.14 -0.086 0.28 -0.128 0.42 c -0.074 0.248 -0.146 0.498 -0.213 0.749 c -0.001 0.006 -0.003 0.011 -0.005 0.017 c -0.025 0.096 -0.051 0.191 -0.075 0.287 c 0 0 0 0 0 0 s 0 0 0 0 c -0.085 0.336 -0.164 0.674 -0.234 1.016 c -0.007 0.032 -0.014 0.063 -0.021 0.094 c -0.08 0.392 -0.151 0.788 -0.212 1.187 c -0.006 0.042 -0.011 0.083 -0.017 0.125 c -0.025 0.165 -0.042 0.332 -0.063 0.499 c -0.018 0.144 -0.039 0.288 -0.055 0.433 c -0.002 0.019 -0.005 0.037 -0.007 0.056 c -0.014 0.132 -0.026 0.264 -0.038 0.397 c -0.02 0.221 -0.036 0.443 -0.051 0.665 c -0.002 0.025 -0.004 0.05 -0.006 0.075 c 0 0.004 -0.001 0.008 -0.001 0.011 c -0.009 0.146 -0.019 0.291 -0.025 0.437 c -0.017 0.376 -0.029 0.753 -0.029 1.133 l 6.261 -0.645 l 7.338 8.49 v 6.582 l -5.795 3.712 c 0.423 0.401 0.856 0.793 1.306 1.165 l 5.34 -3.42 l 8.564 2.55 l 1.107 6.549 c 0.293 0.01 0.586 0.022 0.881 0.022 c 0.278 0 0.553 -0.012 0.828 -0.021 l -1.182 -6.992 l 4.066 -5.873 l 10.891 -1.477 l 3.601 6.49 c 0.038 -0.04 0.077 -0.079 0.114 -0.12 c 0.127 -0.135 0.248 -0.272 0.371 -0.408 c 1.773 -1.995 3.234 -4.273 4.301 -6.762 c 0.048 -0.116 0.097 -0.232 0.144 -0.349 c 0.062 -0.151 0.12 -0.303 0.179 -0.455 c 1.068 -2.837 1.628 -5.953 1.683 -9.345 C 79.806 39.413 79.802 39.32 79.8 39.226 z M 51.836 44.426 l -7.501 1.731 l -6.971 -8.065 l 1.771 -6.303 l 4.662 -0.969 v 0 l 5.856 -1.217 l 4.943 6.633 L 51.836 44.426 z M 69.311 48.769 l -11.188 1.517 l -4.68 -5.349 l 2.755 -8.173 l 8.339 -2.476 l 7.186 6.418 L 69.311 48.769 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(53,73,94); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 54.8 65.34 c -14.061 0 -25.5 -11.439 -25.5 -25.5 c 0 -14.061 11.439 -25.5 25.5 -25.5 c 14.061 0 25.5 11.439 25.5 25.5 C 80.3 53.901 68.861 65.34 54.8 65.34 z M 54.8 15.826 c -13.242 0 -24.014 10.772 -24.014 24.014 S 41.558 63.855 54.8 63.855 S 78.814 53.082 78.814 39.84 S 68.041 15.826 54.8 15.826 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(53,73,94); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 42.336 43.845 l -4.972 -5.753 l 1.771 -6.303 l 4.252 -0.884 c 0.187 -0.624 0.39 -1.241 0.614 -1.849 l -5.175 1.076 l -4.035 -5.297 c -0.002 0.002 -0.003 0.004 -0.005 0.006 c -1.618 2.22 -2.817 4.519 -3.635 6.89 c -0.02 0.06 -0.041 0.12 -0.061 0.18 c -0.035 0.101 -0.07 0.202 -0.103 0.304 c -0.045 0.14 -0.086 0.28 -0.128 0.42 c -0.074 0.248 -0.146 0.498 -0.213 0.749 c -0.001 0.006 -0.003 0.011 -0.005 0.017 c -0.025 0.096 -0.051 0.191 -0.075 0.287 c 0 0 0 0 0 0 s 0 0 0 0 c -0.085 0.336 -0.164 0.674 -0.234 1.016 c -0.007 0.032 -0.014 0.063 -0.021 0.094 c -0.08 0.392 -0.151 0.788 -0.212 1.187 c -0.006 0.042 -0.011 0.083 -0.017 0.125 c -0.025 0.165 -0.042 0.332 -0.063 0.499 c -0.018 0.144 -0.039 0.288 -0.055 0.433 c -0.002 0.019 -0.005 0.037 -0.007 0.056 c -0.014 0.132 -0.026 0.264 -0.038 0.397 c -0.02 0.221 -0.036 0.443 -0.051 0.665 c -0.002 0.025 -0.004 0.05 -0.006 0.075 c 0 0.004 -0.001 0.008 -0.001 0.011 c -0.009 0.146 -0.019 0.291 -0.025 0.437 c -0.017 0.376 -0.029 0.753 -0.029 1.133 l 6.261 -0.645 l 6.868 7.946 C 42.678 46.044 42.48 44.952 42.336 43.845 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(44,62,80); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 53.578 14.842 l 0.101 0.417 c 0.169 -0.146 0.342 -0.289 0.514 -0.433 C 53.987 14.832 53.781 14.832 53.578 14.842 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(44,62,80); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 53.897 64.607 l 0.032 0.189 c 0.066 0.002 0.133 0.003 0.199 0.005 C 54.051 64.736 53.974 64.672 53.897 64.607 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(44,62,80); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 44.258 55.698 l 2.616 0.779 c -1.477 -2.381 -2.653 -4.936 -3.467 -7.63 v 5.395 l -5.795 3.712 c 0.423 0.401 0.856 0.793 1.306 1.165 L 44.258 55.698 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(44,62,80); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 52.954 63.777 C 40.573 62.83 30.785 52.46 30.785 39.84 c 0 -12.62 9.787 -22.99 22.169 -23.936 c 0.588 -0.537 1.188 -1.063 1.813 -1.563 c -0.439 0.001 -0.875 0.012 -1.308 0.035 c -0.054 0.003 -0.107 0.009 -0.16 0.012 c -0.377 0.022 -0.752 0.049 -1.125 0.087 c -0.259 0.027 -0.514 0.064 -0.77 0.098 c -0.163 0.022 -0.328 0.038 -0.49 0.063 C 39.173 16.439 30.049 26.28 29.347 38.344 C 29.318 38.84 29.3 39.338 29.3 39.84 c 0 0.493 0.017 0.981 0.045 1.467 c 0.689 12.079 9.82 21.934 21.572 23.738 c 0.108 0.017 0.219 0.027 0.328 0.042 c 0.31 0.043 0.62 0.087 0.933 0.119 c 0.33 0.034 0.663 0.056 0.996 0.077 c 0.097 0.006 0.192 0.017 0.289 0.022 c 0.41 0.021 0.823 0.031 1.238 0.033 c 0.023 0 0.045 0.002 0.068 0.002 C 54.142 64.839 53.542 64.314 52.954 63.777 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(44,62,80); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 54.8 65.466 c -14.13 0 -25.625 -11.495 -25.625 -25.625 S 40.67 14.216 54.8 14.216 s 25.625 11.495 25.625 25.625 S 68.93 65.466 54.8 65.466 z M 54.8 14.466 c -13.992 0 -25.375 11.383 -25.375 25.375 S 40.808 65.216 54.8 65.216 s 25.375 -11.383 25.375 -25.375 S 68.792 14.466 54.8 14.466 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(53,73,94); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        <path d="M 79.003 30.637 c -0.081 -0.292 -0.178 -0.579 -0.304 -0.857 c -0.032 -0.07 -0.081 -0.13 -0.115 -0.198 c -0.062 -0.146 -0.109 -0.296 -0.175 -0.44 c -4.793 -10.573 -17.04 -16.947 -34.484 -17.947 c -9.943 -0.57 -20.914 0.658 -32.191 3.503 c -0.775 0.85 -1.509 1.738 -2.218 2.646 c 1.663 -0.456 3.321 -0.878 4.971 -1.263 c 5.22 5.201 9.797 10.615 13.729 16.232 c -7.015 2.262 -14.306 4.941 -21.575 7.932 c -1.579 -2.505 -3.24 -4.985 -4.952 -7.448 c -0.24 0.853 -0.458 1.714 -0.648 2.587 c 1.276 1.871 2.528 3.75 3.726 5.645 c -1.577 0.661 -3.149 1.337 -4.718 2.022 C 0.022 43.697 0 44.346 0 45 c 0 0.085 0.006 0.169 0.006 0.255 c 1.963 -0.868 3.912 -1.716 5.829 -2.522 C 12.379 53.322 17.727 64.28 21.86 75.589 c -2.15 1.055 -4.366 2.106 -6.618 3.153 c 0.552 0.487 1.116 0.961 1.692 1.421 c 1.874 -0.879 3.742 -1.77 5.594 -2.683 c 0.917 2.604 1.757 5.231 2.548 7.871 c 0.798 0.395 1.605 0.774 2.429 1.122 c -0.958 -3.325 -2.012 -6.623 -3.168 -9.892 c 6.68 -3.347 13.155 -6.887 19.175 -10.489 c 1.501 6.418 2.334 13.022 2.487 19.802 c -1.841 1.318 -3.766 2.598 -5.732 3.858 c 1.097 0.115 2.209 0.179 3.328 0.214 c 9.066 -6.083 16.775 -12.826 22.768 -19.762 c 0.208 -0.113 0.368 -0.294 0.453 -0.522 C 78.292 56.189 83.238 42.029 79.003 30.637 z M 43.81 13.191 c 14.323 0.821 24.919 5.346 30.458 12.861 c -4.031 -1.551 -10.279 -1.644 -17.939 -0.587 c -3.495 -4.563 -7.82 -8.662 -12.96 -12.29 C 43.515 13.182 43.665 13.183 43.81 13.191 z M 16.784 15.555 c 7.923 -1.695 15.626 -2.535 22.857 -2.484 c 5.759 3.691 10.553 7.943 14.386 12.737 c -7.079 1.143 -15.207 3.169 -23.816 5.866 C 26.355 26.102 21.878 20.725 16.784 15.555 z M 23.666 74.7 c -4.132 -11.268 -9.455 -22.19 -15.955 -32.747 c 7.665 -3.167 14.92 -5.821 21.65 -7.978 c 6.388 9.497 10.951 19.562 13.669 30.145 C 37.217 67.613 30.749 71.169 23.666 74.7 z M 31.346 33.346 c 9.162 -2.848 17.283 -4.745 24.056 -5.741 c 4.605 6.313 7.625 13.517 9.046 21.586 c -5.137 4.312 -11.736 9.008 -19.631 13.848 C 42.074 52.629 37.577 42.716 31.346 33.346 z M 64.927 68.938 c -4.648 5.357 -10.36 10.613 -16.972 15.535 c -0.239 -6.663 -1.122 -13.156 -2.643 -19.469 c 7.415 -4.522 14.077 -9.119 19.494 -13.534 C 65.549 56.918 65.591 62.744 64.927 68.938 z M 66.216 47.674 c -1.474 -7.541 -4.327 -14.34 -8.548 -20.375 c 10.532 -1.289 17.361 -0.188 19.097 3.119 c 0.102 0.24 0.194 0.484 0.287 0.727 C 78.077 34.739 74.222 40.623 66.216 47.674 z M 67.176 66.242 c 0.423 -5.749 0.235 -11.178 -0.56 -16.281 c 5.853 -4.99 10.008 -9.703 11.731 -13.753 C 79.545 45.358 75.391 55.914 67.176 66.242 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                    </g>
                </svg>
                <strong>Football Portfolio</strong>
            </div>
        </div>
        <div class="header__right">
            <div class="header__nav-full">
                <!-- Nav Links -->
                <NavLinks />
            </div>
            <div class="header__user" ref="userIcon" @click="toggleNav($event, 'showNavUsers')">
                <!-- Auth -->
                <UserIcon width="35" height="35" viewBox="0 4 256 256" />
            </div>
        </div>
    </header>

    <Transition name="rollDown">
        <!-- v-show and :key is added together when toggling transition to avoid flickering when on "leave" transition state (??) -->
        <nav v-show="showNavLinks === true" :key="showNavLinks" class="nav__common" ref="navCommon">
            <NavLinks />
        </nav>
    </Transition>

    <Transition name="rollDown">
        <nav v-show="showNavUsers === true" :key="showNavUsers" class="nav__auth" ref="navAuth">
            <Link v-if="hasUser === true"
                  class="nav__a"
                  :class="{ 'nav-active' : $page.component === 'User/Settings' }"
                  href="/settings">User Settings</Link>
            <Link v-else
                  class="nav__a"
                  href="/login">Login</Link>

            <Link v-if="hasUser === true"
                  class="button__logout"
                  href="/logout"
                  method="delete"
                  as="button"
                  @click="abortRequestsOnLogout">Logout</Link>
            <Link v-else
                  class="nav__a"
                  href="/register">Register</Link>
        </nav>
    </Transition>
    <main class="main">
        <slot></slot>

        <SuccessCard />
        <ErrorCard />
    </main>

    <footer class="footer text-center">
        <p>Football data provided by the Football-Data.org API | Free Tier</p>
        <small>This application is for portfolio purposes only - Laurence Suarez</small>
    </footer>
</template>

<style scoped>
    .header {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 100;

        box-shadow: -1px -8px 14px 3px #dddddd;
        background-color: var(--header-bg);
        color: var(--body-bg);
        padding: 0.6em;

        display: flex;
        justify-content: space-between;
    }

    .header__left,
    .header__right {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        gap: 0.8em;
    }

    .header__burger {
        display: none;
        cursor: pointer;
    }

    .header__burger div {
        background-color: var(--body-bg);
        width: 20px;
        height: 3px;

        transition-property: transform, display;
        transition-duration: 0.2s;
    }

    .header__burger div:nth-child(2),
    .header__burger div:nth-child(3) {
        margin-top: 3px;
    }

    .header__burger.active div:nth-child(2) {
        display: none;
    }

    .header__burger.active div:first-child {
        transform: rotate(45deg) translateY(4px);
    }

    .header__burger.active div:last-child {
        transform: rotate(-45deg) translateY(-4px);
    }

    .header__logo {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        gap: 0.4em;
        font-size: 1.5rem;
    }

    .header__logo img {
        width: 40px;
    }

    .header__nav-full {
        display: flex;
        align-items: center;
        gap: 1em;
    }

    .header__user {
        height: 35px;
        background-color: var(--body-bg);
        border: 1px solid var(--body-bg);
        border-radius: 50%;
        cursor: pointer;
    }

    .nav__common,
    .nav__auth {
        z-index: 99;
        position: fixed;
        top: 0;
        width: 100%;

        background-color: var(--header-bg);
        border: none;

        display: flex;
        flex-direction: column;
        padding-top: 3.5em;

        transition-property: display;
        transition-duration: 0.2s;
    }

    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #000;
        color: var(--btn-text-color);
        padding: 0.8em;
        font-size: 0.7em;

        clear: both;
    }

    @media screen and (max-width: 860px) {
        .header__burger {
            display: block;
        }

        .header__nav-full {
            display: none;
        }

        .nav__common,
        .nav__auth {
            font-size: 1.2rem;
            padding-top: 3em;
        }
    }
</style>
