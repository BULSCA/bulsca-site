<template>
<div class="flex justify-end items-center">
  <div class="flex gap-2">
    <button @click="copyField" aria-label="Copy question" class="text-gray-600 hover:text-blue-600 cursor-pointer">
      <CopyIcon />
    </button>
    <button @click="deleteField" aria-label="Delete question" class="text-gray-600 hover:text-red-600 cursor-pointer">
      <DeleteIcon />
    </button>
    <button
      @click="moveDown"
      :disabled="index === total - 1"
      :class="[
        'transition',
        props.index !== total-1 ? 'cursor-pointer' :
        index === total - 1
          ? 'text-gray-400 cursor-not-allowed'
          : 'text-gray-600 hover:text-gray-800'
      ]"
      aria-label="Move question down"
    >
      <ArrowDownIcon :style="{ color: index === total - 1 ? '#9CA3AF' : '#000000' }" />
    </button>
    <button
      @click="moveUp"
      :disabled="props.index === 0"
      :class="[
        'hover:text-gray-800',
        props.index !== 0 ? 'cursor-pointer' :
        props.index === 0 ? 'text-gray-400 cursor-not-allowed' : 'text-gray-600'
      ]"
      aria-label="Move question up"
    >
      <ArrowUpIcon :style="{ color: index === 0 ? '#9CA3AF' : '#000000' }" />
    </button>
  </div>
  <div class="flex gap-2">
    <button class="text-gray-500 hover:text-gray-700"><i class="fa fa-arrows-alt"></i></button>
    <button class="text-gray-500 hover:text-gray-700"><i class="fa fa-copy"></i></button>
    <button class="text-gray-500 hover:text-gray-700"><i class="fa fa-cog"></i></button>
  </div>
</div>
</template>






<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';
import CopyIcon from '../icons/CopyIcon.vue';
import DeleteIcon from '../icons/DeleteIcon.vue';
import ArrowDownIcon from '../icons/ArrowDownIcon.vue';
import ArrowUpIcon from '../icons/ArrowUpIcon.vue';

const props = defineProps({
  field: Object,
  index: Number,
  total: Number,
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

</script>
  