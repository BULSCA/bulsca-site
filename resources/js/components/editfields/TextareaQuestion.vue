<template>
    <textarea
      v-model="textInput"
      :disabled="mode === 'preview'"
      :placeholder="field.placeholder || 'Enter text'"
      class="w-full rounded-md px-3 py-2"
      :class="mode === 'preview' ? 'bg-gray-100' : 'bg-white border border-gray-300'"
    ></textarea>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  import { defineProps } from 'vue';
  
  const props = defineProps({
    field: Object,
  });
  
    // Computed property to handle JSON conversion
    const textInput = computed({
      // Getter: Parse the JSON value into plain text for the input
      get() {
        try {
          return JSON.parse(props.submissionField.answer || '""'); // Parse JSON, default to an empty string if null/undefined
        } catch (e) {
          console.error('Invalid JSON in props.submissionField.answer:', props.submissionField.answer);
          return ''; // Fallback to an empty string if parsing fails
        }
      },
      // Setter: Convert the plain text input into JSON and update props.submissionField.answer
      set(value) {
        try {
          props.submissionField.answer = JSON.stringify(value); // Convert plain text to JSON
        } catch (e) {
          console.error('Failed to stringify value:', value);
        }
      },
    });
  </script>