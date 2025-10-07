# Reunião 02-08-2025
 - funcionalidade atrelada ao BI (avaliação)

=============================================================================================================   TELA 1
# Abre no mapa, primeira área do Mapa
 - começa setando a cidade (começarei só com Santa Maria)
 - Formulário de busca por endereço (ou atualmente, selecionar o raio??? citado como bem importante)
 - Outra maneira: selecionar por bairros
# Nota: vou seguir pelo RAIO que seleciona imóveis (draw)
 - Mas ainda falta assim implementar um filtro para tipos de imóveis (apartamento, casa...) usar múltiple select
 - Selecionar mais características do imóvel que quero precificar - filtrando semelhantes

=============================================================================================================   TELA 2
# Entrar na Precificação (Clica em Avaliar, traz uma tabela com os imóveis filtrados)
 -- Obs.: Amostragem traz valor sugerido (deve ser uma mediana do valor)
 - Amostragem muito grande: possibilidade de afunilar
 -- Obs.: melhor adicionar opção de filtro (editar a pesquisa) na tabela
 -- Obs.: campo área útil (ou privativa) é bem importante
 - Para a mediana da área útil aproximada: ""30%"" pra mais ou pra menos
 - Mediana de quantia de cômodos (garagens, quartos, banheiros) deixar variável
 -- obs: listar mais focado em área

# Da listagem:
 - Pesquisa (filtrar)
 - OPÇÃO DE SELECIONAR Imóveis
# CAMPO SUB-TABELA DE LISTAGEM: MEDIANA DO VALOR SUGERIDO "Valor de Avaliação Sugerido", com botão "Reavaliar" p/ atualizar o valor sugerido

 - Ele se atualiza - inicia com a mediana dos valores dos imóveis filtrados
 - Atualiza-se de acordo com a fitragem da tabela 
 - Atualiza-se de acordo com os imóveis selecionados pelo usuário
 - APÓS avaliação: botão "Prosseguir", que leva o valor avaliado (reavaliado) p/ a próxima tela

=============================================================================================================   TELA 3
# Formulário p/ o Relatório
 - Campo 1 - fachada do imóvel (pega do streetviews ou faz upload da foto da fachada do imóvel)
 - Campo 2 - Ajuste do valor final (traz o valor avaliado) num campo EDITÀVEL
 - Campos 3 e 4 - Dois campos auxiliares: com valores máximo e mínimo (definir porcentagem de proximidade p/+ p/-)
 - Campo 5 - Solicitante (texto com formatação)
 - Campo 6 - Finalidade da avaliação (texto com formatação)
 - Campo 7 - Descrição do Imóvel (texto com formatação)
 - Campo 8 - Descrição da Região (texto com formatação)
 - Campo 9 - Metodologia da Avaliação (texto com formatação)
 - Campo 10 - Conclusão (texto com formatação)
 - Campo 11 - Anexar FOTOS

# Gerar o Relatório
 - Mapa com o círculo 
 - Informações geradas no campo
 - Lista dos imóveis selecionados que geraram a avaliação

# Gera o PDF