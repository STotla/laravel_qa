<script setup>

import { Link } from '@inertiajs/vue3';

defineProps({
    meta: {
        type: Object,
        required: true,
    }
})
</script>

<template>
    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between py-2 px-4"
        aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-300 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing
            <span class="font-semibold text-gray-300">{{ meta.from }}-{{ meta.to }}</span>
            of
            <span class="font-semibold text-gray-300">{{ meta.total }}</span>
        </span>
        <ul class=" bg-slate-950 p-2 inline-flex -space-x-px rtl:space-x-reverse text-sm h-12">

            <li v-for="(link, index) in meta.links" :key="index">

                <Link preserve-scroll :href="link.url ?? ''" v-html="link.label"
                    class="flex items-center justify-center px-3 h-8 ms-0 leading-tight " :class="{
                        'text-blue-600 hover:text-blue-700': link.active, 'text-gray-500 hover:text-gray-700': !link.active
                        , 'text-stone-400 hover:text-stone-400': !link.url
                    }">
                </Link>
            </li>
            <!-- <li>
                <a href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700">1</a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700">2</a>
            </li>
            <li>
                <a href="#" aria-current="page"
                    class="flex items-center justify-center px-3 h-8 text-blue-600 hover:text-blue-700">3</a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700">4</a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700">5</a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700">Next</a>
            </li> -->
        </ul>
    </nav>
</template>