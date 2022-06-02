<template>
    <form :action="'/todo/delete/'+todo_id" method="POST">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="id" :value="todo_id">
        <button v-show="show" type="submit"><i class='fa-solid fa-trash-can link-danger'></i></button>
    </form>
</template>

<script>
export default {
    name: "DeleteTodoButton",
    props: ['todo_id', 'todo_user_id', 'user_id'],
    data() {
        return {
            csrf: document.head.querySelector('meta[name="csrf-token"]') ? document.head.querySelector('meta[name="csrf-token"]').content : '',
            show: false,
        }
    },
    methods: {
        showDelete() {
            if (this.todo_user_id === this.user_id) {
                this.show = true;
            }
        }
    },
    beforeMount() {
        this.showDelete();
    }
}
</script>

<style scoped>

</style>
