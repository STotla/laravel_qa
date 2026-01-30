<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const avatarPreview = ref(null);
const user = usePage().props.auth.user;

const form = useForm({
    _method: 'patch',
    name: user.name,
    email: user.email,
    avatar: null,
    avatar_url: user.avatar_url,
});
avatarPreview.value = user.avatar_url;
const handleFileSelect = (event) => {
    const file = event.target.files[0];
    form.avatar = file;

    if (file) {
        avatarPreview.value = URL.createObjectURL(file);
    }
};

const submitForm = () => {
    form.post(route('profile.update'), {
        forceFormData: true,
        onSuccess: () => {
            // Handle success if needed
        },
        onError: (errors) => {
            console.error('Error updating profile:', errors);
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6" enctype="multipart/form-data">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link :href="route('verification.send')" method="post" as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                    A new verification link has been sent to your email address.
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <InputLabel for="avatar" value="Avatar" />

                    <input id="avatar" name="avatar" @input="handleFileSelect" type="file"
                        class="mt-1 block bg-slate-950 w-full" />

                    <InputError class="mt-2" :message="form.errors.avatar" />
                </div>
                <div class="flex justify-center" v-if="avatarPreview">
                    <img :src="avatarPreview" alt="Avatar Preview" class="mt-2 h-40 w-40 rounded-full object-cover" />
                </div>

            </div>


            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
