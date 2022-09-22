<template>
    <input
        type="text"
        class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded w-full p-2 outline-gray-300"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    />
</template>

<script setup>
defineProps({
    modelValue: String,
});
</script>

