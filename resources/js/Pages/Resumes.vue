<template>
    <AppLayout title="Resumes">
        <div class="flex justify-center mt-16">
            <div class="flex flex-col space-y-5 lg:w-[40rem]">
                <div class="flex justify-between w-full">
                    <h1 class="font-bold text-xl text-center">All Resumes</h1>
                    <Link :href="route('add')"
                          class="flex text-white bg-lime-600 hover:bg-lime-700 text-sm items-center justify-center rounded px-5 py-1.5">
                        Create Resume
                    </Link>
                </div>
                <div class="overflow-x-auto relative shadow-md border sm:rounded">
                    <table class="text-sm text-left text-gray-500 w-full">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Full Name
                            </th>
                            <th scope="col" class="py-3 px-6">

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="owner in owners" :key="owner.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <span>{{ owner.first_name }} {{ owner.last_name }}</span>
                            </th>
                            <td class="py-4 px-6">
                                <div class="flex space-x-5 justify-end">
                                    <Link :href="route('edit', owner.id)" class="text-blue-700 hover:underline">
                                        Edit
                                    </Link>
                                    <Link :href="route('preview', owner.id)" class="text-lime-700 hover:underline">
                                        Preview
                                    </Link>
                                    <button @click="confirmResumeDeletion(owner)" class="text-red-700 hover:underline">
                                        Delete
                                    </button>
                                </div>
                            </td>

                            <DialogModal :show="confirmingResumeDeletion" @close="closeModal" :max-width="'xl'">
                                <template #title>
                                    Delete {{ selectedOwner.first_name }} {{ selectedOwner.last_name }} Resume
                                </template>
                                <template #content>
                                    Are you sure you want to delete this Resume? Once the resume is deleted, all of its resources and data will be permanently deleted.
                                </template>

                                <template #footer>
                                    <div class="flex justify-between w-full">
                                        <DangerButton @click="deleteCV(selectedOwner.id)">
                                            Delete
                                        </DangerButton>
                                        <SecondaryButton @click="closeModal">
                                            Cancel
                                        </SecondaryButton>
                                    </div>
                                </template>
                            </DialogModal>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<script setup>
import AppLayout from '../Layouts/AppLayout.vue'
import DialogModal from "../Components/DialogModal.vue";
import Button from "../Components/Button.vue";
import SecondaryButton from "../Components/SecondaryButton.vue";
import DangerButton from "../Components/DangerButton.vue";
import {Link, useForm} from '@inertiajs/inertia-vue3'
import Swal from "sweetalert2";
import {ref} from "vue";

const confirmingResumeDeletion = ref(false);
const selectedOwner = ref(null)
const closeModal = () => {
    confirmingResumeDeletion.value = false;
    selectedOwner.value = null
};

const confirmResumeDeletion = (owner) => {
    confirmingResumeDeletion.value = true;
    selectedOwner.value = owner
};

const form = useForm({})
const deleteCV = (id) => {
    form.delete(route('delete', id), {
        onSuccess: () => {
            Toast.fire({
                icon: 'success',
                title: 'CV deleted successfully!'
            })
            closeModal()
        },
    });
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

defineProps({
    owners: Array
})

</script>

