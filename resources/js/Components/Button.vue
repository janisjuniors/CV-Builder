<template>
    <button :class="classes" class="flex text-sm items-center justify-center rounded text-white disabled:opacity-60 px-5 py-1.5">
        <slot />
    </button>
</template>

<script setup>
import {computed} from "vue";

const props = defineProps({
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'bg-lime-700'
        : 'bg-lime-600 hover:bg-lime-700';
});
</script>
