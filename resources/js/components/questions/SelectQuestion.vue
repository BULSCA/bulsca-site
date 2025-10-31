<template>
    <div>
      <label>{{ question.label }}</label>
  
      <!-- Fill mode: user selects an option -->
      <select v-if="mode === 'fill'" v-model="localValue">
        <option disabled value="">-- Select an option --</option>
        <option v-for="option in question.options" :key="option" :value="option">
          {{ option }}
        </option>
      </select>
  
      <!-- Edit mode: admin edits the label and options -->
      <div v-else-if="mode === 'edit'">
        <input type="text" v-model="question.label" placeholder="Question label" />
        <div v-for="(option, index) in question.options" :key="index">
          <input type="text" v-model="question.options[index]" placeholder="Option text" />
        </div>
        <button @click="addOption">Add Option</button>
      </div>
  
      <!-- Preview mode: show selected value -->
      <div v-else>
        <span>{{ localValue || 'No selection made' }}</span>
      </div>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  
  export default defineComponent({
    name: 'SelectQuestion',
    props: {
      question: {
        type: Object,
        required: true
      },
      mode: {
        type: String,
        required: true
      },
      modelValue: {
        type: String,
        required: false
      }
    },
    emits: ['update:modelValue'],
    computed: {
      localValue: {
        get(): string {
          return this.modelValue || '';
        },
        set(val: string) {
          this.$emit('update:modelValue', val);
        }
      }
    },
    methods: {
      addOption() {
        if (!this.question.options) {
          this.question.options = [];
        }
        this.question.options.push('');
      }
    }
  });
  </script>
  