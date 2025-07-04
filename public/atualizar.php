<?php 
// Esse arquivo atualiza os jsons personalizados do site
function get_content($url, $expire = 0) {
    $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . sha1($url);

    if (file_exists($file) && (time() - $expire < filemtime($file))) {
        $json_imoveis = file_get_contents($file);
    } else {
        $content = file_get_contents($url);
        file_put_contents($file, $content, LOCK_EX);
        $json_imoveis = $content;
    }
    $imoveis = json_decode($json_imoveis);
    return $imoveis;
}
$estadosBrasileiros = array(
    'AC' => 'Acre',
    'AL' => 'Alagoas',
    'AP' => 'Amapá',
    'AM' => 'Amazonas',
    'BA' => 'Bahia',
    'CE' => 'Ceará',
    'DF' => 'Distrito Federal',
    'ES' => 'Espírito Santo',
    'GO' => 'Goiás',
    'MA' => 'Maranhão',
    'MT' => 'Mato Grosso',
    'MS' => 'Mato Grosso do Sul',
    'MG' => 'Minas Gerais',
    'PA' => 'Pará',
    'PB' => 'Paraíba',
    'PR' => 'Paraná',
    'PE' => 'Pernambuco',
    'PI' => 'Piauí',
    'RJ' => 'Rio de Janeiro',
    'RN' => 'Rio Grande do Norte',
    'RS' => 'Rio Grande do Sul',
    'RO' => 'Rondônia',
    'RR' => 'Roraima',
    'SC' => 'Santa Catarina',
    'SP' => 'São Paulo',
    'SE' => 'Sergipe',
    'TO' => 'Tocantins'
);
function tirarAcentos($string) {
    $stringa = str_replace(', ', ',', $string);
    $stringb = str_replace(' ,', ',', $stringa);
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $stringb);
}
function urlAmigavel($nom_tag, $slug = "-") {
    $nom_tag2 = tirarAcentos($nom_tag);
    $string = strtolower($nom_tag2);

    // Código ASCII das vogais
    $ascii['a'] = range(224, 230);
    $ascii['e'] = range(232, 235);
    $ascii['i'] = range(236, 239);
    $ascii['o'] = array_merge(range(242, 246), array(240, 248));
    $ascii['u'] = range(249, 252);

    // Código ASCII dos outros caracteres
    $ascii['b'] = array(223);
    $ascii['c'] = array(231);
    $ascii['d'] = array(208);
    $ascii['n'] = array(241);
    $ascii['y'] = array(253, 255);

    foreach ($ascii as $key => $item) {
        $acentos = '';
        foreach ($item AS $codigo)
            $acentos .= chr($codigo);
        $troca[$key] = '/[' . $acentos . ']/i';
    }

    $string = preg_replace(array_values($troca), array_keys($troca), $string);

    if ($slug) {
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
    }
    return $string;
}
if ($_REQUEST['codigo'] and $_REQUEST['codigo'] != ''):
    $json_imoveis = get_content('https://api.jetimob.com/webservice/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis?v=v5&page=11&pageSize=400',1);
    $updatedimv = "Código executado: ";
    $json_imoveis = $json_imoveis->data;
    foreach ($json_imoveis as $imv) {
        if ($imv->codigo == $_REQUEST['codigo']) {
            $updatedimv .= "<br>Código ENCONTRADO: ";
            # início: Definição dos Imóveis SIMILARES por valores, e os CONDOMINARES (mesmo condomínio)
            $imoveis_similares = [];
            $imoveis_condominares = [];
            $iii = 0;
            $jjj = 0;
            $intervalo_maior = $imv->valor_venda + ($imv->valor_venda * 0.3);
            $intervalo_menor = $imv->valor_venda - ($imv->valor_venda * 0.3);
            if ($imv->contrato == 'Locação') {
                $intervalo_maior = $imv->valor_locacao + ($imv->valor_locacao * 0.3);
                $intervalo_menor = $imv->valor_locacao - ($imv->valor_locacao * 0.3);
            }
            foreach ($json_imoveis as $similar) {
                # IMÓVEIS CONDOMINARES ------------------------------------------------------------------------------------
                if ($similar->codigo != $imv->codigo && $similar->condominio_nome == $imv->condominio_nome && $iii < 10) {
                    
                    $similar_terreno_comprimento = 0;
                    if ($similar->terreno_esquerdo > 0 && $similar->terreno_direita > 0 && $similar->terreno_esquerdo !== $similar->terreno_direita) {
                        $similar_terreno_comprimento = ($similar->terreno_esquerdo + $similar->terreno_direita) / 2;
                    } elseif ($similar->terreno_esquerdo > 0) {
                        $similar_terreno_comprimento = $similar->terreno_esquerdo;
                    } elseif ($similar->terreno_direita > 0) {
                        $similar_terreno_comprimento = $similar->terreno_direita;
                    }

                    $similar_terreno_largura = 0;
                    if ($similar->terreno_frente > 0 && $similar->terreno_fundos > 0 && $similar->terreno_frente !== $similar->terreno_fundos) {
                        $similar_terreno_largura = ($similar->terreno_frente + $similar->terreno_fundos) / 2;
                    } elseif ($similar->terreno_frente > 0) {
                        $similar_terreno_largura = $similar->terreno_frente;
                    } elseif ($similar->terreno_fundos > 0) {
                        $similar_terreno_largura = $similar->terreno_fundos;
                    }

                    $similar_area_total = 0;

                    if ($similar->area_total > 0) {
                        $similar_area_total = $similar->area_total;
                    } else {
                        $similar_area_total = $similar->terreno_total;
                    }

                    $similar_reduzido = [
                        "codigo" => $similar->codigo,
                        "contrato" => $similar->contrato,
                        "tipo" => $similar->tipo,
                        "subtipo" => $similar->subtipo,
                        "thumb" => $similar->imagens[0]->link,
                        "endereco_bairro" => $similar->endereco_bairro,
                        "endereco_cidade" => $similar->endereco_cidade,
                        "endereco_estado" => $similar->endereco_estado,
                        "endereco_logradouro" => $similar->endereco_logradouro,
                        "condominio_nome" => $similar->condominio_nome,
                        "dormitorios" => $similar->dormitorios,
                        "suites" => $similar->suites,
                        "garagens" => $similar->garagens,
                        "banheiros" => $similar->banheiros,
                        "area_privativa" => $similar->area_privativa,
                        "area_util" => $similar->area_util,
                        "area_total" => (float)$similar_area_total,
                        "terreno_largura" => $similar_terreno_largura,
                        "terreno_comprimento" => $similar_terreno_comprimento,
                        "valor_venda" => $similar->valor_venda,
                        "valor_locacao" => $similar->valor_locacao,
                        "tags" => $similar->tags,
                        "destaque" => $similar->destaque,
                        "exclusividade" => $similar->exclusividade,
                        "imovel_comodidades" => $similar->imovel_comodidades,
                        "condominio_comodidades" => $similar->condominio_comodidades,
                        "latitude" => $similar->latitude,
                        "longitude" => $similar->longitude,
                        "status" => $similar->status,
                        "mobiliado" => $similar->mobiliado,
                        "situacao_condominio" => $situacao
                    ];
                    // $imoveis_condominares[$iii] = $similar_reduzido;
                    array_push($imoveis_condominares, $similar_reduzido);
                    $iii++;
                    // $iii ++;
                }
                # IMÓVEIS SIMILARES ---------------------------------------------------------------------------------------
                $valor_similar = $similar->valor_venda;
                    
                if ($imv->contrato == 'Locação') {
                    $valor_similar = $similar->valor_locacao;
                }

                if (
                    $similar->codigo != $imv->codigo &&
                    $similar->contrato == $imv->contrato &&
                    $similar->subtipo == $imv->subtipo &&
                    ($intervalo_maior >= $valor_similar && $intervalo_menor <= $valor_similar) &&
                    $jjj < 10
                ){
                    $similar_terreno_comprimento = 0;
                    if ($similar->terreno_esquerdo > 0 && $similar->terreno_direita > 0 && $similar->terreno_esquerdo !== $similar->terreno_direita) {
                        $similar_terreno_comprimento = ($similar->terreno_esquerdo + $similar->terreno_direita) / 2;
                    } elseif ($similar->terreno_esquerdo > 0) {
                        $similar_terreno_comprimento = $similar->terreno_esquerdo;
                    } elseif ($similar->terreno_direita > 0) {
                        $similar_terreno_comprimento = $similar->terreno_direita;
                    }

                    $similar_terreno_largura = 0;
                    if ($similar->terreno_frente > 0 && $similar->terreno_fundos > 0 && $similar->terreno_frente !== $similar->terreno_fundos) {
                        $similar_terreno_largura = ($similar->terreno_frente + $similar->terreno_fundos) / 2;
                    } elseif ($similar->terreno_frente > 0) {
                        $similar_terreno_largura = $similar->terreno_frente;
                    } elseif ($similar->terreno_fundos > 0) {
                        $similar_terreno_largura = $similar->terreno_fundos;
                    }

                    $similar_area_total = 0;

                    if ($similar->area_total > 0) {
                        $similar_area_total = $similar->area_total;
                    } else {
                        $similar_area_total = $similar->terreno_total;
                    }

                    $similar_reduzido = [
                        "codigo" => $similar->codigo,
                        "contrato" => $similar->contrato,
                        "tipo" => $similar->tipo,
                        "subtipo" => $similar->subtipo,
                        "thumb" => $similar->imagens[0]->link,
                        "endereco_bairro" => $similar->endereco_bairro,
                        "endereco_cidade" => $similar->endereco_cidade,
                        "endereco_estado" => $similar->endereco_estado,
                        "endereco_logradouro" => $similar->endereco_logradouro,
                        "condominio_nome" => $similar->condominio_nome,
                        "dormitorios" => $similar->dormitorios,
                        "suites" => $similar->suites,
                        "garagens" => $similar->garagens,
                        "banheiros" => $similar->banheiros,
                        "area_privativa" => $similar->area_privativa,
                        "area_util" => $similar->area_util,
                        "area_total" => (float)$similar_area_total,
                        "terreno_largura" => $similar_terreno_largura,
                        "terreno_comprimento" => $similar_terreno_comprimento,
                        "valor_venda" => $similar->valor_venda,
                        "valor_locacao" => $similar->valor_locacao,
                        "tags" => $similar->tags,
                        "destaque" => $similar->destaque,
                        "exclusividade" => $similar->exclusividade,
                        "imovel_comodidades" => $similar->imovel_comodidades,
                        "condominio_comodidades" => $similar->condominio_comodidades,
                        "latitude" => $similar->latitude,
                        "longitude" => $similar->longitude,
                        "status" => $similar->status,
                        "mobiliado" => $similar->mobiliado,
                        "situacao_condominio" => $situacao
                    ];
                    array_push($imoveis_similares, $similar_reduzido);
                    $jjj++;
                }

            }
            $imv->condominares = $imoveis_condominares;
            $imv->similares = $imoveis_similares;
            $imv->imagens_cond = $galeria_condominio;
            if (file_put_contents("jsons/".$imv->codigo.'.json', json_encode($imv))) {
                $updatedimv .= $imv->codigo . ": Novos dados;" . '<hr>';
                $updatedimv .= "<a href='https://www.avantorimoveis.com.br/imovel/{$imv->codigo}' target='_blanck'>Verificar: https://www.avantorimoveis.com.br/imovel/{$imv->codigo}</a>" . '<br>';
                $updatedimv .= "<sub><strong>Obs.: Atualizar a página com Ctrl+R ou Shift+F5 (em chrome, edge, opera) para limpar o cache e ver as modificações</strong></sub>";
                break;
            }
        }
    }
    echo $updatedimv;
