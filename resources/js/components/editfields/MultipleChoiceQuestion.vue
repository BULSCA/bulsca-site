<template>
  <div class="space-y-4">
    <!-- Display the options in edit mode -->
    <div v-if="mode === 'edit'">
      <div v-for="(option, index) in editableOptions" :key="index" class="flex items-center space-x-2">
        <!-- Checkbox for each option -->
        <input
          type="checkbox"
          :value="option"
          v-model="selectedOptions"
          :disabled="true" 
          class="form-checkbox h-5 w-5 text-blue-600"
        />
        <!-- Editable text input for the option -->
        <input
          type="text"
          v-model="editableOptions[index]"
          @input="handleOptionEdit(index)"
          placeholder="Add option"
          class="w-full px-3 py-2 border-b-2 border-gray-300 focus:outline-none focus:border-blue-500"
          :style="{
                    '--tw-border-opacity': '1',
                    borderColor: 'transparent',
          }"
          @focus="(e) => (e.target as HTMLInputElement).style.borderColor = form_primary_color"
          @blur="(e) => (e.target as HTMLInputElement).style.borderColor = 'transparent'"
        />
        <!-- Remove button -->
        <button
          v-if="index < editableOptions.length - 1"
          @click="removeOption(index)"
          class="text-red-500 hover:text-red-700"
        >
          ✕
        </button>
      </div>
    </div>

    <!-- Display the options in view/preview mode -->
    <div v-else>
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
  </div>
</template>

<script lang=ts setup>
import { computed, ref, watch } from 'vue';
import { defineProps } from 'vue';

// Define props
const props = defineProps({
  field: Object, // Field configuration (e.g., label, options)
  submissionField: Object, // Submission field object
  mode: String, // Mode: 'preview', 'view', or 'edit'
  form_primary_color: String, // Primary color for styling
  form_secondary_color: String, // Secondary color for styling
});

// Reactive copy of options for editing
const editableOptions = ref([]);

// Parse the options from the field's JSON configuration
const parsedOptions = computed(() => {
  try {
    return JSON.parse(props.field.options || '[]'); // Parse JSON, default to an empty array if null/undefined
  } catch (e) {
    console.error('Invalid JSON in props.field.options:', props.field.options);
    return []; // Fallback to an empty array if parsing fails
  }
});

// Sync editableOptions with parsedOptions when the component is initialized
watch(
  () => parsedOptions.value,
  (newOptions) => {
    editableOptions.value = [...newOptions, '']; // Add a placeholder option at the end
  },
  { immediate: true }
);

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

// Handle editing of an option
const handleOptionEdit = (index) => {
  // If the user is editing the placeholder option, add it to the options
  if (index === editableOptions.value.length - 1 && editableOptions.value[index].trim() !== '') {
    editableOptions.value.push(''); // Add a new placeholder option
    updateFieldOptions(); // Update the field.options JSON
  }
};

// Add a new option
const addOption = () => {
  editableOptions.value.push(''); // Add an empty string as a new option
};

// Remove an option
const removeOption = (index) => {
  editableOptions.value.splice(index, 1); // Remove the option at the specified index
  updateFieldOptions(); // Update the field.options JSON
};

// Update the field.options JSON whenever editableOptions changes
const updateFieldOptions = () => {
  // Exclude the placeholder option when updating the field.options JSON
  const realOptions = editableOptions.value.slice(0, -1);
  props.field.options = JSON.stringify(realOptions); // Update the field.options JSON
};

// Watch for changes to editableOptions and sync them back to field.options
watch(
  editableOptions,
  (newOptions) => {
    updateFieldOptions(); // Sync the changes back to field.options
  },
  { deep: true }
);
</script>