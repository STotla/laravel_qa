<script setup>
import AnswerCreate from './AnswerCreate.vue';
import AnswerEdit from './AnswerEdit.vue';
import AnswerItem from './AnswerItem.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props= defineProps({
    answers: {
        type: Array,
        required: true,
    },
    answerCount: {
        type: Number,
        required: true,
    },
    question: {
        type: Object,
        required: true,
    },
});
import { computed } from 'vue';
import Pagination from '../Pagination.vue';

const showModal = ref(false);
const answerData = ref(null);

// This stays constant; it will update automatically whenever showModal.value changes
const showModalComputed = computed(() => showModal.value);
const answerValue = computed(() => answerData.value);

const updateAnswerItem = (answer) => {
    answerData.value = answer;
    showModal.value = true; 
};
const updateBestAnswerinQuestion = (answer) => {
    // Emit an event to the parent component to update the best answer
    let questionData= props.question;
    const form= useForm({
        id: questionData.id,
        best_answer_id: answer.id,
    });
    form.patch(route('questions.updateBestAnswer', questionData.id), {
        preserveScroll: true,
        onError: (errors) => {
            console.error('Error updating best answer:', errors);
        },
    });

};

const voteanswer = ({answer,vote}) => {
    const form = useForm({
        ...answer,
        vote: vote,
    });
    form.post(route('answer.vote', form.id), {
        preserveScroll: true,
        onError: (errors) => {
            console.error('Error voting answer:', errors);
        },
    });
}




</script>

<template>
    <div class="bg-slate-900 rounded-lg shadow-md p-6">
        <h2 class="text-3xl font-extrabold leading-tight text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-rose-500 mb-4">Answers: {{ answerCount }}</h2>
        <div v-if="answerCount === 0" class="text-gray-600">
            No answers yet. Be the first to answer this question!
        </div>
        <div v-else>
            <div v-for="answer in answers" :key="answer.id" class="mb-6 border-b border-gray-200 p-4" >
                <AnswerItem :answer="answer" :bestAnswerId="question.best_answer_id" @edit="updateAnswerItem" @editQuestion="updateBestAnswerinQuestion"  @addVote="voteanswer"/>
            </div>
        </div>

         <AnswerCreate :questionId="question.id" />
    </div>

    <AnswerEdit   :show="showModalComputed" :answer="answerData?answerValue:answerData" @close="showModal = false" />
</template>