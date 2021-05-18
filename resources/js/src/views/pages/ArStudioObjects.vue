<template>
<div>
    <ar-studio-component
        v-for="arStudioObject in arStudioObjects"
        v-bind="arStudioObject"
        :key="arStudioObject.id"
    ></ar-studio-component>
</div>
</template>
<script>
    import ArStudioComponent from "../../components/ArStudioComponent";
    function ArStudioObject({ id}) {
        this.id = id;
    }


    export default {
        data() {
            return {
                arStudioObjects: []
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
                const { data } = window.axios.get('/api/arstudio/objects');
                data.forEach(arStudioObject => this.arStudioObjects.push(new ArStudioObject(arStudioObject)));

                console.log(data)
            },
        },
        components: {
            ArStudioComponent,
        }
    }
</script>
