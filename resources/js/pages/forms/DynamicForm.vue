<template>
  <div :style="{ backgroundColor: formColors.background }" class="min-h-screen py-8">

    <main class="mx-auto w-[70%] p-6 ">
      <!-- Title and Description -->
      <div :style="{ backgroundColor: formColors.white }" class="mb-6 rounded-md shadow-sm">
        <div :style="{ backgroundColor: formColors.primary }" class="h-2 w-full rounded-t-md"></div>
        <div class="p-4 space-y-4">
          <div
            placeholder="Form Title"
            class="mt-2 block w-full text-4xl border-b-1 focus:border-b-2 focus:outline-none"
            :style="{
              '--tw-border-opacity': '1',
              borderColor: 'transparent',
            }"
          >
            {{ form.title }}
          </div>

          <div
            id="descriptionTextarea"
            placeholder="Form Description"
            class="mt-1 block w-full border-b-1 focus:border-b-2 focus:outline-none resize-none overflow-hidden"
            :style="{
              '--tw-border-opacity': '1',
              borderColor: 'transparent',
            }"
            @input="adjustTextareaHeight"
          >
            {{ form.description }}
          </div>
        </div>
      </div>

      <!-- Questions Section -->
      <div class="space-y-4">
        <div v-for="(field, index) in fields"
        :key="index"
        >
          <QuestionRenderer
            :field="field"
            :index="index"
            :submissionField="submissionFields[index]"
            :mode="'view'"
            :form-colors="formColors"
          />

        </div>

        <!-- Add field button -->
        <button @click="submitForm" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
          Submit
        </button>

      </div>
      <div v-if="showSuccess" class="success-message">
        {{ page.props.flash.success }}
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, watch, reactive, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import QuestionRenderer from '@/components/QuestionRenderer.vue';

const props = defineProps({
  form: Object,
  fields: Array,
  submission: Object,
  submissionFields: Array
});

const form = ref({ ...props.form });
const fields = ref([...props.fields]);
const submission = ref({ ...props.submission });
const submissionFields = ref([...props.submissionFields]);

fields.value[0].type = 'textarea';

console.log('Fields:', fields.value);
console.log('submissionFields:', submissionFields.value);

const page = usePage();
const showSuccess = ref(false);

const formColors = reactive({
  primary: 'rgb(120, 110, 127)', // purple-500
  secondary: 'rgb(255, 255, 255)', // purple-600
  background: 'rgb(240, 220, 255)', // blue-500
  white: 'rgb(255, 255, 255)', // white
  gray: 'rgb(243, 244, 246)', // gray-100
  success: 'rgb(16, 185, 129)', // green-500
  danger: 'rgb(239, 68, 68)', // red-500
  warning: 'rgb(245, 158, 11)', // yellow-500
  info: 'rgb(96, 165, 250)', // blue-300
});





function submitForm() {
  try {
    console.log('Submit button clicked');
    console.log('Submitting submissionFields:', submissionFields.value);
    
    router.put(`/forms/${form.value.code}/viewform/${submission.value.code}`, {
      submissionFields: submissionFields.value
    }, {
      onSuccess: () => {
        console.log('Form submitted!');
        showSuccess.value = true;
        // Show toast here
      },
      onError: (errors) => {
        console.error('Validation failed:', errors);
      }
    }
    )
  }
  catch (error) {
    console.error('An error occurred while submitting the form:', error);
  }
}





const descriptionTextarea = ref(null);

function adjustTextareaHeight() {
  const textarea = document.getElementById('descriptionTextarea'); // Access the textarea using its id
  if (textarea) {
    textarea.style.height = 'auto'; // Reset height to auto to calculate the new height
    textarea.offsetHeight; // This line forces the browser to recalculate layout
    textarea.style.height = `${textarea.scrollHeight}px`; // Set the height to match the content
    console.log('Adjusted height:', textarea.style.height); // Debugging log
  }
}

// Adjust height on mount
onMounted(() => {
  adjustTextareaHeight();
});

</script>
