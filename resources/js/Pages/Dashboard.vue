<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import GuestOpenLayout from '@/Layouts/GuestOpenLayout.vue';

const currentSlide = ref(0);
const slides = [
    { title: 'Learn, Share, Build', description: 'Every developer has a tab open to Stackerow.', image: '/storage/img/hero1.jpg' },
    { title: 'Collaborative Knowledge', description: 'Join 100+ million developers sharing knowledge.', image: '/storage/img/hero2.jpg' }
];

let timer = null;

onMounted(() => {
    timer = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % slides.length;
    }, 5000);
});

// Always clear intervals to prevent memory leaks
onUnmounted(() => {
    if (timer) clearInterval(timer);
});
</script>

<template>

    <Head title="Home" />
    <GuestOpenLayout v-bind="$props">
        <div>
            <!-- Parent Container -->
            <div class="relative w-full h-[500px] overflow-hidden z-index-10 bg-slate-950">

                <!-- Dynamic Background Image -->
                <div v-for="(slide, index) in slides" :key="'bg-' + index"
                    class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                    :class="currentSlide === index ? 'opacity-40' : 'opacity-0'">
                    <img :src="slide.image" class="w-full h-full object-cover">
                </div>

                <!-- Content with Transition -->
                <div class="relative  grid place-items-center h-full">
                    <Transition name="fade" mode="out-in">
                        <div :key="currentSlide" class="text-center px-4 max-w-4xl">
                            <h1 class="text-5xl font-bold text-white mb-4 leading-tight">
                                {{ slides[currentSlide].title }}
                            </h1>
                            <p class="text-xl text-slate-300 mb-8 mx-auto max-w-2xl">
                                {{ slides[currentSlide].description }}
                            </p>
                            <Link :href="route('questions.index')"
                                class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-10 rounded-xl transition transform hover:-translate-y-1 shadow-lg shadow-orange-500/20">
                                Explore Forum
                            </Link>
                        </div>
                    </Transition>
                </div>
            </div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Section Header -->
                    <div class="text-center mb-16">
                        <h2 class="text-base text-orange-600 font-semibold tracking-wide uppercase">Why StakeRow?</h2>
                        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-300 sm:text-4xl">
                            The pulse of modern discussion.
                        </p>
                        <p class="mt-4 max-w-2xl text-xl text-slate-500 lg:mx-auto">
                            Join thousands of curious minds sharing insights, solving problems, and building the future
                            of digital communities.
                        </p>
                    </div>

                  

                    <!-- Sub-Call to Action -->
                    <div class="mt-20 bg-slate-900 rounded-3xl p-8 md:p-12 overflow-hidden relative">
                        <div class="relative  md:flex items-center justify-between">
                            <div class="mb-6 md:mb-0">
                                <h2 class="text-3xl font-bold text-white mb-2">Ready to contribute?</h2>
                                <p class="text-slate-400 text-lg">Your first question or answer could help hundreds of
                                    others.</p>
                            </div>
                            <Link :href="route('register')"
                                class="bg-white text-slate-900 font-bold py-3 px-8 rounded-lg hover:bg-orange-500 hover:text-white transition">
                                Create an Account
                            </Link>
                        </div>
                        <!-- Decorative circle -->
                        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestOpenLayout>
</template>

<style scoped>
/* Standard Vue Transition classes */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>