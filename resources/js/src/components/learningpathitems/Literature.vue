<template>
<div>

    <h2>{{learning_path_item_title}}</h2>
    <vs-divider/>

    <p v-html="JSON.parse(learning_path_item_object).body">

    </p>

</div>

</template>

<script>


    export default {
        name: "Literature",
        props:['learning_path_item_title', 'learning_path_item', 'id', 'learning_path_item_object', 'learning_path_id'],
        data(){


            return {

            }


    },
        components: {

        },
        created() {



        }
    }
    </script>
