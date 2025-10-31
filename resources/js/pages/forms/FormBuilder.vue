<template>
  <div :style="{ backgroundColor: form_secondary_color }" class="min-h-screen pb-46">

    <Header
      :form="form"
      @openColorPicker="openColorPicker"
      @saveForm="saveForm"
      @formjson="formjson"
      @tempPrint="tempPrint"
    />

    <ColorPicker
      v-if="showColorPicker"
      :form_primary_color="form_primary_color"
      :form_secondary_color="form_secondary_color"
      @close="closeColorPicker"
      @save="saveColors"
    />



    <main class=" container-responsive mt-8">
      <!-- Title and Description -->
      <div v-for="(section, sIdx) in data">

        <div
          class="selectable"
        >
          <TitleSec
            :form="form"
            :titlesec="section.titlesec"
            :index="sIdx"
            :form_primary_color="form_primary_color"
            :form_secondary_color="form_secondary_color"
            :title-error="titleError(sIdx)"
            :description-error="descriptionError(sIdx)"
          />
        </div>




        <div class="space-y-4">
          <SelectableContainer
            v-for="(field, fIdx) in section.fields"
            :key="field.id ?? fIdx"
            :form_primary_color="form_primary_color"
            :form_secondary_color="form_secondary_color"
            :selected="isSelected(fieldKey(field, fIdx))"
            :select-key="fieldKey(field, fIdx)"
            :show-toolbar="true"
            @select="select"
            @unselect="clearSelection"
            :class="hasFieldError(sIdx, fIdx) ? 'ring-2 ring-red-500 ring-offset-0' : ''"
          >
            <template #toolbar>
              <Toolbar
                :field="field"
                :index="fIdx"
                :total="section.fields.length"
                @copy="copyfield(sIdx, fIdx)"
                @delete="handleDelete(sIdx, fIdx)"
                @moveUp="moveFieldUp(sIdx, fIdx)"
                @moveDown="moveFieldDown(sIdx, fIdx)"
              />
            </template>

            <div class="flex-1 space-y-3">
              <input
                v-if="isSelected(fieldKey(field, fIdx))"
                v-model="field.label"
                :class="[
                  'focus:outline-none focus:border-b-2 hover:bg-gray-200',
                  'w-full p-2 bg-gray-100 text-lg border-b-1 border-gray-300'
                ]"
                :placeholder="field.label || 'Question'"
                @focus="(e) => (e.target as HTMLInputElement).style.borderColor = form_primary_color"
                @blur="(e) => (e.target as HTMLInputElement).style.borderColor = 'gray'"
              />
              <div v-else class="flex gap-1 items-start">
                <div class="pt-2 w-auto text-md text-left">
                  {{ field.label ?? 'Question' }}
                </div>
                <div v-if="field.required" class="pt-2 text-lg text-red-500">*</div>
              </div>

              <hr v-if="hasFieldError(sIdx, fIdx)" class="h-px -mt-3 bg-red-500 border-0" />
              <p v-if="hasFieldError(sIdx, fIdx)" class="text-sm text-red-600">
                {{ fieldError(sIdx, fIdx) }}
              </p>

              <component
                :is="getComponent(field.type)"
                :field="field"
                :submissionField="getFakeSubmissionField(sIdx, fIdx)"
                :mode="'edit'"
                :form_primary_color="form_primary_color"
                :form_secondary_color="form_secondary_color"
              />
            </div>

            <template #optionbar>
              <Optionsbar
                  :field="field"
                  :index="fIdx"
                  :total="section.fields.length"
                  :form_primary_color="form_primary_color"
                  :form_secondary_color="form_secondary_color"
                />
            </template>
          </SelectableContainer>
 
          




          <div class="p-2">
            <button
              id="toggle-buttons"
              @click="toggleButtons(sIdx)"
              class="inline-flex items-center gap-3 p-0 bg-transparent border-0 cursor-pointer text-blue-600 hover:text-blue-700"
              style="margin: 0; text-align: left;"
            >
              <span
                id="toggle-icon"
                :style="{ backgroundColor: form_primary_color }"
                class="inline-flex h-8 w-8 items-center justify-center rounded-full text-white text-4xl leading-none shadow-sm"
              >
                {{ getToggleIcon(sIdx) }}
              </span>
              <span
                :style="{ WebkitTextFillColor: form_primary_color }"
                class="text-base font-semibold"
              >
                Add new question
              </span>
            </button>
            
            <div
              id="buttons-container"
              v-show="isButtonsVisible(sIdx)"
              class="grid xs:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4"
            >
              <button 
                @click="addField('text', sIdx)"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                :style="{ backgroundColor: form_primary_color }" 
              >
                Short text
              </button>
              <button 
                @click="addField('textarea', sIdx)"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                :style="{ backgroundColor: form_primary_color }" 
              >
                Long text
              </button>
              <button 
                @click="addField('multiplechoice', sIdx)"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                :style="{ backgroundColor: form_primary_color }" 
              >
                Multiple choice
              </button>

              <button 
                @click="addSection(sIdx)"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                :style="{ backgroundColor: form_primary_color }" 
              >
                Add Section
              </button>
            </div>
          </div>

        </div>


      </div>


      <div v-if="showSuccess" class="success-message">
        {{ page.props.flash.success }}
      </div>
    </main>
  </div>
