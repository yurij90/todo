<template>

    <h2>Feladataid</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Létrehozta</th>
            <th>Csoport</th>
            <th>Prioritás</th>
            <th>Leírás</th>
            <th>Hozzáadva</th>
            <th></th>
            <th></th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="todo in todos">
            <td>{{ username(todo.user_id) }}</td>
            <td>{{ groupname(todo.group_id) }}</td>
            <td>{{ todo.priority }}</td>
            <td>{{ todo.description }}</td>
            <td>{{ datetime(todo.created_at) }}</td>
            <td><change-status-button :todo_id="todo.id" :todo_status="todo.status"></change-status-button></td>
            <td>
                <delete-todo-button :user_id="user_id" :todo_user_id="todo.user_id" :todo_id="todo.id">
                </delete-todo-button>
            </td>
        </tr>
        <tr v-show="show">
            <td colspan="7">
                Nincsenek feladataid!
            </td>
        </tr>
        </tbody>
    </table>

</template>

<script>
import ChangeStatusButton from "./ChangeStatusButton";
import DeleteTodoButton from "./DeleteTodoButton";

export default {
    name: "TodoTable",
    components: {DeleteTodoButton, ChangeStatusButton},
    props: ['todos', 'user_id'],
    data() {
        return {
            show: false,
            groupnames: {},
            usernames: {},
        }
    },
    methods: {
        groupname(id) {
            let gname = "Egyéni";
            for (let i = 0; i < this.groupnames.length; i++) {
                if (id === this.groupnames[i].id) {
                    gname = this.groupnames[i].group_name;
                }
            }
            return gname;
        },
        username(id) {
            let uname = null;
            for (let i = 0; i < this.usernames.length; i++) {
                if (id === this.usernames[i].id) {
                    uname = this.usernames[i].name;
                }
            }
            return uname;
        },
        datetime: function (string) {
            return string.substring(0, 10) + ' ' + string.substring(11, 19)
        },
        getGroupname() {
            this.axios
                .get('/api/groups')
                .then((response) => {
                    this.groupnames = response.data;
                })
                .catch((error) => {
                    console.error(error);
                })
        },
        getUsername() {
            this.axios
                .get('/api/users')
                .then((response) => {
                    this.usernames = response.data;
                })
                .catch((error) => {
                    console.error(error);
                })
        },
        ifTableEmpty() {
            if (!this.todos.length) {
                this.show = true;
            }
        }
    },
    beforeMount() {
        this.getGroupname();
        this.getUsername();
    },
    mounted() {
        this.ifTableEmpty();
    },
}
</script>

<style scoped>

</style>
