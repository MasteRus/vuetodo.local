<style scoped>
.container {
    max-width: 600px;
    margin: auto;
    padding: 2rem;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
    margin-bottom: 1rem;
}

ul {
    list-style-type: none;
    padding: 0;
}

li {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

input[type="checkbox"] {
    margin-right: 0.5rem;
    cursor: pointer;
}

label {
    cursor: pointer;
    transition: color 0.3s;
}

label:hover {
    color: #42b983;
}

/* Стилизация чекбоксов */
input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #d1d1d1;
    border-radius: 4px;
    position: relative;
}

input[type="checkbox"]:checked {
    border-color: #42b983;
}

input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    left: 5px;
    width: 6px;
    height: 11px;
    border: solid #42b983;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
</style>

<template>
    <div class="modal">
        <div class="modal-background" @click="closeModal"></div>
        <div class="modal-container">
            <div class="modal-content">
                <div class="container mx-auto p-4" v-if="noteItems.length > 0">
                    <h2 class="text-xl font-bold mb-4">{{ note.name }}</h2>
                    <ul>
                        <li v-for="item in noteItems" :key="item.id" class="todo-item">
                            <input @change="checkItem(item)" type="checkbox" :id="'checkbox-' + item.id"
                                   v-model="item.checked">
                            <label :for="'checkbox-' + item.id">{{ item.text }}</label>
                        </li>
                    </ul>
                </div>
            </div>
            <button class="modal-close" @click="closeModal">Close</button>
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
        closeModal() {
            console.log("");
            this.$emit('closeModal'); // Событие для родительского компонента
        },
        checkItem(item) {
            ApiService.checkItem(this.note.id, item.id)
                .then(() => {

                })
                .catch(error => {
                    console.error('Error on deleting TODO item:', error);
                });
        },
        mounted() {

            console.log("____________________________")
            console.log(this.note)
            console.log(this.noteItems);
            console.log("____________________________")
        },

    },
};
</script>
