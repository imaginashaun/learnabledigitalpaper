<template>
<div>
    <subject-component
        v-for="subject in subjects"
        v-bind="subject"
        :key="subject.id"
    ></subject-component>
</div>
</template>
<script>
    import SubjectComponent from "../../components/SubjectComponent";
    function Subject({ id}) {
        this.id = id;
    }


    export default {
        data() {
            return {
                subjects: []
            }
        },
        methods: {
            async create() {
                // To do
            },

            async update(id, color) {
                // To do
            },
            async del(id) {
                // To do
            },
            async read() {
                const { data } = window.axios.get('/api/subjects');
                data.forEach(subject => this.subjects.push(new Subject(subject)));

                console.log(data)
            },
        },
        components: {
            SubjectComponent,
        }
    }
</script>
