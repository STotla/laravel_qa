<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import Toast from '@/Components/toast/Toast.vue';
import { ref } from 'vue';
import SearchFeature from '@/Components/SearchFeature.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    title: {
        type: String,
        required: true,
    }

});
const showToastBox = ref(false)

router.on('finish', () => {

    showToastBox.value = !!usePage().props.toast.message;
})

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

    <Head :title="title" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

        <div class="relative flex  flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full   lg:max-w-8xl">
                <NavBar />
                <header class="">

                </header>

                <main class="bg-slate-950 z-10 min-h-screen ">
                    <SearchFeature/>
                    <slot />
                </main>
                <Toast :message="$page.props.toast.message || ''" type="success" position='bottom-right'
                    :show="showToastBox" @hide="showToastBox = false">

                </Toast>

                <footer class="py-5 text-center text-sm bg-slate-950/80 backdrop-blur-md text-gray-100">
                    All rights reserved &copy; 2024
                </footer>
            </div>
        </div>
    </div>
</template>
