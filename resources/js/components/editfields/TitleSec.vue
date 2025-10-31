<template>
    <div class="mb-6 rounded-md shadow bg-white">
        <div :style="{ backgroundColor: form_primary_color }" class="h-3 w-full rounded-t-md"></div>

        <div class=" px-6 pt-3 pb-6 space-y-3 ">
            <input
                v-model="titlesec.title"
                placeholder="Form Title"
                :style="{
                    '--tw-border-opacity': '1',
                    borderColor: 'transparent',
                }"
                :class="[
                    'block w-full text-4xl border-b-2 focus:border-b-2 focus:outline-none'
                ]"
                @focus="(e) => (e.target as HTMLInputElement).style.borderColor = form_primary_color"
                @blur="(e) => (e.target as HTMLInputElement).style.borderColor = 'transparent'"
            />
            <hr v-if="titleError" class="h-px -mt-4 bg-red-500 border-0" />
            <p v-if="titleError" class="text-red-500 text-sm">{{ titleError }}</p>

            <textarea
                ref="descRef"
                v-model="titlesec.description"
                rows="1"
                placeholder="Form Description"
                class=" block w-full border-b-2 focus:outline-none resize-none overflow-hidden"
                :class="[
                    'w-full border',
                    descriptionError ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-300'
                ]"
                :style="{
                '--tw-border-opacity': '1',
                borderTop: 'none',
                borderLeft: 'none',
                borderRight: 'none',
                borderColor: 'transparent',
                backgroundColor: 'transparent',
                }"
                @focus="(e) => (e.target as HTMLInputElement).style.borderColor = form_primary_color"
                @blur="(e) => (e.target as HTMLInputElement).style.borderColor = 'transparent'"
                @input="adjustTextareaHeight"
            />
            <hr v-if="descriptionError" class="h-px -mt-4 bg-red-500 border-0" />
            <p v-if="descriptionError" class="text-red-500 text-sm">{{ descriptionError }}</p>
        </div>
    </div>
</template>
  
<script lang="ts" setup>
import { ref, watch, onMounted, nextTick} from 'vue';

const props = defineProps<{
    titlesec: Object,
    index: Number,
    form_primary_color?: String,
    form_secondary_color?: String,
    titleError?: String,
    descriptionError?: String,
}>();


const titlesec = props.titlesec;

const descRef = ref<HTMLTextAreaElement | null>(null);

function adjustTextareaHeight(e?: Event) {
  const el = (e?.target as HTMLTextAreaElement) ?? descRef.value;
  if (!el) return;
  el.style.height = 'auto';
  el.style.height = `${el.scrollHeight}px`;
}


onMounted(() => {
  // initialize height
  nextTick(() => adjustTextareaHeight());
});

// react to external description changes
watch(
  () => titlesec.description,
  () => nextTick(() => adjustTextareaHeight()),
  { immediate: true }
);
</script>
  