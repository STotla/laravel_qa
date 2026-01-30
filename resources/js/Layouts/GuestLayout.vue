<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavBar from '@/Components/NavBar.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <NavBar/>
    <div class="flex min-h-screen">
        <!-- Left Side: Visual/Branding (Hidden on mobile) -->
        <div class="hidden w-1/2 bg-slate-900 lg:flex lg:flex-col lg:items-center lg:justify-center">
            <Link href="/">
                <ApplicationLogo class="h-40 w-40 fill-current text-gray-200" />
            </Link>
            <h1 class="mt-4 text-2xl font-bold text-white"></h1>
        </div>

        <!-- Right Side: Content/Form -->
        <div class="flex w-full flex-col items-center justify-center bg-slate-950 px-6 py-12 lg:w-1/2">
            <!-- Mobile Logo (Visible only on small screens) -->
            <div class="mb-8 lg:hidden">
                <Link href="/">
                    <ApplicationLogo class="h-20 w-20 fill-current text-gray-200" />
                </Link>
            </div>

            <!-- Form Container -->
            <div class="w-full bg-slate-800 text-gray-100 px-8 py-10 shadow-md sm:max-w-md sm:rounded-xl">
                <slot />
            </div>
        </div>
    </div>
</template>