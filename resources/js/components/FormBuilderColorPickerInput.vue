<script lang="ts" setup>
import { ref } from 'vue';

const props = defineProps<{
    label: string;
    modelValue: string;
    placeholder?: string;
}>();

const emit = defineEmits<{
    (event: 'update:modelValue', value: string): void;
}>();

function updateValue(event: Event) {
    const target = event.target as HTMLInputElement;
    emit('update:modelValue', target.value);
}
</script>

<template>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ label }}</label>
        <input
            type="color"
            :value="modelValue"
            @input="updateValue"
            class="w-full h-10 border border-gray-300 rounded"
        />
        <input
            type="text"
            :value="modelValue"
            @input="updateValue"
            :placeholder="placeholder"
            class="w-full mt-2 p-2 border border-gray-300 rounded"
        />
    </div>
</template>

<style scoped>
/* Add any additional styles here if needed */
</style>