</template>

<script lang=ts setup>
import { ref, watch, computed, onMounted, onBeforeUnmount } from 'vue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import Header from '../../components/FormBuilderHeader.vue';
import ColorPicker from '../../components/FormBuilderColorPicker.vue';
import SelectableContainer from '../../components/FormBuilderSelectableContainer.vue';
import TitleSec from '../../components/editfields/TitleSec.vue';
import Toolbar from '../../components/editfields/Toolbar.vue';
import Optionsbar from '../../components/editfields/Optionsbar.vue';
import FieldRenderer from '../../components/FieldRenderer.vue';
import QuestionRenderer from '@/components/QuestionRenderer.vue';
import TextQuestion from '../../components/questions/TextInput.vue';
import TextareaQuestion from '../../components/questions/TextareaInput.vue';
import MultipleChoiceQuestion from '../../components/editfields/MultipleChoiceQuestion.vue';

const props = defineProps({
  form: Object,
  data: Object,
});

const form = ref({ ...props.form });
const data = ref(props.data);
const page = usePage();
const showSuccess = ref(false);

const errors = computed<Record<string, string>>(() => (page.props.errors as any) ?? {});

// helpers to get an error for a specific field prop
const titleError = (sIdx: number, prop = 'title') =>
  errors.value[`data.${sIdx}.titlesec.${prop}`] ?? null;

const hasTitleError = (sIdx: number, prop = 'title') =>
  !!titleError(sIdx, prop);

const descriptionError = (sIdx: number, prop = 'description') =>
  errors.value[`data.${sIdx}.titlesec.${prop}`] ?? null;

const hasDescriptionError = (sIdx: number, prop = 'description') =>
  !!descriptionError(sIdx, prop);

const fieldError = (sIdx: number, fIdx: number, prop = 'label') =>
  errors.value[`data.${sIdx}.fields.${fIdx}.${prop}`] ?? null;

const hasFieldError = (sIdx: number, fIdx: number, prop = 'label') =>
  !!fieldError(sIdx, fIdx, prop);



//const form_primary_color = form.value.primary_color || 'rgb(158,13,6)'//'rgb(0, 204, 204)'; // default purple-500
//const form_secondary_color = form.value.secondary_color ||   'rgb(69,68,136)'//'rgb(230, 255, 255)'; // default purple-600




// Reactive color fallbacks
const form_primary_color = computed(() => {
  const c = form.value?.primary_color;
  return c && String(c).trim() ? c : '#9e0d06';
});
const form_secondary_color = computed(() => {
  const c = form.value?.secondary_color;
  return c && String(c).trim() ? c : '#454488';
});

// Modal state
const showColorPicker = ref(false);
const tempPrimary = ref<string>(form_primary_color.value);
const tempSecondary = ref<string>(form_secondary_color.value);

function openColorPicker() {
  tempPrimary.value = form_primary_color.value;
  tempSecondary.value = form_secondary_color.value;
  showColorPicker.value = true;
}
function closeColorPicker() {
  showColorPicker.value = false;
}
function saveColors() {
  if (!data.value) data.value = {} as any;
  (data.value as any).primary_color = tempPrimary.value;
  (data.value as any).secondary_color = tempSecondary.value;
  showColorPicker.value = false;
}
















const selectedKey = ref<string | null>(null);
const select = (key: string) => { selectedKey.value = key; };
const isSelected = (key: string) => selectedKey.value === key;
const fieldKey = (field, idx) => `field:${field.id ?? idx}`;
const sectionKey = (section) => `section:${section.id}`;
const clearSelection = () => { selectedKey.value = null; };



watch(() => page.props.flash?.success, (message) => {
  if (message) {
    showSuccess.value = true;
    setTimeout(() => showSuccess.value = false, 4000);
  }
});

const selectedQuestionId = ref(null);

function handleFocus(questionId) {
  selectedQuestionId.value = questionId;
}

function handleClickOutside(event) {
  // Check if the click is outside the currently selected question
  const clickedInside = event.target.closest('.p-4'); // Adjust the selector to match your question container
  if (!clickedInside) {
    selectedQuestionId.value = null; // Clear the focus
  }
}

// Add a global click listener to detect clicks outside the component
onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

// Remove the global click listener when the component is destroyed
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
});

const getFakeSubmissionField = (sIdx: number, fIdx: number) => {
  const section = data.value?.[sIdx];
  const fields = section.fields;
  const field = fields[fIdx];
  return {
    id: null, // No real ID
    form_field_id: field.id,
    submission_id: null,
    answer: '', // Default empty answer
  };
};

