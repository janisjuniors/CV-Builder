<template>
    <button class="flex items-center p-1 rounded-full w-5 h-5 hover:scale-110" :class="classes">
        <slot/>
    </button>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? `border-4 bg-white`
        : `border-none`;
});
</script>

