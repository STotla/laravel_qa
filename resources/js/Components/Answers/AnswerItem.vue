<script setup>
import { router } from '@inertiajs/vue3';
import { computed } from 'vue';
import Modal from '../Modal.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {CheckBadgeIcon} from '@heroicons/vue/24/outline';
import { TrashIcon, PencilSquareIcon } from '@heroicons/vue/24/solid';
import { faPencilSquare } from '@fortawesome/free-solid-svg-icons';
import MarkdownIt from 'markdown-it';
import prism from 'markdown-it-prism';
import AvatarNameDisplay from '../AvatarNameDisplay.vue';

const props = defineProps({
    answer: {
        type: Object,
        required: true,
    },
    bestAnswerId: {
        type: Number,
        required: false,
    },
});

const emit = defineEmits(['edit', 'editQuestion', 'addVote']);

const isBestAnswer = computed(() => {
    return props.answer.id === props.bestAnswerId;
});

const deleteAnswer = (id) => {
    if (window.confirm('Are you sure?')) {
        router.delete(route('answer.destroy', id), {
            preserveScroll: true,
        })
    }

};
const md = new MarkdownIt();
    md.use(prism);

const preview = computed(() => {
    return md.render(props.answer.body || '');
});


</script>

<template>
    
    <div class="flex" :id="'answer_'+answer.id" >
        <div class="flex flex-col items-center  text-center mr-4">
            <a title="This answer is useful" class=" hover:cursor-pointer vote-up text-2xl "
                @click.prevent="$emit('addVote', { answer: answer, vote: 1 })"
                :style="{ pointerEvents: answer.vote_value === 1 ? 'none' : 'auto' }"
                :class="{ ' cursor-not-allowed': answer.vote_value === 1 }">
                <FontAwesomeIcon icon=" fa-solid fa-caret-up" 
                class="hover:cursor-pointer  hover:text-blue-500"
                    :class="{ 'text-blue-500': answer.is_voted && answer.vote_value === 1, 'text-gray-400': !answer.is_voted || answer.vote_value !== 1 }" />
            </a>
            <span class="text font-bold text-gray-500 my-2">{{ answer.votes_count }}</span>
            <a title="This answer is not useful" class=" hover:cursor-pointer vote-down text-2xl "
                @click.prevent="$emit('addVote', { answer: answer, vote: -1 })"
                :style="{ pointerEvents: answer.vote_value === -1 ? 'none' : 'auto' }"
                :class="{ ' cursor-not-allowed': answer.vote_value === -1 }">
                <FontAwesomeIcon icon=" fa-solid fa-caret-down" class="hover:cursor-pointer  hover:text-red-500"
                    :class="{ 'text-red-500': answer.vote_value === -1, 'text-gray-400': answer.vote_value !== -1 }" />
            </a>
            <a title="Click to mark as favourite question." class=" hover:cursor-pointer favorite  text-lg  mt-2 "
                @click.prevent="$emit('editQuestion', answer)" :class="{ ' cursor-not-allowed': isBestAnswer }"
                :style="{ pointerEvents: isBestAnswer ? 'none' : 'auto' }">
                <CheckBadgeIcon class="w-8 h-8 hover:cursor-pointer "
                    :class="{ 'text-green-500': isBestAnswer, 'text-gray-400': !isBestAnswer }" />
                
            </a>
        </div>
        <div class="w-full">
            <div>
                <div class="prose prose-sm max-w-none text-gray-300 leading-relaxed mb-4" v-html="preview">
                    
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="text-left">
                    <button v-if="answer.can.update" @click.prevent="$emit('edit', answer)"
                        class="px-1 py-1 text-sm text-blue-600 hover:text-blue-800">
                        <PencilSquareIcon class="w-5 h-5 inline-block" /> 
                    </button>

                    <button v-if="answer.can.delete" type="button" @click.prevent="deleteAnswer(answer.id)"
                        class="px-1 py-1 text-sm text-red-600 hover:text-red-800">
                        <TrashIcon class="w-5 h-5 inline-block" />
                    </button>
                </div>
                <div class="flex flex-col mb-2">

                    <div class="text-right  space-x-4">
                        <div>
                            <span class="text-sm text-gray-600">Answered {{ answer.created_date }} </span>
                        </div>
                    </div>
                    <div class="text-right">
                        <AvatarNameDisplay :user="answer.user"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>