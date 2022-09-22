<template>
    <Head :title="title"/>

    <main>
        <slot />
    </main>
</template>

<script setup>
import {Head} from "@inertiajs/inertia-vue3";

defineProps({
    title: String,
});


</script>
