<?php 
  include_once('bd/conexao.php');
  include_once('layout/header.php');
  include_once('layout/menu.php');
  include_once('layout/sidebar.php');

if(isset($_GET['pesquisa']) && $_GET['pesquisa'] != '') {
  $pesquisa = $_GET['pesquisa'];

  $sql = "SELECT * FROM fornecedores WHERE fantasia LIKE '%{$pesquisa}%' OR cnpj LIKE '%{$pesquisa}%'";
}else {
$sql = "SELECT * FROM fornecedores";
}



  $qr = mysqli_query($conexao, $sql);
  $fornecedores = mysqli_fetch_all($qr, MYSQLI_ASSOC);
 


?>
         <div class="col">
          <h2 class="titulo">Gestão de fornecedores</h2>
          <span class="badge badge-info totais">Total: <?php echo count($fornecedores); ?></span>
          <div class="clear"></div>

          <?php if(isset($_GET['mensagem'])): ?>
          <div class="alert alert-<?php echo $_GET['alert'] ?? 'success'; ?>" id="alert-mensagem">
         <?php echo $_GET['mensagem']; ?>
         </div>
          <?php endif; ?>

          <div class="card">
            <div class="card-body">
               <a href="form_fornecedores.php" class="btn btn-primary" style="float: right">
                <i class="fas fa-user"></i> Novo Fornecedor
              </a>
              <a href="javascript:history.back(-1)" class="btn btn-secondary voltar">
                <i class="fas fa-arrow-left"></i> Voltar
              </a>
              <br>
              <br>
          <table class="table table-striped table-hover">
            <tr>
              <th>Nome Fantasia</th>
              <th>CNPJ</th>
              <th>Telefone</th>
              <th>E-mail</th>
              <th>Cidade/UF</th>
              <th class="acao">Ações</th>
            </tr>
            <?php 
              $i = 0;
              while($i < count($fornecedores)):
            
            ?>
            <tr>
              <td><?php echo $fornecedores[$i]['razao_social'] ?></td>
              <td><?php echo $fornecedores[$i]['cnpj'] ?></td>
              <td><?php echo $fornecedores[$i]['telefone'] ?></td>
              <td>
                <a href="mailto:<?php echo $fornecedores[$i]['email'] ?>">
                  <?php echo $fornecedores[$i]['email'] ?>
                </a>
              </td>
              <td><?php echo $fornecedores[$i]['cidade'] . '/' . $fornecedores[$i]['estado']  ?></td>

              <td>
                <a href="#" class="btn btn-secondary ver-dados" data-toggle="modal" data-target="#modalVerDados" onclick="verDados(<?php echo $fornecedores[$i]['id']; ?>)" >
                  <i class="fas fa-eye"></i>
                </a>
                <a href="form_fornecedores.php?id=<?php echo $fornecedores[$i]['id']; ?>" class="btn btn-warning">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="gerencia_fornecedores.php?id=<?php echo $fornecedores[$i]['id']; ?>&acao=deletar" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir?')">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php
            $i++;
            endwhile; 
          ?>
            
          </table>
          <?php if(empty($fornecedores)): ?>
            <div class="alert alert-info">Nenhuma informação encontrada.</div>
          <?php endif; ?>
        </div>
          <nav aria-label="Navegação de página exemplo">
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
      </div>

<?php 
include_once('layout/footer.php');
?>

<script>
  function verDados(id) {
    $.ajax({
      url: 'gerencia_fornecedores.php?acao=get&id=' + id,
      type: 'GET',
      beforeSend: function() {
        $('#carregando').fadeIn();
      }
    })
    .done(function(dados) {
      var dados_json = JSON.parse(dados);
      var tabela = `<table>`;
      var texto = '';
      Object.keys(dados_json).forEach(function(k){
          var th = k.replace('_', ' ');
          texto += `<p><strong style="text-transform: capitalize">${th}</strong>: ${dados_json[k] ?? ''}</p>`;
      });
      $('#titulo-modal').html('Fornecedor: ' + dados_json.razao_social);
      $('#corpo-modal').html(texto);
    })
    .fail(function() {
      alert('Informações não encontradas.');
    })
    .always(function() {
      $('#carregando').fadeOut();
    });
    
  }
</script>