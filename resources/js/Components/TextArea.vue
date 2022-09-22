<template>
    <textarea
        class="p-2 w-full text-sm text-gray-900 bg-gray-50 rounded border border-gray-200 outline-gray-300 resize-none"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)">
    </textarea>

</template>

<script setup>
defineProps({
    modelValue: String,
});
</script>

