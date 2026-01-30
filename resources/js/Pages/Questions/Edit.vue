<script setup>
import { Head,useForm,Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import QuestionForm from './QuestionForm.vue';
import GuestOpenLayout from '@/Layouts/GuestOpenLayout.vue';


const props= defineProps({
    question:{
        type:Object,
        required:true,
    }
})
const form = useForm({
    ...props.question,
})

const handleUpdate=()=>{
    form.put(route('questions.update',form.id),{
        onSuccess: ()=> form.reset()
    })
}

</script>
<template>

    <Head title="edit" />
    <GuestOpenLayout>
        <div class="py-6">
         
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mb-6 flex justify-between ">

                <div class="">

                    <h1 class="text-4xl font-bold text-white">Edit Question</h1>
                    <p class="text-gray-400 mt-2">You can edit your question here</p>
                </div>
                <div>
                    <Link :href="route('questions.index')"
                        class="px-3 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Back to Questions
                    </Link>
                </div>
            </div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="overflow-hidden bg-slate-900 shadow-sm sm:rounded-lg">
                    <QuestionForm :form="form" @submit="handleUpdate" 
                    >
                
                </QuestionForm>

                </div>
            </div>
        </div>
    </GuestOpenLayout>

</template>