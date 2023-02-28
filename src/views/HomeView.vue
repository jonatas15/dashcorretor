<template>
  <div class="container text-left">
    <div class="row align-items-start">
      <div class="col-md-12 banner" style="position: relative;">
        <!-- <img src="src/assets/banner/banner-1.png" /> -->
        <div class="vertical-center" style="width: 325px !important;">
          <h5 style="text-align: left; padding-left: 10%;">
            Veja como estipular suas<br>
            metas de maneiras alcançáveis.
          </h5>
          <a class="btn btn-transparente float-right" href="#">ver mais</a>
        </div>
      </div>
      <div class="col-md-12 dash-corretor">
        <h4>Seu <br>Dashboard</h4>
        <div class="row align-items-start">
          <div class="col-12 col-md-4 item-progresso" style="">
            <div class="row align-items-start subcard-corretor" style="height: 140px; padding: 5px;margin: 0 15px; position: relative;">
              <div class="col-5 col-md-5" style="border-right: 1px solid #e3e3e3; height: 130px; position: relative;">
                <h3 class="center-center">03</h3>
              </div>
              <div class="col-6 col-md-7" style="height: 130px !important; position: relative;">
                <label class="vertical-center"><font-awesome-icon icon="bell" class="" /><br>Ranking Geral de vendas</label>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-2 item-progresso">
            <Progress></Progress>
          </div>
          <div class="col-6 col-md-2 item-progresso">
            <Progress></Progress>
          </div>
          <div class="col-6 col-md-2 item-progresso">
            <Progress></Progress>
          </div>
          <div class="col-6 col-md-2 item-progresso">
            <Progress></Progress>
          </div>
          <div class="col-6 col-md-2 item-progresso">
            <Progress></Progress>
          </div>
          <div class="col-6 col-md-2 item-progresso">
            <Progress></Progress>
          </div>
          <div class="col-6 col-md-2 item-progresso">
            <Progress></Progress>
          </div>
          <div class="col-6 col-md-2 item-progresso">
            <Progress></Progress>
          </div>
        </div>
      </div>
      <div class="col-md-12 elimina-margens-internas">
        <div class="row">
          <!-- <div class="col-md-2"></div> -->
          <div class="col-md-6">
            <div class="dash-corretor-topico">
              <img src="src/assets/banner/Tii.png" />
              <!-- Bora, hora do show porra -->
              <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-7">
                  <br>
                  <strong style="float: left">Incentivo Semanal</strong>
                  <br>
                  <br>
                  <p align="left">
                    Ganhe<br>
                    R$ <strong>150,00</strong> ao cadastrar<br><strong>5 imóveis</strong> acima de R$ 500 mil
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="dash-corretor-topico">
              <div class="row">
                <div class="col-md-6">
                  <h4>Metas<br>Semanais</h4>
                  <br>
                  <p>Meta Vendas: <strong>R$ 20.000 VGC</strong></p>
                  <p>Super Meta: <strong>R$ 29.000 VGC</strong></p>
                </div>
                <div class="col-md-5">
                  <ul class="lista-metas" style="text-align: left; font-size: 12px;line-height: 30px;">
                    <li><br></li>
                    <li>Agenciamentos: <strong>6 (2 vídeos)</strong></li>
                    <li>Placas: <strong>6</strong></li>
                    <li>Gestão de Imóveis: <strong>20</strong></li>
                    <li>Recuperação de Leads: <strong>5/dia</strong></li>
                    <li>Prospecções: <strong>5/semana</strong></li>
                  </ul>
                </div>
                <div class="col-12 col-md-1 vertical-center-right" style="height: 180px;">
                  <div class="line-progress-div">
                    <span class="dot"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <Bar :data="data" :options="options" /> -->
</template>

<script lang="ts">
  import Progress from './Progress.vue';
  export default {
    name: 'Home',
    components: {
        Progress
    }
  }
</script>
<style>
  .banner {
    width: 100%;
    padding: 0 !important;
    margin: 0 !important;
  }
  /* .banner img {
    width: 100%;
    -webkit-filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.2));
    filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.2));
    /* box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
  } */
  .dash-corretor {
    background-color: white;
    border-radius: 20px;
    margin-top: 5%;
    box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
    padding: 2%;
  }
  .dash-corretor h4 {
    text-align: left;
    
  }
  .subcard-corretor {
    border-radius: 20px;
    box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
  }
  .vertical-center {
    margin: 0 !important;
    position: absolute !important;
    top: 50% !important;
    left: 0% !important;
    -ms-transform: translateY(-50%) !important;
    transform: translateY(-50%) !important;
  }
  .vertical-center-right {
    margin: 0 !important;
    position: absolute !important;
    top: 50% !important;
    right: 0% !important;
    -ms-transform: translateY(-50%) !important;
    transform: translateY(-50%) !important;
  }
  .center-center {
    margin: 0 !important;
    position: absolute !important;
    top: 50% !important;
    left: 0 !important;
    right: 0 !important;
    -ms-transform: translateY(-50%) !important;
    transform: translateY(-50%) !important;
  }
  .dash-corretor-topico {
    background-color: white;
    border-radius: 20px;
    margin-top: 10%;
    box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
    padding: 2%;
    height: 220px;
    position: relative;
    /* float: right; */
  }
  .dash-corretor-topico img {
    position: absolute;
    left: -50px;
    top: -30px;
    height: 300px;
    -webkit-filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.2));
    filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.2));
  }
  .align-div-right {
    /* outline: auto; */
    float: right !important;
    padding-right: 0 !important;
  }
  .item-progresso {
    padding-left: 5%;
    padding-bottom: 5%;
  }
  .banner {
    height: 240px;border-radius: 30px;
    background-image: url('/src/assets/banner/banner-1.png');
    background-repeat: no-repeat;
    background-size: 100% 240px;
    box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
    width: 100% !important;
    background-color: gray;
  }
  .line-progress-div {
    height: 180px; border-left: 3px solid lightgray;float: right;margin-right: 15px;
  }
  .dot {
    height: 12px;
    width: 12px;
    background-color: gray;
    border-radius: 50%;
    display: inline-block;
    margin-left: -8px;
    margin-top: 20px;
    position: absolute;
  }
  .lista-metas {
    list-style-type: none;
    margin: 0;
    padding: 0;
  }
  .float-right {
    float: right;
  }
  .btn-transparente {
    padding: 1% 3%;
    border: 1px solid #2d460b;
    border-radius: 20px;
  }
  .elimina-margens-externas {
    margin: 0 !important;
  }
  .elimina-margens-internas {
    padding: 0 !important;
  }
  @media only screen and (max-width: 600px) {
    .banner {
      height: 240px;border-radius: 30px;
      background-image: url('/src/assets/banner/banner-1.png');
      background-repeat: no-repeat;
      background-size: auto 240px;
      box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
      width: 100% !important;
      background-color: gray;
      background-position-x: 55%;
    }
    .dash-corretor-topico {
      background-color: white;
      border-radius: 20px;
      margin-top: 10%;
      box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
      padding: 2%;
      height: 420px;
      position: relative;
      width: 100%;
      /* float: right; */
    }
    .dash-corretor-topico img {
      position: absolute;
      left: 0px;
      top: 0px;
      height: 300px;
      -webkit-filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.2));
      filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.2));
    }
    .dash-corretor-topico .col-md-4 {
      height: 250px;
    }
  }
</style>