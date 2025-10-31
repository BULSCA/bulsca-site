<script setup lang="ts">
import { BookOpen, Folder, LayoutGrid, Menu, Search } from 'lucide-vue-next';
import Delete from '@/components/icons/DeleteIcon.vue';

const props = defineProps<{
    form: Record<string, any>;
}>();

const emit = defineEmits<{
    (event: 'openColorPicker'): void;
    (event: 'saveForm'): void;
    (event: 'formjson'): void;
    (event: 'tempPrint'): void;
}>();

function openColorPicker() {
	emit('openColorPicker');
}
function saveForm() {
	emit('saveForm');
}
function formjson() {
    emit('formjson');
}
function tempPrint() {
    emit('tempPrint');
}
</script>



<template>
<header class="bg-white shadow-md px-6 py-4 flex items-center justify-between sticky top-0 z-10">
<!-- Left: Back Arrow and Title -->
<div class="flex items-center gap-4">
    <button class="text-gray-600 hover:text-gray-800">
        ←
    </button>
    <h1 class="text-xl font-semibold text-gray-800">{{ form.title ?? 'Untitled Form' }}</h1>
</div>
<!-- Right: Buttons -->
<div class="flex items-center gap-3">
    <button @click="formjson" class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600">Form JSON</button>
    <button @click="tempPrint" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Temp Print</button>
    <button @click="saveForm" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Save</button>
    <button @click="openColorPicker" class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600">Style</button>
    <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Preview</button>
    <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Share</button>
    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
</div>
</header>


</template>