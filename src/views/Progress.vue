<template>
    <radial-progress-bar 
     :diameter="100"
     :completed-steps="prefixo == 'R$' ? 100 : valor"
     :total-steps="100"
     :startColor="'#2d460b'"
     :stopColor="'#2d460b'"
     :innerStrokeColor="'#e3e3e3'"
     :strokeWidth="5"
     :innerStrokeWidth="5"
    >
        <h5 class="valor-monetario" v-if="prefixo == 'R$'">{{ prefixo }}<br> {{ valor }}</h5>
        <h5 class="valor" v-else>{{ valor }} {{ param }}</h5>
    </radial-progress-bar>
    <br>
    <label class="legenda" style="text-align: center">{{ legenda }}</label>
</template>
  
<script lang="ts">
    import { ref, defineComponent } from "vue";
    import RadialProgressBar from "vue3-radial-progress";

    export default {
        data() {
            return {
                valor_formatado: 0
            }
        },
        components: {
            RadialProgressBar
        },
        props: {
            legenda: String,
            param: String,
            prefixo: String,
            valor: Number
        }
        // created() {
        //     switch (this.legenda) {
        //         case "Percentual de Conversão":
        //         this.valor_formatado = this.valor
        //             break;
            
        //         default:
        //             this.valor_formatado = this.valor
        //             break;
        //     }
        // },
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
    .legenda {
        font-size: 12px;
        line-height: 18px;
        color: #053a35;
        font-weight: 700;
    }
    .valor {
        font-size: 22px;
        line-height: 30px;
        color: #053a35;
        font-weight: 400;
        font-family: "Open Sans";
        text-align: center;
        font-weight: 100;
        text-align: center !important;
        /* margin-left: 10%; */
        margin-top: 4%;
    }
    .valor-monetario {
        font-size: 15px;
        line-height: 30px;
        color: #053a35;
        font-weight: 400;
        font-family: "Open Sans";
        text-align: center;
        font-weight: 100;
        text-align: center !important;
        /* margin-left: 10%; */
        margin-top: 4%;
    }
</style>