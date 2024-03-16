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
        let result = apiClient.get('/notes');
        console.log(result);
        return result;
    },
    getNoteItems(noteId) {
        return apiClient.get(`/notes/${noteId}`);
    },
}
