<script>
import { defineComponent } from 'vue'
import { mapActions, mapState } from "pinia";
import { Head } from "@inertiajs/vue3";
import UserIcon from "@/Shared/Util/Icons/UserIcon.vue";
import MailIcon from "@/Shared/Util/Icons/MailIcon.vue";
import PlayerIcon from "@/Shared/Util/Icons/PlayerIcon.vue";
import LockIcon from "@/Shared/Util/Icons/LockIcon.vue";
import { useMessageStore } from "@/store/useMessageStore.js";
import { useUserSettingsRequestStore } from "@/store/User/useUserSettingsRequestStore.js";
import LoadingIcon from "@/Shared/Util/Icons/LoadingIcon.vue";

export default defineComponent({
    name: "Settings",
    components: {LoadingIcon, LockIcon, PlayerIcon, MailIcon, UserIcon, Head },
    props: {
        currentUser: {
            type: Object,
            required: true
        }
    },

    computed: {
        ...mapState(useUserSettingsRequestStore, ['loadingState'])
    },

    data() {
        return {
            userInfo: {
                name: this.currentUser.name,
                email: this.currentUser.email,
                username: this.currentUser.username
            },

            passwordInfo: {
                current: '',
                new: '',
                new_confirmation: ''
            }
        }
    },

    methods: {
        ...mapActions(useUserSettingsRequestStore, ['requestUpdateInfo', 'requestUpdatePassword']),

        formChanged(type) {
            const conditions = {
                info: !(this.currentUser.name === this.userInfo.name
                    && this.currentUser.email === this.userInfo.email
                    && this.currentUser.username === this.userInfo.username),

                password: !(this.passwordInfo.current === ''
                    || this.passwordInfo.new === ''
                    || this.passwordInfo.new_confirmation === '')
            }

            return conditions[type];
        },

        updateInfo() {
            if (this.formChanged('info') === false) {
                return useMessageStore().errorMessages = { exception: 'No info has been changed.' }
            }

            this.requestUpdateInfo(this.userInfo);
        },

        updatePassword() {
            if (this.formChanged('password') === false) {
                return useMessageStore().errorMessages = { exception: 'All password fields are required.' }
            }

            if (this.passwordInfo.new !== this.passwordInfo.new_confirmation) {
                return useMessageStore().errorMessages = { exception: 'Kindly re-type the new password on the "Confirm Password" field correctly.' }
            }

            this.requestUpdatePassword(this.passwordInfo);
        }
    }
})
</script>

<template>
    <div>
        <Head>
            <title>User Settings</title>
        </Head>

        <h2>User Info</h2>
        <p class="text-info">Update name, username, and email</p>

        <div class="card mt-1">
            <h4>Name</h4>
            <div class="div__icon-label-input">
                <UserIcon />
                <input type="text"
                       name="name"
                       id="name"
                       v-model="userInfo.name"
                       placeholder="Name"
                       autocomplete="name">
            </div>

            <hr>

            <h4>Email Address</h4>
            <div class="div__icon-label-input">
                <MailIcon />
                <input type="text"
                       name="email"
                       id="email"
                       v-model="userInfo.email"
                       placeholder="Email Address"
                       autocomplete="email">
            </div>

            <hr>

            <h4>Username</h4>
            <div class="div__icon-label-input">
                <PlayerIcon />
                <input type="text"
                       name="username"
                       id="username"
                       v-model="userInfo.username"
                       placeholder="Username"
                       autocomplete="username">
            </div>

            <button class="btn btn_common mt-1"
                    @click="updateInfo"
                    :disabled="loadingState.info === true || loadingState.password === true">
                <Transition name="fade" mode="out-in">
                    <LoadingIcon
                        v-if="loadingState.info === true"
                        fill="white"
                        width="10"
                        height="10" />
                    <span v-else>Update Information</span>
                </Transition>
            </button>
        </div>

        <h2 class="mt-1">Password</h2>
        <p class="text-info">Update password</p>

        <div class="card mt-1">
            <h4>Current Password</h4>
            <div class="div__icon-label-input">
                <LockIcon />
                <input type="password"
                       name="current-password"
                       id="current-password"
                       placeholder="Current Password"
                       v-model="passwordInfo.current">
            </div>

            <hr>

            <h4>New Password</h4>
            <div class="div__icon-label-input">
                <LockIcon />
                <input type="password"
                       name="new-password"
                       id="new-password"
                       placeholder="New Password"
                       v-model="passwordInfo.new">
            </div>

            <hr>

            <h4>Confirm New Password</h4>
            <div class="div__icon-label-input">
                <LockIcon />
                <input type="password"
                       name="confirm-password"
                       id="confirm-password"
                       placeholder="Confirm New Password"
                       v-model="passwordInfo.new_confirmation">
            </div>

            <button class="btn btn_common mt-1"
                    @click="updatePassword"
                    :disabled="loadingState.info === true || loadingState.password === true">
                <Transition name="fade" mode="out-in">
                    <LoadingIcon
                        v-if="loadingState.password === true"
                        fill="white"
                        width="10"
                        height="10" />
                    <span v-else>Update Password</span>
                </Transition>
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
