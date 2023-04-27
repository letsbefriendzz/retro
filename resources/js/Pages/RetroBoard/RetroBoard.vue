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
                    @deleteModalButtonClicked="this.updateDeleteColumnFocus"
                />
            </ul>
            <div id="newColumnModalContainer">
                <TextInputModalButton label="newColumn"/>
                <TextInputModal
                    label="newColumn"
                    header="Create New Column"
                    button-label="Create"
                    placeholder="Column Title"
                    @textSubmitted="this.addColumn"
                />
            </div>
            <div id="binaryModalContainer">
                <BinaryModal
                    no-label="Keep"
                    yes-label="Delete"
                    description="Any notes associated with this column will be deleted. Are you sure you'd like to proceed?"
                    header="Delete Column"
                    label="X"
                    @yes="this.deleteColumn"
                />
            </div>
        </div>
    </div>
</template>

<script>
import TextInputModal from "../Input/TextInputModal.vue";
import TextInputModalButton from "../Input/TextInputModalButton.vue";
import BinaryModal from "../Input/BinaryModal.vue";
import RetroColumn from "./RetroColumn.vue";
import {routes} from "../routes";
import axios from 'axios';

export default {
    name: "RetroBoard",
    components: {
        RetroColumn,
        BinaryModal,
        TextInputModal,
        TextInputModalButton,
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
            deleteColumnFocus: null,
        }
    },
    methods: {
        notesForColumn(columnId) {
            return this.notes.filter(n => n.column_id === columnId)
        },
        addColumn(event) {
            const newColumn = {
                session_id: this.session.id,
                title: event.text,
            }
            axios.post(routes.columns.store, newColumn).catch(() => {
                this.localColumns = this.localColumns.filter((column) => {
                    return column.title !== event.text // this will remove columns with the same text :/
                })
            })
            this.localColumns.push(newColumn);
        },
        deleteColumn() {
            const deletedColumnIndex = this.localColumns.findIndex(column => column.id === this.deleteColumnFocus);
            const deletedColumn = this.localColumns[deletedColumnIndex];
            this.$nextTick(() => this.localColumns = this.localColumns.filter((column) => {
                return column.id !== this.deleteColumnFocus
            }))
            axios.post(routes.columns.destroy + `/${this.deleteColumnFocus}`, { // todo don't POST with _method
                _method: 'DELETE',
                session_id: this.session.id,
            }).catch(() => {
                this.localColumns.splice(deletedColumnIndex, 0, deletedColumn);
            })
        },
        updateDeleteColumnFocus(event) {
            this.deleteColumnFocus = event.column_id
        }
    },
    computed: {},
    watch: {
        columns: function (columns) {
            this.localColumns = [...columns]
        }
    },
}
</script>

<style scoped>

</style>
