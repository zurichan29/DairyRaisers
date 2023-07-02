<template>
  <div>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-show="isOpen"
      @keydown.escape.window="closeModal">
      <div class="bg-white rounded-lg w-1/2 px-6 py-4">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-bold">Edit Address</h2>
          <button @click="closeModal">
            <svg class="w-5 h-5 text-gray-500 hover:text-gray-700" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M14.35 4.35a1 1 0 0 1 1.41 0l.79.8a1 1 0 0 1 0 1.41l-9 9a1 1 0 0 1-1.41 0l-9-9a1 1 0 0 1 0-1.41l.8-.79a1 1 0 0 1 1.41 0L10 13.17l3.18-3.18a1 1 0 0 1 1.41 0z"
                clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>

        <form @submit.prevent="updateAddress">
          <!-- Add your address form fields here -->
          <div class="mb-4">
            <label for="address_line_1" class="block text-sm font-medium text-gray-700">Address Line 1</label>
            <input type="text" id="address_line_1" name="address_line_1" v-model="addressLine1"
              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
          </div>

          <!-- Add other address form fields as needed -->

          <div class="mt-4">
            <button type="submit" class="py-2 px-4 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">Update
              Address</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
  
<script>
export default {
  data() {
    return {
      isOpen: false,
      addressLine1: '', // Initialize with the existing address value
      // Add other address form fields here
    };
  },
  methods: {
    openModal() {
      this.isOpen = true;
    },
    closeModal() {
      this.isOpen = false;
    },
    updateAddress() {
      // Handle the address update logic here
      // You can use Axios or fetch API to send an asynchronous request to your Laravel API endpoint
      // Remember to close the modal after successful update
      this.closeModal();
    },
  },
};
</script>
  