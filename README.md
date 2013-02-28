* [O que é o projeto](#o-que-%C3%A9-o-projeto)
* [Requisitos](#requisitos)
* [Instalação](#instala%C3%A7%C3%A3o)
* [Changelog](#changelog)
* [Atualização](#atualiza%C3%A7%C3%A3o-da-vers%C3%A3o-free-para-vers%C3%A3o-pro)
* [Token e Key](#token-e-key-de-produ%C3%A7%C3%A3o)
* [Configuração Básica](#configura%C3%A7%C3%A3o-b%C3%A1sica)
* [Parcelas](#parcelas)
* [Desinstalação](#desinstala%C3%A7%C3%A3o)
* [Para Outras Versões](#para-outras-versoes)

### O que é o projeto.
O projeto "MOIP Transparente", foi criado para facilitar a compra para o usuário final. O projeto quando instalado tem a função de tornar a compra mais fácil pois ele 'elimina' o famoso 'redirecionamento'.
Vantagens
Pagamento feito totalmente em seu e-commerce ou site
O cliente fica no ambiente do seu e-commerce ou site durante todo o processo de compra, sem necessidade de cadastro ou páginas intermediárias de pagamento.

### Compra por 1 clique
Na primeira compra, você poderá optar por salvar os dados do cartão de crédito do seu cliente. Com isso, o cliente poderá comprar novamente em seu e-commerce ou site sem precisar digitar todos os dados de pagamento. Esta funcionalidade torna o processo de compra muito mais simples e rápido.

### Aumento de conversão de suas vendas
Você pode ter um aumento de até 30% na conversão de suas vendas, uma vez que, o número de etapas do seu checkout será reduzido e seus clientes não serão direcionados para páginas externas ao seu e-commerce ou site.

### Segurança de dados feita pelo Moip
Os dados de pagamento dos seus clientes são direcionados diretamente do navegador para o Moip. Sem passar por seus servidores, assim não precisa se preocupar com a segurança destas informações.

### Requisitos
* **OpenCart:** 1.5.1, 1.5.1.3, 1.5.2.1, 1.5.3, 1.5.3.1, 1.5.4, 1.5.4.1, 1.5.5.1
* **VQmod:** Sim
* **jQuery:** 1.7 ou superior
* **ColorBox:** Sim

### Changelog
- Remoção da etapa 5 do checkout (Métodos de Pagamento)
- Correção da página Admin > MoIP > MoIP

### Instalação
1. Extraia o arquivo moip.zip no seu computador.
2. Copie as pastas "admin", "catalog", "image", "valdeir", "vqmod", "system" e o arquivo "retorno_moip.php" para a raiz de sua loja.
3. Acesse [http://www.SEUDOMINIO.com.br/valdeir/moip/](javascript:void(0).
4. Clique em Instalar
5. Faça seu login com o usuário e senha do admin.
6. Preencha todos os dados

### Atualização da versão Free para versão Pro
* 1 - Extraia o arquivo moip.zip no seu computador.
* 2 - Copie as pastas "admin", "catalog", "image", "valdeir", "system" e o arquivo "retorno_moip.php" para a raiz de sua loja.
* 3 - Acesse [http://www.SEUDOMINIO.com.br/valdeir/moip/](javascript:void(0).
* 4 - Clique em atualizar.
* 5 - Faça seu login com o usuário e senha do admin.
* 6 - Acesse [http://www.SEUDOMINIO.com.br/valdeir/moip/](javascript:void(0).
* 7 - Clique em Instalar
* 8 - Faça seu login com o usuário e senha do admin.
* 9 - Preencha todos os dados

### Token e Key de Produção
Para receber o Token e Key de produção, seu site deverá ser homologado pela equipe do MoiP para isso basta acessar:
* 1 - Acesse [https://www.moip.com.br/](javascript:void(0))
* 2 - Entre em contato com o MoiP pedindo o Token e Key de produção (Informe seu login MoiP e a url de sua aplicação)
* 3 - Depois da homologação você receberá um email informando seu Token e sua Key de produção
* 4 - Depois desse processo seu site estraá apto para utilizar o Checkout transparente.

### Token e Key de Teste
Para receber o Token e Key de produção, seu site deverá ser homologado pela equipe do MoiP para isso basta se cadastrar no site:
* 1 - [http://labs.moip.com.br/login](javascript:void(0)).
* 2 - Depois de cadastrado, faça seu login.
* 3 - Acesse o menu Ferramentas > API MoiP > Chaves de Acesso.

### Retorno Automático
Para seu cliente receber a notificação do status de pagamento automáticamente é necessário casdastrar sua url de retorno automático, para isso basta acessar:
* 1 - [https://www.moip.com.br/](javascript:void(0))
* 2 - Ir no menu Meus Dados > Preferências > Notificação das transações
* 3 - Marcar a opção Receber notificação instantânea de transação
* 4 - Cadastar sua url em URL de notificação (ex: http://www.SEUDOMINIO.com.br/retorno_moip.php).
* 5 - Clicar em Confirmar Alterações.

### Configuração Básica.
* **Status -** Opção para habilitar ou desabilitar o módulo de pagamento.
* **Razão do Pagamento -** Nome da sua empresa/loja virtual, será exibido nos detalhes do pagamento no site do MoiP.
* **Token - ** Chave para poder ter liberação do módulo (Como receber o Token).
* **Key -** Chave para poder ter liberação do módulo (Como receber a Key).
* **Modo de Teste -** Coloca o módulo em teste ou em produção. (Para o módulo entrar em modo de produção é nescessário o Token e a Key).
* **Notificar Cliente -** Notifica o cliente automáticamente quando o status do pagamento for alterado no site do MoiP.
* **Status Autorizado -** Status quando o pagamento for autorizado pelo MoiP.
* **Status Iniciado -** Status quando o pagamento for iniciado pelo MoiP.
* **Status Boleto Impresso -** Status quando o boleto for impresso.
* **Status Completo -** Status quando o pagamento estiver completo.
* **Status Cancelado -** Status quando o pagamento for cancelado.
* **Status Em Análise -** Status quando o pagamento estiver em análise.
* **Status Invertida -** Status quando o pagamento estiver invertido.
* **Status Em Revisão -** Status quando o pagamento estiver em revisão.
* **Status Reembolsado** - Status quando o pagamento for reembolsado.
* **Área Geográfica -** Área Geográfica onde o pagamento via MoiP for aceito. (O MoiP só aceita da região brasileira), portanto não se não tiver essa opção, crie.
* **Ordem -** Ordem em que o pagamento via MoiP ira aparecer na forma de pagamento quando o cliente estiver finalizando a compra.

### Parcelas
O módulo Moip Checkout Transparente Pro oferece total flexibilidade e transparência para você configurar as suas regras de parcelamento de acordo com a estratégia e necessidade do seu negócio.
Para aceitar um pagamento parcelado com cartão de crédito você deverá acessar:
* 1 - Acesse [http://www.SEUDOMINIO.com.br/admin/](javascript:void(0)
* 2 - Acessar o menu Extensões > Pagamento > Clique em editar ao lado de MoIP > Logo após isso selecione a opção Parcelas (ao lado esquerdo)
* 3 - Clique em Adicionar e define os valores de "De*", "Para**" e "Juros***"

_*O número mínimo da parcela_
_**O número máximo da parcela_
_***Quantidade de juros para aquele "grupo" de parcelas, OBS: O valor deverá ser por exemplo 1.99 | 2.66 | 7.43 ou true _

Nas configurações de parcelamento você pode informar que deseja repassar a taxa de antecipação do parcelamento ao seu comprador, garantindo assim que vai receber o mesmo valor líquido do que em uma transação à vista, para isso basta usar true em juros. 

Se desejar cobrar uma taxa adicional pela compra parcelada, mas não necessariamente para cobrir a sua taxa de antecipação de parcelamento, você pode definir a taxa de juros para seu comprador em percentual com base na tabela price (amortização dos juros em parcelas iguais). 

Para não cobrar valor adicional do seu comprador (oferecer preços como "2 vezes sem juros"), basta informar o valor de juros para 0.00 

_**Importante:**_ tome cuidado para não informar configurações de parcelamento conflitantes. Caso aconteça, trataremos o conflito da seguinte forma:
A configuração que aceitar a menor quantidade mínima de parcelas prevalece sobre as demais. Exemplo: se enviar uma configuração de "2 a 7 parcelas" e outra de "7 a 12", uma compra em 7 parcelas seguirá as configurações de "2 a 7".

Se a quantidade mínima de parcelas for igual em mais de uma configuração, prevalecerá a configuração com a menor quantidade máxima de parcelas. Exemplo: uma configuração de "2 a 7" prevalece sobre a configuração de uma de "2 a 12". Uma compra em 6 vezes vai usar a configuração de "2 a 7" em vez de "2 a 12" (mas uma compra em 8 vezes vai usar a configuração "2 a 12" normalmente)

Se houver duas configurações com quantidade de parcelas iguais, o sistema vai configurar aleatoriamente, garantindo que não haja erro na transação.

### Desinstalação.
* 1 - Acesse: [http://www.SEUDOMINIO.com.br/valdeir/moip/](javascript:void(0).
* 2 - Clique em Desinstalar.
* 3 - Faça seu login.
* 4 - Confirme que deseja desinstalar o módulo.
* 5 - Pronto! O Módulo foi desinstalado com sucesso.

### Para Outras Versoes
[Acessar](https://www.dropbox.com/sh/l4u1y4t292agk3n/WtpXcc3vO8)

Agradecimentos.
Muito Obrigado a todos.
