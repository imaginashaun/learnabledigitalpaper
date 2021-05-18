<template>
    <div class="vx-col w-full sm:w-1/2 lg:w-1/3 mb-base">
        <div class="row">
        <vs-button :color="theme_color" size="large" class="vx-col w-full lg:w-1/1" @click="[createLesson(id, ), popupActive()]">
            <vs-avatar class="mx-auto mb-6 block bg-transparent" size="80px" :src="theme_illustration" />

            <h5 class="mb-2 text-white text-center">{{subject_title}}</h5>

        </vs-button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SubjectComponent",
        props: ['id', 'subject_color', 'subject_title', 'theme_color','theme_illustration','popupActive'],
        methods: {
            createLesson(subject_id){

                this.$http.get('/api/lessons/create/'+this.$route.params.class_id+'/'+subject_id)
                    .then((response) => { this.learning_path = response.data
                        this.$router.push('/lesson/edit/'+this.learning_path.id).catch(() => {})
//lesson/edit/this.learning_path.id

                    })
                    .catch((error) => { console.log(error) })
            }
        }
    }
</script>

<style scoped>

</style>
