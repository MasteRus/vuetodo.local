<template>
    <div v-if="isVisible" class="modal">
        <div class="modal-background" @click="cancel"></div>
        <div class="modal-content">
            <h2>Confirm delete</h2>
            <p>Are you sure want to delete?</p>
            <button @click="confirm">Delete</button>
            <button @click="cancel">Cancel</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isVisible: Boolean
    },
    methods: {
        confirm() {
            this.$emit('confirmed');
        },
        cancel() {
            this.$emit('cancelled');
        }
    }
};
</script>
<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-background {
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    cursor: pointer;
}

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    text-align: center;
    z-index: 1001;
}

.modal h2 {
    margin-bottom: 15px;
}

.modal p {
    margin-bottom: 20px;
}

.modal button {
    margin-right: 10px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.modal button:hover {
    opacity: 0.8;
}

.modal .modal-close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.5rem;
    background: none;
    border: none;
    cursor: pointer;
}
</style>
