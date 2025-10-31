<!-- components/FieldEditor.vue -->
<template>
  <div :style="{backgroundColor: formColors.white }" class=" rounded shadow-lg relative " :data-field-id="field.uuid">
    <div :style="{ backgroundColor: formColors.primary }" class="absolute h-full w-2 rounded-l-md"></div>
    <div class="selectable p-4 space-y-4">

      <div class="flex gap-4 items-start">
        <!-- Order Number -->
        <div class="pt-2 text-lg font-semibold text-gray-700 w-6 text-right">
          {{ index +1 }}.
        </div>

        <!-- Question + Answer -->
        <div class="flex-1 space-y-3">
          <!-- Question Label -->
          <input
            v-model="field.label"
            :style="{backgroundColor: formColors.white }"
            class="w-full border border-gray-300 rounded-md px-3 py-2"
            :placeholder="field.label || 'question'"
          />

          <!-- Answer Input -->
          <component
            :is="getComponent(field.type)"
            :field="field"
            :submissionField="submissionField"
            :mode="'edit'"
          />
        </div>
      </div>

      <hr class="my-5">

      <!-- Options Section -->
      <div class="flex items-center justify-end gap-2">
        <label class="inline-flex items-center cursor-pointer">
          <input type="checkbox" v-model="field.required" class="sr-only peer">
          <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
          <span class="ms-3 text-sm font-medium text-gray-600 dark:text-gray-300">Required</span>
        </label>
      </div>


    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits, computed } from 'vue';
import CopyIcon from './icons/CopyIcon.vue';
import DeleteIcon from './icons/DeleteIcon.vue';
import ArrowDownIcon from './icons/ArrowDownIcon.vue';
import ArrowUpIcon from './icons/ArrowUpIcon.vue';
import TextQuestion from './questions/TextInput.vue';
import TextareaQuestion from './questions/TextareaInput.vue';
import MultipleChoiceQuestion from './editfields/MultipleChoiceQuestion.vue';

const props = defineProps({
  field: Object,
  index: Number,
  submissionField: Object,
  total: Number,
  formColors: Object
});

console.log('field type:', props.field.type);

const emit = defineEmits(['copy', 'delete', 'moveUp', 'moveDown']);

function copyField() {
  emit('copy', props.field, props.index);
}

function deleteField() {
  emit('delete', props.field, props.index);
}

function moveUp() {
  emit('moveUp', props.field, props.index);
}

function moveDown() {
  emit('moveDown', props.field, props.index);
}

// Map field types to components
const componentMap = {
  text: TextQuestion,
  textarea: TextareaQuestion,
  multiplechoice: MultipleChoiceQuestion,
  // Add more mappings for other field types
};

const getComponent = (type) => componentMap[type] || null;
</script>
  