const buttonsVisibleBySection = ref<Record<number, boolean>>({});
const toggleIconBySection = ref<Record<number, string>>({});

// default initializer (works for array or object "data")
watch(
  () => data.value,
  (val) => {
    const keys = Array.isArray(val) ? val.map((_, i) => i) : Object.keys(val || {}).map(Number);
    keys.forEach((i) => {
      if (toggleIconBySection.value[i] == null) toggleIconBySection.value[i] = '+';
      if (buttonsVisibleBySection.value[i] == null) buttonsVisibleBySection.value[i] = false;
    });
  },
  { immediate: true, deep: false }
);

function toggleButtons(sIdx: number) {
  buttonsVisibleBySection.value[sIdx] = !buttonsVisibleBySection.value[sIdx];
  toggleIconBySection.value[sIdx] = buttonsVisibleBySection.value[sIdx] ? '×' : '+';
}

function isButtonsVisible(sIdx: number) {
  return !!buttonsVisibleBySection.value[sIdx];
}

function getToggleIcon(sIdx: number) {
  return toggleIconBySection.value[sIdx] ?? '+';
}




function addField(typeIn: string, sIdx: number) {
  const section = data.value?.[sIdx];
  if (!section) return;

  const newField = {
    id: null,
    label: null,
    type: typeIn,
    required: false,
    options: null,
    field_order: Array.isArray(section.fields) ? section.fields.length : 0,
  };
  if (!Array.isArray(section.fields)) section.fields = [];
  section.fields.push(newField);

  const fIdx = section.fields.length - 1;
  select(fieldKey(newField, fIdx));
}

function addSection(sIdx: number) {
  const newSection = {
    id: null,
    titlesec: {
      title: null,
      description: null,
    },
    fields: [],
    section_order: Array.isArray(data.value) ? data.value.length : 0,
  };
  data.value?.splice(sIdx + 1, 0, newSection);
  select(sectionKey(newSection));
}

function copyfield(sIdx: number, fIdx: number) {
  const section = data.value?.[sIdx];
  const fields = section.fields;
  const field = fields[fIdx];
  if (!section) return;

  const copyField = {
    id: null,
    label: field.label,
    type: field.type,
    required: field.required,
    options: field.options,
    field_order: Array.isArray(section.fields) ? section.fields.length : 0,
  };
  if (!Array.isArray(section.fields)) section.fields = [];
  section.fields.push(copyField);

  const clone = section.fields[section.fields.length-1]
  var i = section.fields.length-1
  while (i > fIdx+1) {
    section.fields[i] = section.fields[i-1];
    i-=1
  }
  section.fields[fIdx+1] = clone  
}

function handleDelete(sIdx: number, fIdx: number) {
  const section = data.value?.[sIdx];
  if (fIdx !== -1) {
    section.fields.splice(fIdx, 1);
  }
}

function moveFieldUp(sIdx: number, fIdx: number) {
  const section = data.value?.[sIdx];
  const fields = section.fields;
  if (fIdx > 0) {
    const temp = fields[fIdx - 1];
    fields[fIdx - 1] = fields[fIdx];
    fields[fIdx] = temp;
  }
}

function moveFieldDown(sIdx: number, fIdx: number) {
  const section = data.value?.[sIdx];
  const fields = section.fields;
  if (fIdx < fields.length - 1) {
    const temp = fields[fIdx + 1];
    fields[fIdx + 1] = fields[fIdx];
    fields[fIdx] = temp;
  }
}


// Map field types to components
const componentMap = {
  text: TextQuestion,
  textarea: TextareaQuestion,
  multiplechoice: MultipleChoiceQuestion,
  // Add more mappings for other field types
};

const getComponent = (type: string) => componentMap[type] || null;

function saveForm() {
  //updateFieldOrder()
  try {
    console.log('Save button clicked');
    router.put(`/forms/${form.value.code}/edit`, {
      data: data.value
    }, {
      onSuccess: () => {
        console.log('Form updated!');
        // Show toast here
      },
      onError: (errors) => {
        console.error('Validation failed:', errors);
      }
    });
  }
  catch (error) {
    console.error('An error occurred while saving the form:', error);
  }
}








// temporary functions for devleopment
function tempPrint() {
  console.log("form: ", form.value)
  console.log("data: ", data)
}

function formjson() {
  const json = router.get(`/forms/${form.value.code}/formjson`, {
  });
  console.log("formjson: ", json)
}

</script>



<style scoped>
/* 100% by default, 70% on large screens, centered */
.container-responsive {
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  padding-left: 0;   /* no padding on small screens */
  padding-right: 0;  /* no padding on small screens */
}

@media (min-width: 640px) {
  .container-responsive {
    padding-left: 1rem;   /* add padding from sm and up */
    padding-right: 1rem;
  }
}

@media (min-width: 1024px) {
  .container-responsive {
    width: 70%;
  }
}
</style>