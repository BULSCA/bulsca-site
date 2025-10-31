<template>
  <div 
    class="selectable p-4 space-y-4" :data-field-id="field.uuid"
    :style="{ backgroundColor: formColors.white }"
  >

    <div class="flex-col gap-1 space-y-3">
      <div class="flex gap-1 items-start">
        <!-- Order Number -->
        <div class="pt-2 text-lg text-gray-700 w-6 pr-6px text-right">
          {{ index +1 }}.
        </div>

        <!-- Question Label -->
        <div class="pt-2 text-lg text-gray-700 w-auto text-left">
          {{ field.label }}
        </div>

        <div v-if="field.required" class="pt-2 text-lg text-red-500">
          *
        </div>
      </div>

      <div class="flex gap-1 items-start">
        <div class="w-6"></div>
        <!-- submissionField Input -->
        <component
          :is="getComponent(field.type)"
          :field="field"
          :submissionField="submissionField"
          :mode="mode"
        />
      </div>

    </div>
  </div>
</template>
  
<script lang="ts" setup>
import { defineProps } from 'vue';
import TextInput from './questions/TextInput.vue';
import TextareaInput from './questions/TextareaInput.vue';
import MultipleChoiceInput from './questions/MultipleChoiceInput.vue';

const props = defineProps({
  field: Object,
  index: Number,
  submissionField: Object,
  mode: String,
  formColors: Object
});

// Map field types to components
const componentMap = {
  text: TextInput,
  textarea: TextareaInput,
  multiplechoice: MultipleChoiceInput
  // Add more mappings for other field types
};

const getComponent = (type) => componentMap[type] || null;

console.log('submissionField:', props.submissionField);

</script>
  