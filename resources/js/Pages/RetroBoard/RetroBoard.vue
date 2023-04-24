<template>
    <div class="flex flex-col h-screen">
        <div class="flex flex-grow justify-center content-evenly">
            <ul v-for="column in this.localColumns"
                class="flex-grow flex justify-center w-1/3 "
            >
                <RetroColumn
                    :columnOptions="column"
                    :notes="notesForColumn(column.id)"
                    :session="session"
                    @deleteColumn="this.deleteColumn"
                    @addColumn="this.addColumn"
                />
            </ul>
            <div id="modal">
                <label for="newColumnModal" class="btn btn-primary">+</label>
                <input type="checkbox" id="newColumnModal" class="modal-toggle" />
                <label for="newColumnModal" class="modal cursor-pointer">
                    <label class="modal-box relative">
                        <h3 class="text-lg font-bold">Create New Column</h3>
                        <label class="container flex items-center mx-auto justify-between flex-wrap">
                            <input
                                id="titleText"
                                type="text"
                                placeholder="Title"
                                class="input input-bordered w-full max-w-xs"
                            />
                            <div class="modal-action">
                                <label for="newColumnModal" @click="this.addColumn" class="btn">Create</label>
                            </div>
                        </label>
                    </label>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
import RetroColumn from "./RetroColumn.vue";
import {routes} from "../routes";

export default {
    name: "RetroBoard",
    components: {
        RetroColumn,
    },
    props: {
        session: {
            type: Object,
            required: true,
        },
        notes: {
            type: Array,
        },
        user: {
            type: Object,
            required: true,
        },
        columns: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            localColumns: [...this.columns],
        }
    },
    methods: {
        notesForColumn(columnId) {
            return this.notes.filter(n => n.column_id === columnId)
        },
        addColumn(event) {
            const title = document.querySelector('#titleText').value
            document.querySelector('#titleText').value = ''
            const newColumn = {
                session_id: this.session.id,
                title: title,
            }
            axios.post(routes.columns.store, newColumn).catch(() => {
                this.localColumns = this.localColumns.filter((column) => {
                    return column.title !== title // this will remove columns with the same text :/
                })
            })
            this.localColumns.push(newColumn);
        },
        deleteColumn(event) {
            const deletedColumnIndex = this.localColumns.findIndex(column => column.id === event.column_id);
            const deletedColumn = this.localColumns[deletedColumnIndex];
            this.$nextTick(() => this.localColumns = this.localColumns.filter((column) => {
                return column.id !== event.column_id
            }))
            console.log(this.localColumns)
            axios.post(routes.columns.destroy + `/${event.column_id}`, { // todo don't POST with _method
                _method: 'DELETE',
                session_id: event.session_id,
            }).catch(() => {
                this.localColumns.splice(deletedColumnIndex, 0, deletedColumn);
            })
        },
    },
    computed: {},
    watch: {
        columns: function (columns) {
            console.log(columns)
            console.log('RetroBoard.vue:watch:columns')
            this.localColumns = [...columns]
        }
    },
}
</script>

<style scoped>

</style>
