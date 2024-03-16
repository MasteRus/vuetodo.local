<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Редактирование заметки</h1>
        <input v-model="note.title" placeholder="Title" class="mb-4">
        <ul>
            <li v-for="(todo, index) in note.todos" :key="index">
                <input type="checkbox" v-model="todo.done">
                <input v-model="todo.text" placeholder="Text">
                <button @click="deleteTodo(index)">Delete</button>
            </li>
        </ul>
        <button @click="addTodo">Add</button>
        <button @click="saveNote">Save</button>
        <button @click="undoChanges">Undo</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            note: {
            }
        };
    },
    methods: {
        addTodo() {
        },
        deleteTodo(index) {
        },
        saveNote() {
        },
        undoChanges() {
            if (confirm('Вы уверены, что хотите отменить изменения?')) {
            }
        }
    }
};
</script>
