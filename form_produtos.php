<?php 
include_once('bd/conexao.php');

$sql = "SELECT * FROM categoria WHERE tipo = 'Produtos'";
$qr = mysqli_query($conexao, $sql);
$categorias = mysqli_fetch_all($qr, MYSQLI_ASSOC);

if(isset($_GET['id']) && $_GET['id'] != '') {
  $sql_produto = "SELECT * FROM produtos WHERE id = " . $_GET['id'];
  $qr_produto = mysqli_query($conexao, $sql_produto);
  $produto = mysqli_fetch_assoc($qr_produto);
} else {
  $produto = '';
}

include_once('layout/header.php');
include_once('layout/menu.php');
include_once('layout/sidebar.php');
 ?>

<div class="col">
  <h2>Novo Produto</h2>
  <div class="card">
    <div class="card-body">
      <span id="mensagem"></span>
      <form method="post" onsubmit="return false;">
        <div class="row">
          <div class="col-md-6 col-sm-12 form-group">
            <label for="codigo">Codigo*</label>
            <input type="text" name="codigo" id= "codigo" class="form-control">

            <input type="hidden" name="id" id="id" placeholder="">
          </div>
          <div class="col-md-6 col-sm-12 form-group">
            <label for="categoria_id">Categoría</label>
            <select class="form-control" name="categoria_id" id="categoria_id">
              <option value="">Escolha</option>
              <option value="19">Insumos</option>
              <option value="20">Esterilizador</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-sm-12 form-group">
            <label for="nome">Nome*</label>
            <input type="text" name="nome" class="form-control" id="nome">
          </div>
          <div class="col-md-4 col-sm-12 form-group">
            <label for="preco">Preço*</label>
            <input type="number" step="0.01" min="0.01" name="preco" id="preco" class="form-control">
          </div>
          <div class="col-md-4 col-sm-12 form-group">
            <label for="data_compra">Data de compra</label>
            <input type="date" name="data_compra" class="form-control" id="data_compra" readonly>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-sm-12 form-group">
            <label for="nome">Estoque*</label>
            <input type="number" name="estoque" id="estoque" class="form-control">
              <input type="hidden" name="usuario_id" id="id" class="form-control">   
          </div>
        </div>

        <div class="row">
         <div class="col">
           <button class="btn btn-primary" onclick="salvarDados()">
            <i class="fas fa-save"></i> Salvar</button>
         </div>
          
        </div>
      </form>
        
      </div>
      
    </div>
    
  </div>
<?php 
include_once('layout/footer.php');
 ?>
 <script>
  $(document).ready(function() {
    let procuraParametro = new URLSearchParams(window.location.search);
    if (procuraParametro.has('id') &&
      procuraParametro.get('id') != '') {
    carregaDados(procuraParametro.get('id'));
   }
  })
  function carregaDados(id) {
    $.ajax({
      url: 'api/produtos.php?acao=exibir&id=' + id,
      type: 'GET',
      dataType: 'json',
      beforeSend: function() {
        $('#carregando').fadeIn();
      }
    })
    .done(function(data) {
      $('#id').val(data.dados.id);
      $('#codigo').val(data.dados.codigo);
      $('#categoria_id').val(data.dados.categoria_id);
      $('#nome').val(data.dados.nome);
      $('#preco').val(data.dados.preco);
      $('#data_compra').val(data.dados.data_compra);
      $('#estoque').val(data.dados.estoque);
      $('#usuario_id').val(data.dados.usuario_id);
      $('#mensagem').html(retornaMensagemAlert(data.mensagem, data.alert));
    })
    .fail(function(data) {
      $('#mensagem').html(retornaMensagemAlert(data.responseJSON.mensagem, data.responseJSON.alert));
    })
    .always(function() {
      $('#carregando').fadeOut();
    });

  }
  function salvarDados() {
    var id = $('#id').val();
    var codigo = $('#codigo').val();
    var categoria_id = $('#categoria_id').val();
    var nome = $('#nome').val();
    var preco = $('#preco').val();
    var data_compra = $('#data_compra').val();
    var estoque = $('#estoque').val();
    var usuario_id = $('#usuario_id').val();

    if (codigo == '' || nome == '' || preco == ''
      data_compra == '' || estoque == '') {
      alert('Código, nome,preço, data de compra e estoque são obrigatórios!!');
      $('#codigo').focus();
      return false;
    }

    $.ajax({
      url: 'api/produtos.php?acao=salvar',
      type: 'POST',
      dataType: 'json',
      data: {codigo: codigo, categoria_id: categoria_id, nome: nome, preco: preco, data_compra: data_compra,estoque: estoque, usuario_id:usuario_id, id: id },
      beforeSend: function(){
        $('#carregando').fadeIn();
      }
    })
    .done(function(data) {
      $('#id').val(data.dados.id);
      $('#mensagem').html(retornaMensagemAlert(data.mensagem, data.alert));
      console.log(data);
    })
    .fail(function() {
      $('#mensagem').html(retornaMensagemAlert(data.mensagem, data.alert));
    })
    .always(function(data) {
      $('#carregando').fadeOut();
    });

  }
</script>