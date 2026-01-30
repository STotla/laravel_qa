omponent (About.vue)
vue
<script setup>
import { Head } from '@inertiajs/vue3';
import GuestOpenLayout from '@/Layouts/GuestOpenLayout.vue';
import { 
  CodeBracketIcon, 
  ChevronUpIcon, 
  CheckBadgeIcon 
} from '@heroicons/vue/24/outline';

// For 24x24 Solid icons
import { StarIcon } from '@heroicons/vue/24/solid';

const features = [
    {
        title: 'Smart Questioning',
        description: 'Ask complex technical questions with full Markdown support and real-time previews powered by Vue.',
        icon: CodeBracketIcon,
        color: 'text-blue-400'
    },
    {
        title: 'Voting Engine',
        description: 'A robust community-driven ranking system to ensure high-quality content rises to the top.',
        icon: ChevronUpIcon,
        color: 'text-orange-500'
    },
    {
        title: 'Verified Solutions',
        description: 'Empowering authors to mark the "Best Answer," saving time for thousands of future developers.',
        icon: CheckBadgeIcon,
        color: 'text-green-400'
    },
    {
        title: 'Personal Library',
        description: 'Save critical solutions to your favorites for quick access whenever you hit a roadblock.',
        icon: StarIcon,
        color: 'text-yellow-400'
    }
];
</script>

<template>
    <Head title="About Us" />

    <GuestOpenLayout>
        <div class="bg-slate-950 text-slate-200 min-h-screen">
            <!-- Hero Section -->
            <section class="relative py-20 overflow-hidden border-b border-slate-800">
                <div class="container mx-auto px-6 relative ">
                    <div class="max-w-3xl">
                        <span class="text-orange-500 font-mono font-semibold tracking-widest uppercase text-sm">Our Mission</span>
                        <h1 class="text-5xl md:text-6xl font-extrabold text-white mt-4 mb-6 leading-tight">
                            Building the world's most <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-rose-500">efficient knowledge base.</span>
                        </h1>
                        <p class="text-xl text-slate-400 leading-relaxed">
                            Stackerow is more than just a clone. It's a high-performance ecosystem built with 
                            <span class="text-white border-b-2 border-orange-500">Laravel 12</span> and 
                            <span class="text-white border-b-2 border-emerald-500">Vue 3</span>, 
                            designed to help developers solve problems in record time.
                        </p>
                    </div>
                </div>
                <!-- Subtle Background Grid Decor -->
                <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: radial-gradient(#444 1px, transparent 1px); background-size: 30px 30px;"></div>
            </section>

            <!-- Feature Bento Grid -->
            <section class="py-24 container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="feature in features" :key="feature.title" 
                         class="bg-slate-900 border border-slate-800 p-8 rounded-2xl hover:border-orange-500/50 transition-all duration-300 group">
                        <component :is="feature.icon" class="w-10 h-10 mb-6 transition-transform group-hover:scale-110" :class="feature.color" />
                        <h3 class="text-xl font-bold text-white mb-3">{{ feature.title }}</h3>
                        <p class="text-slate-400 leading-relaxed">{{ feature.description }}</p>
                    </div>
                </div>
            </section>

            <!-- Technical Stack / Call to Action -->
            <section class="py-20 bg-slate-900/50">
                <div class="container mx-auto px-6">
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-12 border border-slate-700 flex flex-col md:flex-row items-center justify-between">
                        <div class="md:w-2/3">
                            <h2 class="text-3xl font-bold text-white mb-4">Under the hood</h2>
                            <p class="text-slate-400 text-lg mb-8">
                                Leveraging Inertia.js for seamless SPA transitions, we provide a lightning-fast experience without sacrificing the SEO benefits and security of a Laravel backend.
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <span class="px-4 py-2 bg-slate-800 rounded-full text-sm font-mono text-orange-400 border border-slate-700">PHP 8.3</span>
                                <span class="px-4 py-2 bg-slate-800 rounded-full text-sm font-mono text-emerald-400 border border-slate-700">Vue.js 3</span>
                                <span class="px-4 py-2 bg-slate-800 rounded-full text-sm font-mono text-sky-400 border border-slate-700">Tailwind CSS</span>
                                <span class="px-4 py-2 bg-slate-800 rounded-full text-sm font-mono text-red-400 border border-slate-700">Laravel</span>
                            </div>
                        </div>
                        <div class="mt-10 md:mt-0">
                            <Link class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-10 rounded-xl transition transform hover:-translate-y-1 shadow-lg shadow-orange-500/20">
                                Join the Community
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </GuestOpenLayout>
</template>