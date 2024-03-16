import { createStore } from 'vuex'

export default createStore({
    state: {
        notes: []
    },
    mutations: {
        setNotes(state, notes) {
            state.notes = notes
        }
// Добавьте другие мутации для обновления состояния
    },
    actions: {
        fetchNotes({ commit }) {
// Запрос к API для получения заметок
// commit('setNotes', response.data)
        }
// Добавьте другие действия для взаимодействия с API
    }
})
