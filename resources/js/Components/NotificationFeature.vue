<script setup>
import { BellIcon } from '@heroicons/vue/24/solid';
import Dropdown from './Dropdown.vue';
import DropdownLink from './DropdownLink.vue';
import { ref, watch } from 'vue';
import { onClickOutside } from '@vueuse/core';
import { method } from 'lodash';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

import { CheckBadgeIcon } from '@heroicons/vue/24/outline';


const notificationContainer = ref(null);
const notifications = ref([]);

const showDropdown = ref(false);
onClickOutside(notificationContainer, () => {
    showDropdown.value = false;

})
const getNotifications = async () => {
    const response = await axios.get(route('notifications.index'));
    notifications.value = response.data;
};

const markAsRead = async (id) => {
    await axios.post(route('notifications.markAsRead', id));
    getNotifications();
};

watch(showDropdown, getNotifications())

</script>

<template>


    <div class="inline relative z-30 " v-if="$page.props.auth.user">
        <button type="button" @click.prevent="[showDropdown = true]"
            class=" relative inline-flex items-center rounded-md border border-transparent  px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
            <BellIcon class="w-6 h-6  cursor-pointer text-slate-500 hover:text-gray-300" />
            <span class="absolute bottom-5 left-5 rounded-full animate-bounce  sm bg-red-500 text-white text-xs px-1 ">
                {{ notifications.unread_count }}</span>
        </button>

        <div ref="notificationContainer"
            class=" transition duration-300 ease-in-out  rounded-sm absolute text-gray-200 w-[300px] bg-slate-800 "
            v-show="showDropdown">
            <div class="max-h-[200px] overflow-y-auto">
                <ul class="py-2 text-xs" v-if="notifications.unread_count">
                    <li v-for="notification in notifications.notifications" :key="notification.id"
                        class="px-4 flex justify-between py-2 border-b border-slate-700 hover:bg-slate-700">
                        <span>
                            {{ notification.data.user_name }} {{ notification.data.message }}
                            <Link class=" block text-indigo-300 hover:text-indigo-400 "
                                :href="route('questions.show', { question: notification.data.question_slug }) + '#answer_' + notification.data.answer_id">
                                Check here
                            </Link>
                        </span>
                        <div title="Mark as read"
                            class="  inline cursor-pointer  mt-1 px-1 rounded text-gray-400 hover:text-indigo-700"
                            @click.prevent="markAsRead(notification.id)"
                            >
                            <CheckBadgeIcon class="w-4 h-4 inline-block ml-1" />
                        </div>
                    </li>
                </ul>
                <div v-else class="p-4 text-center text-gray-400">
                    No new notifications
                </div>

            </div>
            <div class="h-full p-2" v-if="notifications.unread_count">
                <Link :href="route('notifications.markAllRead')"
                    class="  box-border  py-1 px-2 text-xs rounded bg-indigo-600 hover:bg-indigo-700">
                    Mark all as read
                </Link>
            </div>



        </div>

    </div>
</template>