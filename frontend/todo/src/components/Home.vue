<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Todo lists</h1>
        <div v-if="notes.length > 0" v-for="note in notes" :key="note.id" class="mb-4 bordered rounded-md">
            <h2 class="text-xl font-semibold">{{ note.name }}</h2>
            <div v-if="log(note)"></div>
            <p class="text-gray-600">Created at: {{ note.created_at }}</p>
            <p class="text-gray-600">Updated at: {{ note.updated_at }}</p>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="fetchItems(note)">Show</button>
            <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded" @click="editNote(note)">Edit</button>
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" @click="deleteNote(note)">Delete</button>
        </div>
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" @click="createNote">Create todolist</button>
    </div>
</template>

<script>
import ApiService from '@/services/ApiService'

export default {
    data() {
        return {
            notes: []
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
                    console.log("received");
                    console.log(response.data.data);
                })
                .catch(error => {
                    console.error('Ошибка при получении заметок:', error);
                });
        },
        log(note) {
            console.log("StaRT");
            console.log(note);
            return true; // Возвращаем true, чтобы v-if не скрывал элемент
        },
        fetchItems(note) {
            ApiService.getNoteItems(note.id)
                .then(response => {
                    this.$set(note, 'items', response.data);
                })
                .catch(error => {
                    console.error('Ошибка при получении элементов списка:', error);
                });
        },
        createNote() {
        },
        editNote(note) {
            this.$router.push({ name: 'EditNote', params: { id: note.id } });
        },
        deleteNote(note) {
            if (confirm('Вы уверены, что хотите удалить эту заметку?')) {
            }
        }
    }
};
</script>
