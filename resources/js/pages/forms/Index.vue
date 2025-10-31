<template>
    <div class="max-w-4xl mx-auto py-10">
      <h1 class="text-3xl font-bold mb-6">📋 My Forms</h1>
  
      <div class="mb-4 text-right">
        <Link href="/forms/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Create Form
        </Link>
      </div>
  
      <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="border px-4 py-2 text-left">Title</th>
            <th class="border px-4 py-2 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="form in forms" :key="form.id">
            <td class="border px-4 py-2">{{ form.title }}</td>
            <td class="border px-4 py-2">{{ form.status }}</td>
            <td class="border px-4 py-2">
              <a :href="`/forms/${form.code}/edit`" class="text-blue-600 hover:underline">
                Edit
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  defineProps({ forms: Array });
  </script>
  