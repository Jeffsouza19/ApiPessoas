<h1>Olá!</h1>

Esta é uma api para armazenar dados de usuarios, ela consome uma segunda api (https://github.com/Jeffsouza19/ApiCidades), para utiliza-la sem o consumo da segunda api, no controller <strong>PessoaController.php</strong>, deve comentar a parte do codigo "buscando dados da cidade", e tambem alterar a variavel $idcidade para $cidade.


<h3>BD</h3>
Para criar o banco de dados basta rodar a migrate disponivel.
<strong>php artisan migrate</strong>
<h5>Importante</h5>
Caso opte por nao usar a segunda API deve descomentar parte do codigo na migrate, que trata sobre as tabelas 'tb_cidades' e 'tb_estados'.


<h3>Segunda API</h3>

Na utilizaçao da segunda api, deve-se observar se o endereço da api esta correto.
Feito teste em localhost, rodando a segunda api na porta 9000, sendo o endereço -> http://localhost:9000/api/'rota'

Na documentaçao da segunda api tem todas rotas que podem ser utlizadas

<h3>Rotas</h3>

Esta api possui somente duas rotas,

uma rota com metodo POST -> para coletar dados de usuarios - .../api/pesssoa
a segunda com metodo GET -> para listar os usuarios - .../api/pessoas
A listagem dos usuarios possui paginação, mostrando os 10 primeiros itens




<h4>Obs.:</h4>
As duas Api's estão Consumindo o mesmo banco de dados.
