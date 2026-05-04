/**
 * Configuração centralizada de URLs de API
 * 
 * Altere o valor de `useLocal` para trocar entre ambientes:
 * - true: usa servidor local (desenvolvimento)
 * - false: usa servidor remoto (produção)
 */

const useLocal = true; // Mude para false em produção

const API_CONFIG = {
  local: {
    baseUrl: 'http://localhost:8080',
    apiCorretor: 'http://localhost:8080/api/corretor',
    apiVisita: 'http://localhost:8080/api/visita',
    apiProprietario: 'http://localhost:8080/api/proprietario',
    apiImovel: 'http://localhost:8080/api/imovel',
  },
  remote: {
    baseUrl: 'https://www.avantorimoveis.com.br/dadoscorretor',
    apiCorretor: 'https://www.avantorimoveis.com.br/dadoscorretor/api/corretor',
    apiVisita: 'https://www.avantorimoveis.com.br/dadoscorretor/api/visita',
    apiProprietario: 'https://www.avantorimoveis.com.br/dadoscorretor/api/proprietario',
    apiImovel: 'https://www.avantorimoveis.com.br/dadoscorretor/api/imovel',
  }
};

// Seleciona a configuração atual baseado no ambiente
const currentConfig = useLocal ? API_CONFIG.local : API_CONFIG.remote;

export const API_URL = {
  baseUrl: currentConfig.baseUrl,
  apiCorretor: currentConfig.apiCorretor,
  apiProprietario: currentConfig.apiProprietario,
  apiImovel: currentConfig.apiImovel,
  // Aliases para compatibilidade com código existente
  urlraiz: currentConfig.baseUrl,
  apibase: currentConfig.apiCorretor,
  urlproprietario: currentConfig.apiProprietario,
  urlmarca: currentConfig.apiImovel,
};

export default API_URL;
