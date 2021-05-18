<template>
<div>

    <h2>Processing...</h2>

</div>
</template>

<script>
    export default {
        name: "ShowResults",
        data(){


            return {

                learning_path_results:null
            }
        },
        created() {


            this.$http.get('/api/results/'+this.$route.params.learning_path_id)
                .then((response) => { this.learning_path_results = response.data
                })
                .catch((error) => { console.log(error) })

        }
    }
</script>

<style scoped>

</style>
