<template>
    <div>
        <vs-textarea height="140px" counter="300" :counter-danger.sync="counterDanger" v-model="textarea" />
    </div>
</template>

<script>
    export default {
        name: "TextAreaCounter",
        props: ['textarea'],
        data:()=>({
           // textarea: '',
            counterDanger: false
        })
    }
</script>
