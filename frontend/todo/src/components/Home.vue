<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Todo lists</h1>
        <div v-if="notes.length > 0" v-for="note in notes" :key="note.id" class="mb-4 bordered rounded-md">
            <h2 class="text-xl font-semibold">{{ note.name }}</h2>
            <p class="text-gray-600">Created at: {{ note.created_at }}</p>
            <p class="text-gray-600">Updated at: {{ note.updated_at }}</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    @click="startChecking(note)">Check
            </button>
            <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
                    @click="startEditing(note)">Edit
            </button>
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                    @click="deleteNote(note)">Delete
            </button>
        </div>
        <button @click="startCreating" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Create todolist
        </button>
        <note-form v-if="isCreating || isEditing" :note="editableNote" :noteItems="noteItems" @noteSaved="handleNoteSaved"/>
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
        log(note) {
            console.log(note);
            return true;
        },
        startCreating() {
            this.fetchNotes();
            this.isCreating = true;
            this.isEditing = false;
            this.isChecking = false;

            this.editableNote = {name: ''};
            this.checkingNote = {};
        },
        startEditing(note) {
            console.log("START EDITITNG", note);
            this.fetchItems(note);
            this.isCreating = false;
            this.isEditing = true;
            this.isChecking = false;
            this.editableNote = {...note};
            this.checkingNote = {};
        },
        startChecking(note) {
            console.log("START CHEKING", note);
            this.fetchItems(note);
            this.isCreating = false;
            this.isEditing = false;
            this.isChecking = true;

            this.editableNote = {name: ''};
            this.checkingNote = {...note};

            this.isModalOpen = true;
        },
        handleCloseModal(){
            console.log("HANDLER");
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
        handleClose(savedNote) {
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
                    console.log("FETCH Items");
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
