<script setup>

import AnswerList from '@/Components/Answers/AnswerList.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import NavBar from '@/Components/NavBar.vue';
import GuestOpenLayout from '@/Layouts/GuestOpenLayout.vue';
import MarkdownIt from 'markdown-it';
import Prism from 'markdown-it-prism'
import { computed } from 'vue';
import AvatarNameDisplay from '@/Components/AvatarNameDisplay.vue';

const props = defineProps({
    question: {
        type: Object,
        required: true,
    }
})

const isLoggedIn = usePage().props.auth.user?true:false;

const md = new MarkdownIt();
md.use(Prism);

const preview = computed(() => {
    return md.render(props.question.body || '');
});

const updateFavoriteStatusofQuestion = () => {
    const form = useForm({
        ...props.question,
        make_favorite: !props.question.is_favourited,
    });
    form.patch(route('questions.updateFavoriteStatusofQuestion', form.id), {
        preserveScroll: true,
        onError: (errors) => {
            console.error('Error updating best answer:', errors);
        },
    });
}
const voteQuestion = (voteValue) => {
    const form = useForm({
        ...props.question,
        vote: voteValue,
    });
    form.post(route('questions.vote', form.id), {
        preserveScroll: true,
        onError: (errors) => {
            console.error('Error voting question:', errors);
        },
    });
}
</script>

<template>



    <Head :title="question.title" />
    <GuestOpenLayout :can-login="canLogin" :can-register="canRegister" title="Questions">
       
        <div class="max-w-7xl mx-auto px-4 py-8">
             <div class="float-right mb-4">
            <Link class="px-3 py-2.5 text-sm font-medium text-center text-white bg-orange-500 rounded-md hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-blue-300 " :href="route('questions.index')"> Back to Forum</Link>
        </div>
            <div class=" flex   rounded-lg shadow-md p-6">
                <!-- Title -->
                <div class="flex flex-col items-center  text-center mr-4">
                    <a title="This answer is useful" class="vote-up  text-2xl">
                        <FontAwesomeIcon icon=" fa-solid fa-caret-up" @click.prevent="voteQuestion(1)"
                            class=" hover:cursor-pointer  hover:text-blue-500"
                            :class="{ 'text-blue-500': question.vote_value === 1, 'text-gray-400': question.vote_value !== 1 }" />
                    </a>
                    <span class="text-lg font-bold text-gray-500 my-2">{{ question.votes_count }}</span>
                    <a title="This answer is not useful" class="vote-down text-2xl " @click.prevent="voteQuestion(-1)"
                        :style="{ pointerEvents: question.vote_value === -1 ? 'none' : 'auto' }"
                        :class="{ ' cursor-not-allowed': question.vote_value === -1  }">
                        <FontAwesomeIcon icon=" fa-solid fa-caret-down" class="hover:cursor-pointer  hover:text-red-500"
                            :class="{ 'text-red-500': question.vote_value === -1, 'text-gray-400': question.vote_value !== -1 }" />
                        <!-- disable the anchor tag click action -->

                    </a>
                    <a   title="Click to mark as favourite question.(Click again to mark as unfavourite)"
                        class="favorite  text-lg  mt-2 "
                        :class="{'pointer-events-none cursor-default opacity-50':!isLoggedIn}">                        
                        <FontAwesomeIcon icon=" fa-solid fa-star"
                        
                            class=" hover:cursor-pointer text-gray-600 hover:text-yellow-500 "
                            @click.prevent="updateFavoriteStatusofQuestion()"
                            :class="{ 'text-yellow-500': question.is_favourited, 'text-gray-600': !question.is_favourited }" />
                    </a>
                    <span class="favourite-count text-gray-500">{{ question.favourites_count }}</span>
                </div>
                <div class=" pl-4 w-full">
                    <h1 class="text-3xl font-bold text-white mb-4">{{ question.title }}</h1>

                    <!-- Metadata -->
                    <div class="flex items-center justify-between  pb-6 border-b border-gray-200">
                        <div class="flex  items-center space-x-4">
                            <AvatarNameDisplay :user="question.user" title="Asked By" />
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-300">{{ question.created_date }}</p>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="prose prose-sm max-w-none mt-3 text-gray-200 leading-relaxed" v-html="preview">
                        
                    </div>
                </div>
            </div>
            <AnswerList :answers="question.answers" :answerCount="question.answers.length" :question="question" />
        </div>
    </GuestOpenLayout>
</template>