else:
    $json_corretores = get_content('https://api.jetimob.com/webservice/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/corretores?v=v2',1);
    $limite = 25;
    $json_imoveis = [];
    for ($i=1; $i < $limite; $i++) { 
        array_push($json_imoveis, get_content('https://api.jetimob.com/webservice/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis?v=v5&page='.$i.'&pageSize=250',1));
    }
    $l = 0;
    $arr_imoveis = [];
    $codigosconfere = [];
    $$imovel_x = '';
    $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    for ($l=0; $l < $limite; $l++) {
        $sub_json_100imvs = $json_imoveis[$l]->data;
        foreach ($sub_json_100imvs as $leva) {
            ###################################################################################################################
            # Medidas e Galerias ==============================================================================================
            # Definições sobre Áreas para Terrenos ----------------------------------------------------------------------------
            $imv = $leva;
            $terreno_comprimento = 0;
            if ($imv->terreno_esquerdo > 0 && $imv->terreno_direita > 0 && $imv->terreno_esquerdo !== $imv->terreno_direita) {
                $terreno_comprimento = ($imv->terreno_esquerdo + $imv->terreno_direita) / 2;
            } elseif ($imv->terreno_esquerdo > 0) {
                $terreno_comprimento = $imv->terreno_esquerdo;
            } elseif ($imv->terreno_direita > 0) {
                $terreno_comprimento = $imv->terreno_direita;
            }

            $terreno_largura = 0;
            if ($imv->terreno_frente > 0 && $imv->terreno_fundos > 0 && $imv->terreno_frente !== $imv->terreno_fundos) {
                $terreno_largura = ($imv->terreno_frente + $imv->terreno_fundos) / 2;
            } elseif ($imv->terreno_frente > 0) {
                $terreno_largura = $imv->terreno_frente;
            } elseif ($imv->terreno_fundos > 0) {
                $terreno_largura = $imv->terreno_fundos;
            }
            # Definição de área terreno x residencial
            $area_total = 0;

            if ($imv->area_total > 0) {
                $area_total = $imv->area_total;
            } else {
                $area_total = $imv->terreno_total;
            }
            # Definição da Galeria de Imagens
            $galeria_imagens = [];
            $galeria_imagens_thumb = [];
            $i_img = 0;
            $limite_imagens_subgaleria = 3;
            foreach ($imv->imagens as $img) {
                if (!is_null($img->link) && !empty($img->link) && $i_img <= $limite_imagens_subgaleria) {
                    array_push($galeria_imagens, $img->link);
                    if (!is_null($img->link) && !empty($img->link)) {
                        array_push($galeria_imagens_thumb, $img->link);
                    }
                    $i_img++;
                }
            }
            # Medidas e Galerias
            #################################################################################
            array_push($arr_imoveis, [
                "codigo" => $leva->codigo,
                "contrato" => $leva->contrato,
                "tipo" => $leva->tipo,
                "subtipo" => $leva->subtipo,
                "imagem" => $leva->imagens[0]->link,
                "thumb" => $leva->imagens[0]->link,
                //subgalerias
                "galeria_imagem" => $galeria_imagens,
                "galeria_thumb" => $galeria_imagens_thumb,
                //subgalerias
                "endereco_bairro" => $leva->endereco_bairro,
                "endereco_cidade" => $leva->endereco_cidade,
                "endereco_estado" => $leva->endereco_estado,
                "endereco_logradouro" => $leva->endereco_logradouro,
                "condominio_nome" => $leva->condominio_nome,
                "dormitorios" => $leva->dormitorios,
                "suites" => $leva->suites,
                "garagens" => $leva->garagens,
                "banheiros" => $leva->banheiros,
                "observacoes" => $leva->observacoes,
                "area_privativa" => $leva->area_privativa,
                "area_util" => $leva->area_util,
                //medidas importantes
                "area_total" => (float)$area_total,
                "terreno_largura" => $terreno_largura,
                "terreno_comprimento" => $terreno_comprimento,
                "situacao_condominio" => $situacao,
                //medidas importantes
                "valor_venda" => $leva->valor_venda,
                "valor_locacao" => $leva->valor_locacao,
                "tags" => $leva->tags,
                "destaque" => $leva->destaque,
                "exclusividade" => $leva->exclusividade,
                "imovel_comodidades" => $leva->imovel_comodidades,
                "condominio_comodidades" => $leva->condominio_comodidades,
                "latitude" => $leva->latitude,
                "longitude" => $leva->longitude,
                "status" => $leva->status,
                "mobiliado" => $leva->mobiliado,
                "permuta" => $leva->permuta,
                "data_cadastro" => $leva->data_cadastro,
                "data_update" => $leva->data_update
            ]);
            ##########################################################################################
            ####################### AQUI PREPARAMOS A LISTA DE IMÒVEIS NO SITE #######################
            array_push($codigosconfere, $imv->codigo);
            ##########################################################################################
            ############################ AQUI PREPARAMOS O JSON DO IMÓVEL ############################
            // Apenas para novos imóveis
            // if (file_exists("jsons/{$imv->codigo}.json")):
            //     $imovel_x .= "jsons/{$imv->codigo}.json já consta no Sistema".'<br>';
            // else:
                $imoveis_similares = [];
                $imoveis_condominares = [];
                $iii = 0;
                $jjj = 0;
                $intervalo_maior = $imv->valor_venda + ($imv->valor_venda * 0.3);
                $intervalo_menor = $imv->valor_venda - ($imv->valor_venda * 0.3);
                if ($imv->contrato == 'Locação') {
                    $intervalo_maior = $imv->valor_locacao + ($imv->valor_locacao * 0.3);
                    $intervalo_menor = $imv->valor_locacao - ($imv->valor_locacao * 0.3);
                }
                foreach ($sub_json_100imvs as $similar) {
                    # IMÓVEIS CONDOMINARES ------------------------------------------------------------------------------------
                    if ($similar->codigo != $imv->codigo && $similar->condominio_nome == $imv->condominio_nome && $iii < 10) {
                        
                        $similar_terreno_comprimento = 0;
                        if ($similar->terreno_esquerdo > 0 && $similar->terreno_direita > 0 && $similar->terreno_esquerdo !== $similar->terreno_direita) {
                            $similar_terreno_comprimento = ($similar->terreno_esquerdo + $similar->terreno_direita) / 2;
                        } elseif ($similar->terreno_esquerdo > 0) {
                            $similar_terreno_comprimento = $similar->terreno_esquerdo;
                        } elseif ($similar->terreno_direita > 0) {
                            $similar_terreno_comprimento = $similar->terreno_direita;
                        }

                        $similar_terreno_largura = 0;
                        if ($similar->terreno_frente > 0 && $similar->terreno_fundos > 0 && $similar->terreno_frente !== $similar->terreno_fundos) {
                            $similar_terreno_largura = ($similar->terreno_frente + $similar->terreno_fundos) / 2;
                        } elseif ($similar->terreno_frente > 0) {
                            $similar_terreno_largura = $similar->terreno_frente;
                        } elseif ($similar->terreno_fundos > 0) {
                            $similar_terreno_largura = $similar->terreno_fundos;
                        }

                        $similar_area_total = 0;

                        if ($similar->area_total > 0) {
                            $similar_area_total = $similar->area_total;
                        } else {
                            $similar_area_total = $similar->terreno_total;
                        }

                        $similar_reduzido = [
                            "codigo" => $similar->codigo,
                            "contrato" => $similar->contrato,
                            "tipo" => $similar->tipo,
                            "subtipo" => $similar->subtipo,
                            "thumb" => $similar->imagens[0]->link,
                            "endereco_bairro" => $similar->endereco_bairro,
                            "endereco_cidade" => $similar->endereco_cidade,
                            "endereco_estado" => $similar->endereco_estado,
                            "endereco_logradouro" => $similar->endereco_logradouro,
                            "condominio_nome" => $similar->condominio_nome,
                            "dormitorios" => $similar->dormitorios,
                            "suites" => $similar->suites,
                            "garagens" => $similar->garagens,
                            "banheiros" => $similar->banheiros,
                            "area_privativa" => $similar->area_privativa,
                            "area_util" => $similar->area_util,
                            "area_total" => (float)$similar_area_total,
                            "terreno_largura" => $similar_terreno_largura,
                            "terreno_comprimento" => $similar_terreno_comprimento,
                            "valor_venda" => $similar->valor_venda,
                            "valor_locacao" => $similar->valor_locacao,
                            "tags" => $similar->tags,
                            "destaque" => $similar->destaque,
                            "exclusividade" => $similar->exclusividade,
                            "imovel_comodidades" => $similar->imovel_comodidades,
                            "condominio_comodidades" => $similar->condominio_comodidades,
                            "latitude" => $similar->latitude,
                            "longitude" => $similar->longitude,
                            "status" => $similar->status,
                            "mobiliado" => $similar->mobiliado,
                            "situacao_condominio" => $situacao
                        ];
                        // $imoveis_condominares[$iii] = $similar_reduzido;
                        array_push($imoveis_condominares, $similar_reduzido);
                        $iii++;
                        // $iii ++;
                    }
                    # IMÓVEIS SIMILARES ---------------------------------------------------------------------------------------
                    $valor_similar = $similar->valor_venda;
                        
                    if ($imv->contrato == 'Locação') {
                        $valor_similar = $similar->valor_locacao;
                    }

                    if (
                        $similar->codigo != $imv->codigo &&
                        $similar->contrato == $imv->contrato &&
                        $similar->subtipo == $imv->subtipo &&
                        ($intervalo_maior >= $valor_similar && $intervalo_menor <= $valor_similar) &&
                        $jjj < 10
                    ){
                        $similar_terreno_comprimento = 0;
                        if ($similar->terreno_esquerdo > 0 && $similar->terreno_direita > 0 && $similar->terreno_esquerdo !== $similar->terreno_direita) {
                            $similar_terreno_comprimento = ($similar->terreno_esquerdo + $similar->terreno_direita) / 2;
                        } elseif ($similar->terreno_esquerdo > 0) {
                            $similar_terreno_comprimento = $similar->terreno_esquerdo;
                        } elseif ($similar->terreno_direita > 0) {
                            $similar_terreno_comprimento = $similar->terreno_direita;
                        }

                        $similar_terreno_largura = 0;
                        if ($similar->terreno_frente > 0 && $similar->terreno_fundos > 0 && $similar->terreno_frente !== $similar->terreno_fundos) {
                            $similar_terreno_largura = ($similar->terreno_frente + $similar->terreno_fundos) / 2;
                        } elseif ($similar->terreno_frente > 0) {
                            $similar_terreno_largura = $similar->terreno_frente;
                        } elseif ($similar->terreno_fundos > 0) {
                            $similar_terreno_largura = $similar->terreno_fundos;
                        }

                        $similar_area_total = 0;

                        if ($similar->area_total > 0) {
                            $similar_area_total = $similar->area_total;
                        } else {
                            $similar_area_total = $similar->terreno_total;
                        }

                        $similar_reduzido = [
                            "codigo" => $similar->codigo,
                            "contrato" => $similar->contrato,
                            "tipo" => $similar->tipo,
                            "subtipo" => $similar->subtipo,
                            "thumb" => $similar->imagens[0]->link,
                            "endereco_bairro" => $similar->endereco_bairro,
                            "endereco_cidade" => $similar->endereco_cidade,
                            "endereco_estado" => $similar->endereco_estado,
                            "endereco_logradouro" => $similar->endereco_logradouro,
                            "condominio_nome" => $similar->condominio_nome,
                            "dormitorios" => $similar->dormitorios,
                            "suites" => $similar->suites,
                            "garagens" => $similar->garagens,
                            "banheiros" => $similar->banheiros,
                            "area_privativa" => $similar->area_privativa,
                            "area_util" => $similar->area_util,
                            "area_total" => (float)$similar_area_total,
                            "terreno_largura" => $similar_terreno_largura,
                            "terreno_comprimento" => $similar_terreno_comprimento,
                            "valor_venda" => $similar->valor_venda,
                            "valor_locacao" => $similar->valor_locacao,
                            "tags" => $similar->tags,
                            "destaque" => $similar->destaque,
                            "exclusividade" => $similar->exclusividade,
                            "imovel_comodidades" => $similar->imovel_comodidades,
                            "condominio_comodidades" => $similar->condominio_comodidades,
                            "latitude" => $similar->latitude,
                            "longitude" => $similar->longitude,
                            "status" => $similar->status,
                            "mobiliado" => $similar->mobiliado,
                            "situacao_condominio" => $situacao
                        ];
                        array_push($imoveis_similares, $similar_reduzido);
                        $jjj++;
                    }

                }
                $imv->condominares = $imoveis_condominares;
                $imv->similares = $imoveis_similares;
                $imv->imagens_cond = $galeria_condominio;

                if (file_put_contents("jsons/".$imv->codigo.'.json', json_encode($imv))) {
                    $imovel_x .= $imv->codigo . ": atualizado;" . '<br>';
                } else {
                    $imovel_x .= $imv->codigo . ": Erro com esse;" . '<br>';
                }
            // endif;
            ############################################################################################
            ################################# SISTEMA DE SITEMAP - XML #################################
            switch ($imv->contrato) {
                case 'Compra': $contrato_url = 'venda'; break;    
                case 'Locação': $contrato_url = 'aluguel'; break;    
                default: $contrato_url = 'venda-aluguel'; break;
            }
            $nova_url_seo = 'imovel/'.$imv->codigo ;
            $nova_url_seo_expandida = (!empty($imv->contrato) ? urlAmigavel($contrato_url) : '') .
            (!empty($imv->subtipo) ? '-' .urlAmigavel($imv->subtipo) : '-' .urlAmigavel($imv->tipo)) .
            (!empty($imv->dormitorios) ? '-' . urlAmigavel($imv->dormitorios) . '-dormitorios' : '') .
            (!empty($imv->garagens) ? '-' . urlAmigavel($imv->garagens) . '-vagas' : '') .
            (!empty($imv->condominio_nome) ? '-' . urlAmigavel($imv->condominio_nome) : '') .
            (!empty($imv->endereco_bairro) ? '-' . urlAmigavel($imv->endereco_bairro) : '') .
            (!empty($imv->endereco_cidade) ? '-' . urlAmigavel($imv->endereco_cidade) : '') .
            (!empty($imv->endereco_estado) ? '-' . urlAmigavel(array_search($imv->endereco_estado, $estadosBrasileiros)) : '');
            $xml .= '<url> 
                        <loc>https://www.avantorimoveis.com.br/'.$nova_url_seo.'</loc>
                        <changefreq>weekly</changefreq> 
                    </url>';
            $xml .= '<url> 
                        <loc>https://www.avantorimoveis.com.br/'.$nova_url_seo.'/'.$nova_url_seo_expandida.'</loc>
                        <changefreq>weekly</changefreq> 
                    </url>';
        }
    }
    // echo '<pre>';
    // print_r($arr_imoveis);
    // echo '</pre>';
    if (file_put_contents("jsons/cafeimoveis.json", json_encode($arr_imoveis))) {
        echo 'Arquivo Pesquisa de Imóveis Atualizado!<hr>';
    }
    $xml .= '</urlset>';
    if(file_put_contents('sitemap-imoveis.xml', $xml)){
        echo 'arquivo sitemap alterado<hr>';
    }else{
        echo 'erro no arquivo sitemap - notifique o webmaster<hr>';
    }
    if (file_put_contents("jsons/cafecodigos.json", json_encode($codigosconfere))) {
        echo 'Arquivo Pesquisa de Códigos de Imóveis Atualizado!<hr>';
    }
    if (file_exists('jsons/corretores.json')) {
        if( file_put_contents('jsons/corretores.json', json_encode($json_corretores)) ) {
            echo 'Corretores atualizados com Sucesso!<hr>';
        }else{
            echo 'Houve algo errado, tente novamente mais tarde<hr>';
        }
    } else {
        echo "O arquivo corretores.json não existe<hr>";
    }
    echo '<br>Listagem<hr>';
    echo $imovel_x;
    #############################################################################################################################
    #===========================================================================================================================#
    ####################################################### EDITADO ATÉ AQUI ####################################################
    #===========================================================================================================================#
    #############################################################################################################################

    exit();
endif;