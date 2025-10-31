<template>
<hr class="my-5">
<div class="flex items-center justify-end gap-2 px-3">
  <label class="inline-flex items-center cursor-pointer">
    <input type="checkbox" v-model="field.required" class="sr-only peer">
    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
    <span class="ms-3 text-sm font-medium text-gray-600 dark:text-gray-300">Required</span>
  </label>
</div>
</template>


<script setup lang="ts">
import { defineProps } from 'vue';

const props = defineProps<{
  field: Object,
  index: Number,
  submissionField: Object,
  total: Number,
  form_primary_color?: String,
  form_secondary_color?: String,
}>();

</script>