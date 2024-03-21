<template>
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4" v-if="!note.id">Create todo</h2>
        <h2 class="text-xl font-bold mb-4" v-else>Edit todo</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label for="noteName" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                <input type="text" id="noteName" v-model="note.name"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ note.id ? 'Save' : 'Create' }}
            </button>
        </form>
    </div>
    <div v-if="note.id" class="mt-4">
        <h3 class="text-lg font-semibold mb-2">TODO Items:</h3>
        <div v-if="noteItems.length > 0" class="mb-4 bordered rounded-md">
            <ul>
                <li v-for="(item, index) in noteItems" :key="index" class="mb-2">
                    {{ item.text }}
                    <button @click="deleteItem(item)"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete
                    </button>
                </li>
            </ul>
        </div>
        <div class="mt-4">
            <input type="text" v-model="newItemText" placeholder="New TODO item" class="border rounded py-2 px-3 mr-2">
            <button @click="addItem" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Add
            </button>
        </div>
    </div>
</template>

<script>
import ApiService from '@/services/ApiService';

export default {
    props: {
        note: {
            type: Object,
            required: true
        },
        noteItems: {
            type: Array,
            required: true
        }
    },
    methods: {
        data() {
            return {
                notes: [],
                noteItems: [],
                isCreating: false,
                isEditing: false,
                editableNote: {}
            };
        },
        submitForm() {
            if (this.note.id) {
                this.editNote();
            } else {
                this.createNote();
            }
        },
        async createNote() {
            try {
                const response = await ApiService.createNote({name: this.note.name});
                console.log(response.data);
                this.$emit('noteSaved', response.data.data);
            } catch (error) {
                console.error('Create todo error:', error);
            }
        },
        async editNote() {
            try {
                const response = await ApiService.updateNote(this.note.id, {name: this.note.name});
                console.log(response.data);
                this.$emit('noteSaved', response.data.data);
            } catch (error) {
                console.error('Edit todo error:', error);
            }
        },
        addItem() {
            length = this.noteItems.length ?? 0;
            const newItem = {
                text: this.newItemText,
                order: length + 1
            };
            ApiService.createItem(this.note.id, newItem)
                .then(response => {
                    console.log("sdds", response.data)
                    this.noteItems = response.data.data.items;
                    this.newItemText = '';
                })
                .catch(error => {
                    console.error('Add item:', error);
                });
        },
        deleteItem(item) {
            ApiService.deleteItem(this.note.id, item.id)
                .then(() => {
                    const index = this.noteItems.indexOf(item);
                    if (index !== -1) {
                        this.noteItems.splice(index, 1);
                    }
                })
                .catch(error => {
                    console.error('Error on deleting TODO item:', error);
                });
        },
    }
};
</script>
