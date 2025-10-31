<script lang="ts" setup>
import { withDefaults, defineProps, defineEmits, ref, onMounted, onBeforeUnmount } from 'vue';

const props = withDefaults(defineProps<{
  form_primary_color: string;
  form_secondary_color: string;
  selected?: boolean;
  selectKey: string;
  showToolbar?: boolean;
}>(), {
  selected: false,
  showToolbar: false,
});

const emit = defineEmits<{
  (e: 'select', key: string): void;
  (e: 'unselect'): void;
}>();

const root = ref<HTMLElement | null>(null);

function onSelect() {
  emit('select', props.selectKey);
}

function onDocumentPointerDown(e: PointerEvent) {
  const el = root.value;
  if (!el) return;
  const target = e.target as Node | null;
  if (props.selected && target && !el.contains(target)) {
    emit('unselect');
  }
}
function onDocumentKeydown(e: KeyboardEvent) {
  if (props.selected && e.key === 'Escape') emit('unselect');
}

onMounted(() => {
  document.addEventListener('pointerdown', onDocumentPointerDown, true);
  document.addEventListener('keydown', onDocumentKeydown, true);
});
onBeforeUnmount(() => {
  document.removeEventListener('pointerdown', onDocumentPointerDown, true);
  document.removeEventListener('keydown', onDocumentKeydown, true);
});
</script>

<template>
  <div
    ref="root"
    class="relative mb-6 rounded-md bg-white shadow-sm transition-all"
    :class="selected ? 'shadow-xl' : 'hover:shadow-md'"
    role="button"
    tabindex="0"
    :aria-selected="!!selected"
    @click.stop="onSelect"
    @keydown.enter.stop.prevent="onSelect"
    @keydown.space.stop.prevent="onSelect"
  >
    <!-- Accent -->
    <div 
      class="absolute left-0 top-0 h-full rounded-l transition-all duration-200"
      :class="selected ? 'bg-green-500 w-2 opacity-100' : 'bg-transparent w-0 opacity-0'"
    ></div>

    <div class="px-6 py-6 space-y-4">
      <!-- Toolbar slot (only when selected and enabled) -->
      <Transition name="fade-slide">
        <div v-if="showToolbar && selected">
          <slot name="toolbar" />
        </div>
      </Transition>

      <slot />

      <!-- Optionbar -->
      <Transition name="fade-slide">
        <div v-if="showToolbar && selected">
          <slot name="optionbar" />
        </div>
      </Transition>
    </div>
  </div>
</template>


<style scoped>
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-6px);
}
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: opacity 150ms ease, transform 150ms ease;
}
</style>
