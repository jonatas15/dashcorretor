<template>
    <div class="container text-left">
      <div class="row align-items-start">
        <div class="col-md-12 banner" style="position: relative;">
          <!-- <img src="src/assets/banner/banner-1.png" /> -->
          <div class="vertical-center" style="width: 305px !important;">
            <h5 class="titulo-dash" style="">
              Veja como estipular suas<br>
              metas de maneiras alcançáveis.
            </h5>
            <a class="btn btn-transparente float-right" href="#">ver mais</a>
          </div>
        </div>
        <div class="col-md-12 dash-corretor">
            <!-- <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%"></div>
            </div>
            <sub>Em construção</sub>
            <hr> -->
            <br/>
            <h3>Pesquisar Cliente</h3>
            <br>
            <br>
            <div>
              <div class="row">
                <div class="col-md-6">
                  <a href="https://painel.assertivasolucoes.com.br/login" target="_blank" class="btn btn-default botao-logo">
                    <img src="@/assets/logo/assertiva-logo.png" alt="">
                  </a>
                  <!-- <hr> -->
                  <div class="caixa">
                    <div class="credencial-linha">
                      <strong id="user_assertiva">Usuario: {{ credenciais.assertiva.usuario }}</strong>
                      <button
                        type="button"
                        class="btn-copiar"
                        @click="copiarTexto(credenciais.assertiva.usuario, 'assertiva-usuario')"
                        :aria-label="`Copiar login da Assertiva`"
                      >
                        {{ copiedKey === 'assertiva-usuario' ? 'Copiado' : 'Copiar' }}
                      </button>
                    </div>
                    <!-- <hr> -->
                    <!-- <strong>Caf3imob88@</strong><br> -->
                    <div class="credencial-linha">
                      <strong id="senha_assertiva">Senha: {{ credenciais.assertiva.senha }}</strong>
                      <button
                        type="button"
                        class="btn-copiar"
                        @click="copiarTexto(credenciais.assertiva.senha, 'assertiva-senha')"
                        :aria-label="`Copiar senha da Assertiva`"
                      >
                        {{ copiedKey === 'assertiva-senha' ? 'Copiado' : 'Copiar' }}
                      </button>
                    </div>
                    <hr class="hr-credenciais">
                  <div class="col-md-12 my-3">
                    <span class="observacao-credencial">{{ credenciais.assertiva.observacao }}</span>
                  </div>
                  </div>
                </div>
                  <div
                    v-for="(conta, index) in credenciais.confirme.contas"
                    :key="`confirme-card-${index}`"
                    class="card-credencial-item col-md-6"
                  >
                    <a :href="conta.url || credenciais.confirme.url" target="_blank" class="btn btn-default botao-logo">
                      <img src="@/assets/logo/logo_login_checkonn.jpeg" alt="">
                    </a>
                    <div class="caixa">
                      <div class="credencial-linha">
                        <!-- <strong :id="`titulo_confirme${index + 1}`">{{ conta.titulo || `Conta ${index + 1}` }}</strong> -->
                      </div>
                      <div class="credencial-linha mt-2">
                        <strong :id="`user_confirme${index + 1}`">Usuario: {{ conta.usuario }}</strong>
                        <button
                          type="button"
                          class="btn-copiar"
                          @click="copiarTexto(conta.usuario, `confirme-usuario-${index}`)"
                          :aria-label="`Copiar usuario da conta ${index + 1} do Confirme`"
                        >
                          {{ copiedKey === `confirme-usuario-${index}` ? 'Copiado' : 'Copiar' }}
                        </button>
                      </div>
                      <div class="credencial-linha mt-2">
                        <strong :id="`senha_confirme${index + 1}`">Senha: {{ conta.senha }}</strong>
                        <button
                          type="button"
                          class="btn-copiar"
                          @click="copiarTexto(conta.senha, `confirme-senha-${index}`)"
                          :aria-label="`Copiar senha da conta ${index + 1} do Confirme`"
                        >
                          {{ copiedKey === `confirme-senha-${index}` ? 'Copiado' : 'Copiar' }}
                        </button>
                      </div>
                      <div class="mt-3">
                        <span class="observacao-credencial">{{ conta.observacao || credenciais.confirme.observacao }}</span>
                      </div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                  <a href=" https://brokers.eemovel.com.br/login" target="_blank" class="btn btn-default botao-logo">
                    <img src="@/assets/logo/brokers.png" alt="">
                  </a>
                  <p class="caixa">
                    <strong>Usuario: leads@cafeimobiliaria.com.br | Senha: V4AGLR</strong>
                    <br />
                    <br />
                    <strong>Usuario: fabio@cafeimobiliaria.com.br | Senha: JESY8I</strong>
                  </p>
                </div> -->
              </div>
            </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        copiedKey: '',
        copiedTimeout: null,
        credenciais: {
          assertiva: {
            usuario: 'contato@cafeimobiliaria.com.br',
            senha: 'Avantor891732@%7867'
          },
          confirme: {
            contas: [
              { usuario: 'CANEI00005', senha: 'KQ0#frm#' },
              { usuario: 'CANEI00004', senha: 'XoTt$TgJ' }
            ],
            observacao: '** Será solicitado um código de confirmação, verificar com a Patrícia.'
          }
        }
      }
    },
    mounted() {
      this.carregarCredenciais()
    },
    methods: {
      async copiarTexto(texto, chave) {
        try {
          if (navigator?.clipboard?.writeText) {
            await navigator.clipboard.writeText(texto)
          } else {
            const areaTemporaria = document.createElement('textarea')
            areaTemporaria.value = texto
            areaTemporaria.setAttribute('readonly', '')
            areaTemporaria.style.position = 'absolute'
            areaTemporaria.style.left = '-9999px'
            document.body.appendChild(areaTemporaria)
            areaTemporaria.select()
            document.execCommand('copy')
            document.body.removeChild(areaTemporaria)
          }

          this.copiedKey = chave

          if (this.copiedTimeout) {
            clearTimeout(this.copiedTimeout)
          }

          this.copiedTimeout = setTimeout(() => {
            this.copiedKey = ''
          }, 1800)
        } catch (erro) {
          console.warn('Nao foi possivel copiar para a area de transferencia.', erro)
        }
      },
      async carregarCredenciais() {
        try {
          const resposta = await fetch(`${import.meta.env.BASE_URL}jsons/senhas.json`, { cache: 'no-store' })

          if (!resposta.ok) {
            throw new Error(`Falha ao carregar senhas.json: ${resposta.status}`)
          }

          const dados = await resposta.json()

          this.credenciais = {
            assertiva: {
              ...this.credenciais.assertiva,
              ...(dados.assertiva || {})
            },
            confirme: {
              ...this.credenciais.confirme,
              ...(dados.confirme || {}),
              contas: Array.isArray(dados?.confirme?.contas) && dados.confirme.contas.length > 0
                ? dados.confirme.contas
                : this.credenciais.confirme.contas
            }
          }
        } catch (erro) {
          console.warn('Nao foi possivel carregar jsons/senhas.json. Mantendo credenciais padrao.', erro)
        }
      }
    }
  }
  </script>

  <style>
  /* @media (min-width: 1024px) {
    .universidade {
      min-height: 100vh;
      display: flex;
      align-items: center;
    }
  } */
  .caixa {
    box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.1);
    padding: 8%;
    border: 1px solid ghostwhite;
    margin: 0% 5%;
    z-index: -1;
    font-size: 15px;
  }
  .credencial-linha {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-top: 5% !important;
  }
  .credencial-linha strong {
    word-break: break-word;
  }
  .btn-copiar {
    border: 1px solid #d9d9d9;
    background: #fff;
    color: #6b6b6b;
    border-radius: 12px;
    padding: 2px 10px;
    font-size: 12px;
    line-height: 1.4;
    white-space: nowrap;
    transition: all 0.2s ease;
  }
  .btn-copiar:hover {
    color: #333;
    border-color: #bdbdbd;
  }
  .btn-copiar:focus-visible {
    outline: 2px solid rgba(60, 125, 255, 0.4);
    outline-offset: 2px;
  }
  .card-credencial-item {
    margin-bottom: 18px;
  }
  .card-credencial-item:last-child {
    margin-bottom: 0;
  }
  .hr-credenciais {
    border: none;
    border-top: 1px solid rgba(0, 0, 0, 0.12);
    margin: 6px 0 12px;
  }
  .observacao-credencial {
    color: #c41212;
    font-weight: 600;
  }
  .botao-logo {
    z-index: 100;
    border: 1px solid ghostwhite;
    width: 100%;
    padding: 10%;
    box-shadow: 12.778px 9.629px 16px rgba(0, 0, 0, 0.16);
  }
  .botao-logo:hover {
    box-shadow: 12.778px 9.629px 16px rgba(0, 0, 0, 0.25);
  }
  .botao-logo img {
    width: auto !important;
    height: 100px !important;
    max-width: 100% !important;
  }
  </style>
  