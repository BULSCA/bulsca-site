<template>
  <input
    v-model="textInput"
    :disabled="mode === 'preview' || mode === 'edit'"
    type="text"
    :placeholder="field.placeholder || 'Short answer text'"
    class="w-1/2 py-1 text-sm"
    :class="mode === 'preview' || mode === 'edit' ? 'border-b-1 border-dotted border-gray-300' : 'bg-white border border-gray-300'"
  />
</template>

<script setup>
import { computed } from 'vue';
import { defineProps } from 'vue';

const props = defineProps({
  field: Object,
  submissionField: Object,
  mode: String,
  form_primary_color: String, // Primary color for styling
  form_secondary_color: String, // Secondary color for styling
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