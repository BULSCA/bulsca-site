<template>
  <input
    v-if="mode === 'preview'"
    type="text"
    disabled
    placeholder="Text submissionField"
    class="w-full rounded-md px-3 py-2 bg-gray-100"
  />
  <input
    v-if="mode === 'view'"
    v-model="textInput"
    type="text"
    placeholder="Text answer"
    class="w-full rounded-md px-3 py-2 bg-white border border-gray-300"
  />
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  
  export default defineComponent({
    name: 'TextQuestion',
    props: {
      question: Object,
      mode: String,
      modelValue: String
    },
    emits: ['update:modelValue'],
    computed: {
      localValue: {
        get() {
          return this.modelValue;
        },
        set(val: string) {
          this.$emit('update:modelValue', val);
        }
      }
    }
  });
  </script>
  