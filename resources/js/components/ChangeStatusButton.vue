<template>

    <button @click="modifyStatus(todo_id)"><i :class="status"></i></button>

</template>

<script>
export default {
    name: "ChangeStatusButton",
    props: ['todo_id', 'todo_status'],
    data() {
        return {
            my_status: String,
        }
    },
    computed: {
        status() {
            return this.myStatus(this.my_status);
        },
    },
    methods: {
        myStatus(status) {
            switch (status) {
                default:
                    return null;
                case "unsolved":
                    return "fa-solid fa-circle-xmark text-danger";
                case "in_progress":
                    return "fa-solid fa-circle-minus text-warning";
                case "solved":
                    return "fa-solid fa-circle-check text-success";
            }
        },
        modifyStatus(status_id) {
            this.axios
                .post('/api/status', {
                    status_id: status_id,
            })
                .then((response) => {
                    this.my_status = response.data;
                })
                .catch((error) => {
                    console.error(error);
                })
        },
    },
    mounted() {
        this.my_status = this.todo_status;
    },
}
</script>

<style scoped>

</style>
