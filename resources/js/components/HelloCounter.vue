<template>
<div class="p-4 border rounded">
    <p class="mb-2">Count: {{ count }}</p>
    <button class="px-3 py-1 bg-bulsca text-white rounded" @click="count++">Increment</button>
</div>
</template>
  
<script lang="ts" setup>
import { ref } from 'vue'
const count = ref(0)
</script>