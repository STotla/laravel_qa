<script setup>

defineProps({
    user: {
        type: Object,
        required: true,
    },
    title: {
        type: String,
        required: false,
    }
});
</script>
<template>
    <div class="flex items-center ">
        <span v-if="title" class="text-sm text-gray-400">{{ title }}: </span>
        <div class="inline-block ml-2 mr-1">
            <img :src="user.avatar_url" alt="User Avatar" class="h-8 w-8 rounded-full object-cover">
        </div>
        <span class="font-semibold text-gray-300">{{ user.name }}</span>
    </div>
</template>