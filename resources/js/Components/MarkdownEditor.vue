<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import autosize from 'autosize';
import MarkdownIt from 'markdown-it';
import prism from 'markdown-it-prism';
const activeTab = ref('write');


 const props = defineProps({
    content: {
        type: String,
        default: '',
    },
});
const md = new MarkdownIt();
    md.use(prism);

const preview = computed(() => {
    return md.render(props.content || '');
});


onMounted(() => {
    const slotElements = document.querySelectorAll('textarea');
    slotElements.forEach((el) => {
        autosize(el);
    });
});

</script>
<template>

    <!-- Header / Tabs -->
    <div>
        <div class="flex items-center justify-between p-4 border-b border-slate-800 bg-slate-900/50">
            <div class="inline-flex p-1 bg-slate-950 rounded-xl border border-slate-800/50">
                <button @click.prevent="activeTab = 'write'"
                    :class="activeTab === 'write' ? 'bg-slate-800 text-white shadow-lg ring-1 ring-slate-700' : 'text-slate-500 hover:text-slate-300'"
                    class="px-5 py-2 text-sm font-semibold rounded-lg transition-all duration-200">
                    Write
                </button>
                <button @click.prevent="activeTab = 'preview'"
                    :class="activeTab === 'preview' ? 'bg-slate-800 text-white shadow-lg ring-1 ring-slate-700' : 'text-slate-500 hover:text-slate-300'"
                    class="px-5 py-2 text-sm font-semibold rounded-lg transition-all duration-200">
                    Preview
                </button>
            </div>
            <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse mr-2" title="Synced"></div>
        </div>

        <!-- Content Area -->
        <div class="p-6">
            <!-- Write Div -->
            <div v-show="activeTab == 'write'" class="h-full flex flex-col">
                <slot></slot>   
            </div>

            <!-- Preview Div -->
            <div v-show="activeTab == 'preview'" 
                class="h-full p-6  bg-slate-950 text-white overflow-y-auto prose prose-invert prose-slate max-w-none" v-html="preview">
            </div>
        </div>
    </div>
</template>