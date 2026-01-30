<script setup>
import { useForm,Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import QuestionForm from './QuestionForm.vue';
import GuestOpenLayout from '@/Layouts/GuestOpenLayout.vue';
const form = useForm({
    title: '',
    body: '',

})

const handleSubmit=()=>{
    form.post(route('questions.store'),{
        onSuccess: ()=> form.reset()
    })
}

</script>
<template>

    <Head title="question" />
    <GuestOpenLayout>
        <div class="py-6">
          
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mb-6 flex justify-between ">

                <div class="">

                    <h1 class="text-4xl font-bold text-white">Ask a Question</h1>
                    <p class="text-gray-400 mt-2">You can ask relevant question to the community</p>
                </div>
                <div>
                    <Link :href="route('questions.index')"
                        class="px-3 py-2.5 text-sm font-medium text-center text-white bg-orange-500 rounded-md hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Back to Forum
                    </Link>
                </div>
            </div>
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="overflow-hidden bg-slate-900 text-gray-200 shadow-sm sm:rounded-lg">
                     <QuestionForm :form="form" @submit="handleSubmit" 
                    >
                </QuestionForm> 

                </div>
            </div>
        </div>
    </GuestOpenLayout>

</template>