<script setup>
import Modal from '../Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import MarkdownEditor from '../MarkdownEditor.vue';


const form = useForm({
    id: null,
    body: '',
})

const props = defineProps({
    answer: {
        type: Object,
        required: false,
    },
    show: {
        type: Boolean,
        default: false
    },


})
watch(() => props.answer, (newAnswer) => {
    if (newAnswer) {
        
        form.id = newAnswer.id;
        form.body = newAnswer.body;
    }
}, { immediate: true });



const emit = defineEmits(['close', 'updated'])



const updateAnswer = () => {
    form.put(route('answer.update', form.id), {
        onSuccess: () => {
            emit('updated')
            emit('close')
            form.reset()
        },
        onError: (errors) => {
            console.log('Update failed', errors);
        }
    })
}

</script>

<template>
    <Modal   :show="props.show" max-width="xl" @close="emit('close')">
        
        <form @submit.prevent="updateAnswer">
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-white">
                    Edit Answer
                </h3>
                <button type="button" @click.prevent="emit('close')"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="editUserModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
             <div class="p-6 space-y-6">
            <div class="mb-4">
                <MarkdownEditor :content="form.body">

                <textarea name="body" v-model="form.body" id="description"
                    :class="{ 'bg-red-50 border-red-500 text-red-900': form.errors.body, 'bg-gray-50 border-gray-300 text-gray-200': !form.errors.body }"
                    class="shadow-sm bg-slate-900 border border-gray-300 text-gray-200 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                    rows="10"></textarea>
                </MarkdownEditor>
                <div class="font-sm text-red-500 mt-2" v-if="form.errors.body">
                    {{ form.errors.body }}
                </div>
            </div>
            <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                Update Answer
            </button>
            </div>
        </form>
    </Modal>
</template>