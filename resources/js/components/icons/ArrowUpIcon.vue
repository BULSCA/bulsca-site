<!-- components/icons/ArrowUpIcon.vue -->
<script setup>
defineProps({
  color: {
    type: String,
    default: '#000000', // Default to black
  },
});
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        viewBox="0 0 24 24"
        stroke="none"
        :style="{ color }"
        class="w-6 h-6"
    >
        <path d="M4.21 10.733a.75.75 0 0 0 1.086 1.034l5.954-6.251V20.25a.75.75 0 0 0 1.5 0V5.516l5.955 6.251a.75.75 0 0 0 1.086-1.034l-7.067-7.42a.995.995 0 0 0-.58-.3.754.754 0 0 0-.29.001.995.995 0 0 0-.578.3L4.21 10.733Z"></path>
    </svg>
</template>
