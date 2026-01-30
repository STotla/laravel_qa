<script setup>

import { ref } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import MarkdownEditor from '../MarkdownEditor.vue';
const answer = ref('');
const props = defineProps({
    questionId: {
        type: Number,
        required: true,
    },
});

const user= usePage().props.auth.user;
const currentPath = window.location.pathname;

const form = useForm({
    body: '',
    question_id: props.questionId,
});
const submitAnswer = () => {
    form.post(route('answer.store'), {
        onSuccess: () => {
            form.reset();
        },
        onFailure: () => { },
        preserveScroll: true,
    });
};


</script>

<template>

    <div class=" relative py-3 mx-auto max-w-7xl  mb-6">
        <div v-if="!user"
            class="absolute inset-0 z-10 flex flex-col items-center justify-center rounded-lg bg-slate-900/60 backdrop-blur-sm">
            <p class="mb-4 text-3xl font-extrabold text-gray-200">
                Please login to post your answer
            </p>
            <Link class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" :href="route('login', { redirect: currentPath })">Login</Link>
            
        </div>

        <div class="">
            <form @submit.prevent="submitAnswer">
                <div class="mb-4">
                    <MarkdownEditor :content="form.body">

                        <textarea name="body" v-model="form.body" id="description"
                            :class="{ 'bg-red-50 border-red-500 text-red-900': form.errors.body, 'bg-gray-50 border-gray-300 text-gray-200': !form.errors.body }"
                            class="shadow-sm bg-slate-950 border border-gray-300 text-gray-200 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                            rows="10"></textarea>
                    </MarkdownEditor>
                    <div class="font-sm text-red-500 mt-2" v-if="form.errors.body">
                        {{ form.errors.body }}
                    </div>
                </div>
                <button type="submit" class="bg-orange-500  hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                    Submit Answer
                </button>
            </form>
        </div>


    </div>
</template>