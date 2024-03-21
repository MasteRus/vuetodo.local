<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Todo lists</h1>
        <div v-if="notes.length > 0">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Created At</th>
                    <th class="px-4 py-2">Updated At</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="note in notes" :key="note.id" class="bordered">
                    <td class="border px-4 py-2">{{ note.name }}</td>
                    <td class="border px-4 py-2">{{ note.created_at }}</td>
                    <td class="border px-4 py-2">{{ note.updated_at }}</td>
                    <td class="border px-4 py-2">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded"
                                @click="startChecking(note)">Check
                        </button>
                        <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded"
                                @click="startEditing(note)">Edit
                        </button>
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                                @click="deleteNote(note)">Delete
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <button @click="startCreating" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Create todolist
        </button>
        <note-form
            v-if="(isCreating || isEditing) && isModalOpen"
            :note="editableNote"
            :noteItems="noteItems"
            @noteSaved="handleNoteSaved"
            @closeModal="handleCloseModal"
            @close="isModalOpen = false"
        />
        <check-form
            v-if="isChecking && isModalOpen"
            :note="checkingNote" :noteItems="noteItems"
            @closeModal="handleCloseModal"
            @close="isModalOpen = false"
        />
    </div>
</template>

<script>
import NoteForm from './NoteForm.vue';
import CheckForm from './CheckForm.vue';
import ApiService from '@/services/ApiService'

export default {
    components: {
        NoteForm,
        CheckForm
    },
    data() {
        return {
            notes: [],
            noteItems: [],
            isCreating: false,
            isEditing: false,
            isChecking: false,
            editableNote: {},
            checkingNote: {},
            isModalOpen: false
        };
    },
    mounted() {
        this.fetchNotes();
    },
    methods: {
        fetchNotes() {
            ApiService.getNotes()
                .then(response => {
                    this.notes = response.data.data;
                })
                .catch(error => {
                    console.error('Error by getting todos list', error);
                });
        },
        startCreating() {
            this.fetchNotes();
            this.isCreating = true;
            this.isEditing = false;
            this.isChecking = false;

            this.editableNote = {name: ''};
            this.checkingNote = {};

            this.isModalOpen = true;
        },
        startEditing(note) {
            this.fetchItems(note);
            this.isCreating = false;
            this.isEditing = true;
            this.isChecking = false;
            this.editableNote = {...note};
            this.checkingNote = {};

            this.isModalOpen = true;
        },
        startChecking(note) {
            this.fetchItems(note);
            this.isCreating = false;
            this.isEditing = false;
            this.isChecking = true;

            this.editableNote = {name: ''};
            this.checkingNote = {...note};

            this.isModalOpen = true;
        },
        handleCloseModal() {
            this.isModalOpen = false;
        },
        handleNoteSaved(savedNote) {
            if (this.isCreating) {
                this.notes.push(savedNote);
            } else if (this.isEditing) {
                const index = this.notes.findIndex(note => note.id === savedNote.id);
                if (index !== -1) {
                    this.notes.splice(index, 1, savedNote);
                } else {
                    this.notes.push(savedNote);
                }
            }
            this.isCreating = false;
            this.isEditing = false;
        },
        fetchItems(note) {
            ApiService.getNote(note.id)
                .then(response => {
                    this.noteItems = response.data.data.items;
                })
                .catch(error => {
                    console.error('Ошибка при получении элементов списка:', error);
                });
        },
        deleteNote(note) {
            if (confirm('Do you want to delete this list?')) {
                let noteId = note.id;
                ApiService.deleteNote(noteId)
                    .then(() => {
                        this.notes = this.notes.filter(note => note.id !== noteId);
                    })
                    .catch(error => {
                        console.error('Error on delete:', error);
                    });
            }
        }
    }
};
</script>
