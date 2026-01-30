<script setup>
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';


defineProps({
    form: {
        type: Object,
        required: true,
    },

})

const emit = defineEmits(['submit']);

</script>

<template>
    <form class="relative   rounded-lg shadow" @submit.prevent="emit('submit')">
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-6">
                    <label for="name" class="block mb-2 text-sm font-medium "
                        :class="{ 'text-white': !form.errors.title, 'text-red-700': form.errors.title }">
                        Title</label>
                    <input type="text" v-model="form.title" name="title" id="title"
                        :class="{ ' border-red-500 ': form.errors.title, 'border-gray-300 ': !form.errors.title }"
                        class="shadow-sm bg-slate-950  border  text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5">
                    <div class="font-sm text-red-500 mt-2" v-if="form.errors.title">
                        {{ form.errors.title }}
                    </div>
                </div>



                <div class="col-span-6 sm:col-span-6">
                    <label for="description" class="block mb-2 text-sm font-medium  "
                        :class="{ ' text-red-700': form.errors.body, 'text-gray-300': !form.errors.body }">Explain your
                        question</label>

                    <MarkdownEditor :content="form.body">
                        <textarea name="body" v-model="form.body" id="description"
                            :class="{ ' border-red-500 ': form.errors.body, ' border-gray-300 ': !form.errors.body }"
                            class="shadow-sm bg-slate-950 border border-gray-300 text-gray-00 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                            ></textarea>
                    </MarkdownEditor>

                    <div class="font-sm text-red-500 mt-2" v-if="form.errors.body">
                        {{ form.errors.body }}
                    </div>

                </div>
                <div class="col-span-6 sm:col-span-6 space-x-2">
                    <button type="submit"
                        class="text-white bg-orange-500 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save</button>
                    <Link :href="route('questions.index')"
                        class="text-gray-900 bg-gray-300 border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                        Cancel
                    </Link>
                </div>
            </div>
        </div>
    </form>
</template>