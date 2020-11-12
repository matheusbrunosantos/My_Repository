<?php 
include_once('bd/conexao.php');

//Monta a consulta a ser executada
if (isset($_GET['pesquisa']) && $_GET['pesquisa'] != '') {
  $pesquisa = $_GET['pesquisa'];

  $sql = "SELECT p.*, c.categoria  FROM produtos p 
          LEFT JOIN categoria c ON p.categoria_id = c.id
          WHERE c.tipo = 'Produtos'
          AND (p.codigo LIKE '%{$pesquisa}%'
          OR p.nome LIKE '%{$pesquisa}%'
          OR c.categoria LIKE '%{$pesquisa}%'
          OR p.estoque LIKE '%{$pesquisa}%'
          OR p.data_compra LIKE '%{$pesquisa}%'
          OR p.preco LIKE '%{$pesquisa}%')";

}else {
  $sql = "SELECT p.*, c.categoria 
        FROM produtos p 
        LEFT JOIN categoria c ON p.categoria_id = c.id
        WHERE c.tipo = 'Produtos'";
}

//Execução da consulta ao banco de dados
$qr = mysqli_query($conexao, $sql);

//Armazenando o resultado em uma variável
$produtos = mysqli_fetch_all($qr, MYSQLI_ASSOC);

include_once('layout/header.php');
include_once('layout/menu.php');
include_once('layout/sidebar.php');
?>

<div class="col">
  <h2 class="titulo">Produtos</h2>
  <span class="badge badge-info totais">Total: <span id="total"></span> <?php //echo count($produtos); ?></span>
<div class="clear"></div>

  <?php include_once('layout/mensagens.php'); ?>

  <div class="card">
    <div class="card-body">
      <span id="mensagem"></span>
      <a href="form_produtos.php" class="btn btn-primary" style="float: right">
        <i class="fas fa-cart-plus"></i> Novo Produto
      </a>
      <a href="javascript:history.back(-1)" class="btn btn-secondary voltar">
        <i class="fas fa-arrow-left"></i> Voltar
      </a>
      <br>
      <br>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Estoque</th>
            <th>Data Compra</th>
            <th>Preço</th>
            <th>Ações</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>

      <div class="alert alert-info" id="mensagem-vazio" style="display: none;">Nenhuma Informação encontrada.</div>


       <nav aria-label="Navegação de página exemplo" class="pagination">

        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
        </ul>
      </nav>
      
    </div>
  </div>
</div>
<?php include_once('layout/footer.php'); ?>

<script>
  var algumacoisa
  $(document).ready(function(){
    carregaDados();
  });
  function verDados(id){
    $.ajax({
      url: `api/produtos.php?id=${id}&acao=exibir`
      type: 'GET',
      dataType: 'json'
      beforeSend: function() {
        $('#carregando').fadeIn();
      }
    })
    .done(function(data) {
      var texto = '';
      Object.keys(data.dados).forEach(function(index){
          var th = index.replace('_', ' ');
          texto += `<p><strong style="text-transform: capitalize">${th}</strong>: ${data.dados[index] ?? ''}</p>`; 
      });

      $('#titulo-modal').html('Produtos: ' + data.dados.nome);
      $('#corpo-modal').html(texto);
    })
    .fail(function(){
      alert('Dados não encontrados');
    })
    .always(function(){
      $('#carregando').fadeOut();
    });

  }

  function deletarDados(id) {
    if (confirm('Deseja realmente excluir?')) {
     $.ajax({
          url: 'api/produtos.php?acao=deletar&id=' + id,
          type: 'DELETE',
          dataType: 'json',
          beforeSend: function() {
            $('#carregando').fadeIn();
          }
        })
        .done(function(data) {
          $('#mensagem').html(retornaMensagemAlert(data.mensagem, data.alert));
          carregaDados();
        })
        .fail(function(data) {
          $('#mensagem').html(retornaMensagemAlert(data.mensagem, data.alert));
        })
        .always(function(){
          $('#carregando').fadeOut();
        });
      }

    }
    function carregaDados() {
      $.ajax({
        url: 'api/produtos.php?acao=listar',
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
          $('#carregando').fadeIn();
        }
      })
      .done(function(data) {
        if (data.dados.length < 1) {
          $('#mensagem-vazio').fadeIn();
        }
        var tbody = '';
        $.each(data.dados,function(index, value){
          tbody += `<tr>
                    <td>${value.codigo}</td>
        <td>${value.categoria_id}</td>
        <td>${value.nome}</td>
        <td>${value.preco}</td>
        <td>${value.data_compra}</td>
        <td>${value.estoque}</td>
        <td>${value.usuario_id}</td>
        <td>
          <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#modalVerDados" onclick="verDados(${value.id})">
            <i class="fas fa-eye"></i>
          </a>
          <a href="form_produtos.php?id=${value.id}" class="btn btn-warning">
            <i class="fas fa-edit"></i>
          </a>
           <a href="#" class="btn btn-danger" onclick="deletarDados(${value.id})">
          <i class="fas fa-trash"></i>
          </a>
        </td>
      </tr>`;
        });
        $('tbody').html(tbody);
      })
      .fail(function(data) {
        console.log(data);
      })
      .always(function() {
        $('#carregando').fadeOut();
      });

    }
</script>

</script>