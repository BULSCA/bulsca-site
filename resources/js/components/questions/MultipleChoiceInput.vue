<template>
  <div class="space-y-4">
    <!-- Loop through the options and render checkboxes -->
    <div v-for="(option, index) in parsedOptions" :key="index">
      <label class="flex items-center space-x-2">
        <input
          type="checkbox"
          :value="option"
          v-model="selectedOptions"
          :disabled="mode === 'preview'"
          class="form-checkbox h-5 w-5 text-blue-600"
        />
        <span>{{ option }}</span>
      </label>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { defineProps } from 'vue';

// Define props
const props = defineProps({
  field: Object, // Field configuration (e.g., label, options)
  submissionField: Object, // Submission field object
  mode: String, // Mode: 'preview' or 'view'
});

// Parse the options from the field's JSON configuration
const parsedOptions = computed(() => {
  try {
    return JSON.parse(props.field.options || '[]'); // Parse JSON, default to an empty array if null/undefined
  } catch (e) {
    console.error('Invalid JSON in props.field.options:', props.field.options);
    return []; // Fallback to an empty array if parsing fails
  }
});

// Computed property to handle the selected options
const selectedOptions = computed({
  // Getter: Parse the selected options from submissionField.answer
  get() {
    try {
      return JSON.parse(props.submissionField.answer || '[]'); // Parse JSON, default to an empty array if null/undefined
    } catch (e) {
      console.error('Invalid JSON in props.submissionField.answer:', props.submissionField.answer);
      return []; // Fallback to an empty array if parsing fails
    }
  },
  // Setter: Convert the selected options to JSON and update submissionField.answer
  set(value) {
    props.submissionField.answer = JSON.stringify(value); // Convert the array to JSON
  },
});
</script>