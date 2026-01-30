<script setup>
import { ref, watch } from 'vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import { onClickOutside } from '@vueuse/core';



const searchQuery= ref('');
const results= ref([]);
const showDropdown=ref(false);
const searchContainer=ref(null);

const performSearch= debounce(async(query)=>{
    if(query.length<2){
        results.value=[];
        return;
    }
    try{
        const response= await axios.get(`/questions/search?q=${query}`);
        results.value= response.data;
        showDropdown.value=true;        
    }catch(error){
        console.error("Search error",error);
    }
},300)

watch(searchQuery, (newVal)=>performSearch(newVal))

onClickOutside(searchContainer,()=>{
   showDropdown.value=false;
   searchQuery.value='';
   results.value=[];
})
</script>

<template>
    <div class=" py-5 flex  px-5 ">
        <div  ref="searchContainer" class="relative flex items-center">
            <input id="searchText" placeholder="Search here.." type="text"
                class="  bg-slate-900  border  rounded mt-1 block w-[350px]" 
                 @focus="showDropdown = true"
                
                    v-model=" searchQuery"
                />
            <MagnifyingGlassIcon class="w-5 h-5  -ml-[23px] font-extrabold" />

            <div v-if="showDropdown && results.length > 0"
                class="absolute max-h-[500px]  overflow-y-scroll left-0 top-10  right-0 mt-2 bg-black border border-gray-200 rounded-lg shadow-xl  overflow-hidden">
                <ul class="divide-y divide-gray-100">
                    <li v-for="question in results" :key="question.id">
                        <Link :href="route('questions.show', question)"
                            class="block px-4 py-3 hover:bg-slate-900 transition">
                        <p class="text-sm font-medium text-white">{{ question.title }}</p>
                        </Link>
                    </li>
                </ul>
            </div>

            <!-- No Results State -->
            <div v-if="showDropdown && searchQuery.length >= 2 && results.length === 0"
                class="absolute left-0 right-0  top-10 mt-2 p-4 bg-black border rounded-lg shadow-xl text-sm text-white">
                No questions found matching your search.
            </div>
        </div>
    </div>
</template>