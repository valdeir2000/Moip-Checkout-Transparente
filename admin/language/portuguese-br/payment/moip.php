<?php
/* Heading */
$_['heading_title']         = 'MoIP';
$_['heading_description']   = 'Configuração para pagamentos com o serviço MoIP';

/* Text */
$_['text_payment']          = 'Formas de pagamento'; 
$_['text_success']          = 'Sucesso: Você modificou as configurações do módulo MoIP!';
$_['text_moip']             = '<a onclick="window.open(\'http://www.moip.com.br/\');"><img src="view/image/payment/moip.png" alt="MoIP" title="MoIP" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_enable']           = 'Habilitar';
$_['text_disable']          = 'Desabilitar';
$_['text_all_zones']        = 'Todas as Zonas';
$_['text_yes']              = 'Sim';
$_['text_home']             = 'Página Principal';
$_['text_payment']          = 'Formas de Pagamento';

/* Buttons */
$_['button_adicionar']      = 'Adicionar';
$_['button_remover']        = 'Remover';
$_['button_save']           = 'Salvar';
$_['button_cancel']         = 'Cancelar';
$_['button_enviar']         = 'Enviar';

/* Tabs */
$_['tab_config']            = 'Configurações';
$_['tab_status']            = 'Status de Pagamento';
$_['tab_order']             = 'Área e Ordem';
$_['tab_parcelas']          = 'Parcelas';
$_['tab_boleto']            = 'Boleto';
$_['tab_formasPagamento']   = 'Formas de Pagamento';
$_['tab_committee']         = 'Comissão';
$_['tab_suporte']           = 'Suporte';

/* Entry - Config */
$_['entry_status']          = 'Situação:';
$_['entry_razao']           = 'Razão do pagamento:';
$_['entry_apitoken']        = 'Token:';
$_['entry_apikey']          = 'Key:';
$_['entry_test']            = 'Modo de Teste:';
$_['entry_notify']          = 'Notificar cliente?';
$_['entry_modoParcela']     = 'Exibi as parcelas com:';
$_['entry_valorTotal']      = 'Exibi valor total das parcelas?';
$_['entry_stepFive'] = 'Ocultar Etapa 5:';

/* Entry - Formas de Pagamento */
$_['entry_autorizdo']       = 'Situação Autorizado:';
$_['entry_iniciado']        = 'Situação Iniciado:';
$_['entry_boletoimpresso']  = 'Situação Boleto Impresso:';
$_['entry_concluido']       = 'Situação Concluído:';
$_['entry_cancelado']       = 'Situação Cancelado:';
$_['entry_emanalise']       = 'Situação Em Análise:';
$_['entry_estornado']       = 'Situação Estornado:';
$_['entry_revisao']         = 'Situação Em Revisão:';
$_['entry_reembolsado']     = 'Situação Reembolsado:';

/* Entry - Área e Ordem */
$_['entry_geo_zone']        = 'Zona Geográfica:';
$_['entry_sort_order']      = 'Ordem:';

/* Entry - Parcelas */
$_['entry_parcelaDe']       = 'De';
$_['entry_parcelaPara']     = 'Para';
$_['entry_parcelaJuros']    = 'Juros';

/* Entry - Boleto */
$_['entry_boletoPrazo']     = 'Prazo:';
$_['entry_boletoInstrucao'] = 'Instrução ';
$_['entry_boletoUrlLogo']   = 'Url de sua logo:';

/* Entry - Formas de Pagamento */
$_['entry_cartaoCredito']   = 'Cartão de Crédito:';
$_['entry_boleto']          = 'Boleto:';
$_['entry_debito']          = 'Débito:';

/* Entry - Comissão */
$_['entry_habilitar']       = 'Habilitar: ';
$_['entry_valor']           = 'Valor: ';
$_['entry_fixo']            = 'Fixo';
$_['entry_percentual']      = 'Percentual';
$_['entry_pagadorTaxa']     = 'Responsável pela Taxa MoIP: ';
$_['entry_aLoja']           = 'A Loja';
$_['entry_afiliado']        = 'Afiliado';

/* Entry - Suporte */
$_['entry_suporteAssunto']  = 'Assunto:';
$_['entry_suporteMensagem'] = 'Mensagem:';

/* Help */
$_['help_razao']            = 'Digite a Razão do pagamento que pode ser simplesmente o nome de sua loja.';
$_['help_autorizado']       = 'Situação para identificar um pedido que aguarda resposta do MoIP.';
$_['help_iniciado']         = 'Situação para identificar um pedido que foi iniciado pelo MoIP.';
$_['help_boletoimpresso']   = 'Situação para identificar um pedido tiver o boleto impresso.';
$_['help_concluido']        = 'Situação para identificar um pedido que foi concluído.';
$_['help_cancelado']        = 'Situação para identificar um pedido que foi cancelado.';
$_['help_emanalise']        = 'Situação para identificar um pedido que está em análise no MoIP.';
$_['help_estornado']        = 'Situação para identificar um pedido que foi estornado.';
$_['help_revisao']          = 'Situação para identificar um pedido que está em revisão.';
$_['help_reembolsado']      = 'Situação para identificar um pedido que foi reembolsado.';
$_['help_notify']           = 'Deseja notificar ao cliente quando o status de pagamento for alterado no MOIP?';
$_['help_boletoUrlLogo']    = 'A Imagem deve conter 75px de altura por 40px de largura';
$_['help_stepFive'] = 'Deseja ocultar a etapa 5 (Método de Pagamento) do checkout?';

/* Attention */
$_['attention_suporte']     = 'Aguarde sua mensagem ser enviada.';

/* Success */
$_['success_suporte']       = 'Mensagem enviada com sucesso.';

/* Error */
$_['error_permission']      = 'Atenção: Você não permissão para alterar o módulo MoIP!';
$_['error_razao']           = 'Por favor, digite o nome fantasia de sua loja!!';
$_['erro_test']             = 'Por favor, selecione uma opção!';
$_['erro_notify']           = 'Por favor, selecione uma opção!';
$_['erro_apitoken']         = 'Por favor, digite o código do seu token!';
$_['error_assunto']          = 'Por favor, preencha o assunto!';
$_['error_mensagem']         = 'Por favor, preencha a mensagem!';
?>
