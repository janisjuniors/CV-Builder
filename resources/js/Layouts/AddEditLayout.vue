<template>
    <div @click="$emit('changeTo', parentCategory)" class="fixed flex w-full justify-center border-b shadow">
        <div class="flex space-x-2 p-5">
            <PageLink :href="route('show')">Home</PageLink>

            <Button @click="switchCategory('contact')" :active="childCategory === 'contact'">
                General
            </Button>

            <Button @click="switchCategory('employmentHistorySummary')" :active="childCategory === 'employmentHistory' || childCategory === 'employmentHistorySummary'">
                Employment History
            </Button>

            <Button @click="switchCategory('educationSummary')" :active="childCategory === 'education' || childCategory === 'educationSummary'">
                Education
            </Button>

            <Button @click="switchCategory('skills')" :active="childCategory === 'skills'">
                Skills
            </Button>

            <Button @click="switchCategory('languages')" :active="childCategory === 'languages'">
                Languages
            </Button>

            <Button @click="switchCategory('social')" :active="childCategory === 'social'">
                Social
            </Button>
        </div>
    </div>

    <div>
        <slot/>
    </div>
</template>

<script setup>
import Button from '../Components/Button.vue'
import PageLink from '../Components/PageLink.vue'
import {ref} from "vue";

defineProps({
    childCategory: String
})
defineEmits(['changeTo'])

let parentCategory = ref(null)
const switchCategory = (inputCategory) => {
    parentCategory.value = inputCategory
}

</script>

