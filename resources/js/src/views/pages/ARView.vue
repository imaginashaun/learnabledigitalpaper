<template>

    <model-viewer class="h-screen flex w-full bg-img" camera-controls autoplay ar ar-modes="webxr scene-viewer quick-look fallback" shadow-intensity="1" src="/3d/Astronaut.glb">


        <button slot="ar-button" style="background-color: white; border-radius: 4px; border: none; position: absolute; top: 16px; right: 16px; ">
            n👋 Activate ARz
        </button>
    </model-viewer>
</template>

<script>
    import '@google/model-viewer'

    export default {
        name: "ARView",
        components: {
        },
    }
    </script>
