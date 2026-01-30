<script setup>
import Pagination from '@/Components/Pagination.vue';
import pluralize from 'pluralize';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import GuestOpenLayout from '@/Layouts/GuestOpenLayout.vue';
import { queuePostFlushCb } from 'vue';

import { PencilSquareIcon } from '@heroicons/vue/24/solid';
import { TrashIcon } from '@heroicons/vue/24/solid';
import AvatarNameDisplay from '@/Components/AvatarNameDisplay.vue';



defineProps({
    questions: {
        type: Object,
        required: true,
    },
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const handleDelete = (id) => {

    if (window.confirm('Are you sure? You want to delete this question?')) {
        router.delete(route('questions.destroy', id)), {
            preserveScroll: true,
        }
    }
}
</script>

<template>

    <Head title="Questions" />

    <GuestOpenLayout :can-login="canLogin" :can-register="canRegister" title="Questions">

        <div class="py-3 ">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mb-6 grid grid-cols-3 ">

                <div class="col-span-2">

                    <h1
                        class="text-5xl md:text-6xl font-extrabold  mt-4 mb-6 leading-tight text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-rose-500">
                        Questions</h1>
                    <p class="text-gray-100 mt-2 text-xl">Browse and explore community questions</p>
                </div>
                <div class="mx-auto flex flex-col justify-center">
                    <Link :href="route('questions.create')"
                        class="px-3 py-2.5 text-sm font-medium text-center text-white bg-orange-500 rounded-md hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        Ask Question
                    </Link>
                </div>
            </div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 ">

                <div class="overflow-hidden bg-slate-800 shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-100">

                        <div class="mb-6 border-b flex pb-4 last:border-b-0" v-for="question in questions.data"
                            :key="question.id">
                            <div class="flex flex-col counters">
                                <div class="vote">
                                    <strong>{{ question.votes_count }}</strong>
                                    {{ pluralize('vote', question.votes) }}
                                </div>
                                <div :class="[' pt-2 answer status ', `${question.answer_status}`]">
                                    <strong>{{ question.answer_count }}</strong>
                                    {{ pluralize('answer', question.answer_count) }}
                                </div>

                                <div class="view m-2">
                                    {{ question.views }} {{ pluralize('view', question.views) }}
                                </div>

                            </div>
                            <div class="w-full">
                                <div class="flex justify-between">
                                    <Link :href="route('questions.show', question.slug)"
                                        class="text-xl font-bold text-gray-300 mb-1 hover:text-blue-600 block">
                                        {{ question.title }}
                                    </Link>
                                    <div class="flex items-center gap-3">
                                        <!-- Edit Button: Soft Indigo Theme -->
                                        <Link data-tooltip-target="edit-tooltip" v-if="question.can.update" :href="route('questions.edit', question.id)"
                                            class="inline-flex items-center gap-2 px-2 py-2  text-indigo-600 font-medium rounded-full hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-md border border-indigo-600">
                                            <PencilSquareIcon class="w-4 h-4" />
                                        </Link>
                                       

                                        <!-- Delete Button: Soft Rose Theme -->
                                        <button data-tooltip-target="delete-tooltip" v-if="question.can.destroy" type="button"
                                            @click.prevent="handleDelete(question.id)"
                                            class="inline-flex items-center gap-2 px-2 py-2  text-rose-600 font-medium rounded-full hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-md border border-rose-600">
                                            <TrashIcon class="w-4 h-4" />
                                        </button>
                                        
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-2 text-sm text-gray-500">
                                   <AvatarNameDisplay :user="question.user" title="Asked by"/>
                                    
                                    <span>{{ question.created_date }}</span>
                                </div>
                                <p class="text-gray-400 mb-3">{{ question.body }}</p>
                            </div>

                        </div>
                    </div>
                    <Pagination :meta="questions.meta"></Pagination>
                </div>
            </div>
        </div>
    </GuestOpenLayout>
</template>

<style>
.counters {
    margin-right: 30px;
    font-size: 10px;
    text-align: center;

}

.vote,
.answer {
    width: 60px;
    height: 60px;
}

.counters strong {
    font-size: 2em;
    display: block;
}

.status.answer-submitted {
    color: var(--success-color);
    border: 1px solid var(--success-color);

}

.status.answer-accepted {
    background: var(--success-color);
    color: var(--gray-light);
}

.status.not-answered {
    border: none;
}
</style>