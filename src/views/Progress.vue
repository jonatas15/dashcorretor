<template>
    <radial-progress-bar 
     :diameter="90"
     :completed-steps="100"
     :total-steps="75"
     :startColor="'#2d460b'"
     :stopColor="'#2d460b'"
     :innerStrokeColor="'#e3e3e3'"
     :strokeWidth="5"
     :innerStrokeWidth="5"
    >
        <h5>78%</h5>
    </radial-progress-bar>
    <br>
    <label style="text-align: center">Leads Recebidos</label>
</template>
  
<script lang="ts">
    import { ref, defineComponent } from "vue";
    import RadialProgressBar from "vue3-radial-progress";

    export default {
        components: {
            RadialProgressBar
        },
    };
  
    //   export default defineComponent({
    //       setup(){
    //         const completedSteps = ref(0);
    //         const totalSteps = ref(10);
    
    //         return {
    //               completedSteps,
    //               totalSteps
    //           }
    //       }
    //   })
</script>
<style scoped>
    .vrp__wrapper {
        width: 100% !important;
    }
</style>