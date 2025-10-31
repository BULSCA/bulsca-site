<template>
    <div>
      <label>{{ question.label }}</label>
      <input
        v-if="mode === 'fill'"
        type="text"
        v-model="localValue"
      />
      <input
        v-else-if="mode === 'edit'"
        type="text"
        v-model="question.label"
      />
      <div v-else>
            <!-- Answer Input -->
            <input
              type="text"
              disabled
              placeholder="Text answer"
              class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100"
            />
      </div> 
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  
  export default defineComponent({
    name: 'TextQuestion',
    props: {
      question: Object,
      index: Number,
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
  