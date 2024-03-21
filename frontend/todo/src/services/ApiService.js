import axios from 'axios'

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api',
    withCredentials: false,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
})

export default {
    getNotes() {
        return  apiClient.get('/notes');
    },
    getNote(noteId) {
        return apiClient.get(`/notes/${noteId}`);
    },
    createNote(noteData) {
        return apiClient.post('/notes', noteData);
    },
    updateNote(noteId, noteData) {
        return apiClient.put(`/notes/${noteId}`, noteData);
    },
    deleteNote(noteId) {
        return apiClient.delete(`/notes/${noteId}`);
    },
    createItem(noteId, itemData) {
        return apiClient.post(`/notes/${noteId}/items`, itemData);
    },
    deleteItem(noteId, itemId) {
        return apiClient.delete(`/notes/${noteId}/items/${itemId}`);
    },
    checkItem(noteId, itemId) {
        return apiClient.post(`/notes/${noteId}/items/${itemId}/toggle`);
    },
}
