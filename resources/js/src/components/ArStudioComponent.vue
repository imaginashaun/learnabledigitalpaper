<template>
    <div class="vx-col w-full sm:w-1/2 lg:w-1/3 mb-base">
        <div class="row">
        <vs-button :color="theme_color" size="large" class="vx-col w-full lg:w-1/1" to="lessons/edit">
            <vs-avatar class="mx-auto mb-6 block bg-transparent" size="80px" :src="theme_illustration" />

            <h5 class="mb-2 text-white text-center">{{subject_title}}</h5>

        </vs-button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ArStudioComponent",
        props: ['id', 'material_item_title', 'material_item_object'],
    }
</script>

<style scoped>

</style>
