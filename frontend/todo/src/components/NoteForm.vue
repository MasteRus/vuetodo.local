<template>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4" v-if="!note.id">Create todo</h2>
        <h2 class="text-xl font-bold mb-4" v-else>Edit todo</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="noteName" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                <input type="text" id="noteName" v-model="note.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ note.id ? 'Save' : 'Create' }}
            </button>
        </form>
    </div>
</template>

<script>
import ApiService from '@/services/ApiService';

export default {
    props: {
        note: {
            type: Object,
            required: true
        }
    },
    methods: {
        submitForm() {
            if (this.note.id) {
                this.editNote();
            } else {
                this.createNote();
            }
        },
        async createNote() {
            try {
                const response = await ApiService.createNote({ name: this.note.name });console.log(response.data);
                this.$emit('noteSaved', response.data.data);
            } catch (error) {
                console.error('Create todo error:', error);
            }
        },
        async editNote() {
            try {
                const response = await ApiService.updateNote(this.note.id, { name: this.note.name });

                console.log(response.data);


                this.$emit('noteSaved', response.data.data);
            } catch (error) {
                console.error('Edit todo error:', error);
            }
        }
    }
};
</script>
