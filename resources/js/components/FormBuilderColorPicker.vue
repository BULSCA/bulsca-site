<script lang="ts" setup>
import { ref } from 'vue';
import ColorPickerInput from './FormBuilderColorPickerInput.vue';

const props = defineProps<{
	form_primary_color: string;
	form_secondary_color: string;
}>();
const emit = defineEmits<{
	(event: 'close'): void;
	(event: 'save', colors: { primary: string; secondary: string }): void;
}>();
const tempPrimary = ref(props.form_primary_color);
const tempSecondary = ref(props.form_secondary_color);

function closeColorPicker() {
	emit('close');
}
function saveColors() {
	emit('save', { primary: tempPrimary.value, secondary: tempSecondary.value });
}
</script>



<template>
	<div class="fixed inset-0 z-50 flex items-center justify-center">
		<div class="absolute inset-0 bg-black/50" @click="closeColorPicker"></div>
		<div class="relative bg-white rounded-lg shadow-lg w-full max-w-md p-6">
			<h3 class="text-lg font-semibold mb-4">Choose theme colors</h3>
			<div class="grid grid-cols-2 gap-6">
				<ColorPickerInput
					label="Primary"
					v-model="tempPrimary"
					placeholder="#9e0d06"
				/>
				<ColorPickerInput
					label="Secondary"
					v-model="tempSecondary"
					placeholder="#454488"
				/>
			</div>
			<div class="mt-6 flex items-center justify-between">
				<div class="flex items-center gap-2">
					<span class="text-sm text-gray-600">Preview:</span>
					<span
						:style="{ backgroundColor: tempPrimary }"
						class="inline-block w-6 h-6 rounded"
					></span>
					<span
						:style="{ backgroundColor: tempSecondary }"
						class="inline-block w-6 h-6 rounded"
					></span>
				</div>
				<div class="flex gap-2">
					<button
						@click="closeColorPicker"
						class="px-3 py-1 rounded border border-gray-300 text-gray-700 hover:bg-gray-50"
					>
						Cancel
					</button>
					<button
						@click="saveColors"
						class="px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700"
					>
						Save
					</button>
				</div>
			</div>
		</div>
	</div>
</template>
