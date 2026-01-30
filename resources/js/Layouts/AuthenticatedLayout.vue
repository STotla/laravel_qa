<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link,router,usePage } from '@inertiajs/vue3';
import Toast from '@/Components/toast/Toast.vue';
import NavBar from '@/Components/NavBar.vue';

const showingNavigationDropdown = ref(false);
const showToastBox= ref(false)

router.on('finish', ()=>{
 
    showToastBox.value = !!usePage().props.toast.message;
})
</script>

<template>
      <Head :title="title" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">

        <div class="relative flex  flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full   lg:max-w-8xl">
                <NavBar />
                <header class="">

                </header>

                <main class="bg-slate-950 min-h-screen ">
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
