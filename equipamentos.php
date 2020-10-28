<?php 
include_once('layout/header.php');
include_once('layout/menu.php');
include_once('layout/sidebar.php');
include_once('bd/conexao.php');

$sql = "SELECT * FROM produtos";
  $qr = mysqli_query($conexao, $sql);
  $produtos = mysqli_fetch_all($qr, MYSQLI_ASSOC);
?>
<div class="col">
  <h2 class="titulo">Equipamentos</h2>
  <span class="badge badge-info totais">Total: <?php echo count($produtos); ?></span>
  <div class="clear"></div>
  <?php include_once('layout/mensagens.php'); ?>

  <div class="card">
    <div class="card-body">
      <a href="form_equipamentos.php" class="btn btn-primary" style="float: right">
        <i class="fas fa-cart-plus"></i> Novo equipamentos
      </a>
      <a href="javascript:history.back(-1)" class="btn btn-secondary voltar">
        <i class="fas fa-arrow-left"></i> Voltar
      </a>
      <br />
      <br />
      <table class="table table-striped table-hover">
          <tr>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Data de Compra</th>
            <th>Código</th>
            <th class="acao">Ação</th>
          </tr>
          <?php foreach ($produtos as $key => $produto): ?>
          <tr>
            <td><?= $produto['nome'] ?></td>
            <td><?= (isset($produto['categoria_id']) ? $produto['categoria_id'] : 'Não definida') ?></td>
            <td><?= $produto['data_compra'] ?? 'Não informada' ?></td>
            <td><?= $produto['id'] ?></td>
            <td>
              <a href="#" class="btn btn-secondary">
                <i class="fas fa-eye"></i>
              </a>
              <a href="#" class="btn btn-warning">
                <i class="fas fa-edit"></i>
              </a>
              <a href="gerencia_equipamentos.php?id=<?php echo $produto['id']; ?>&acao=deletar" class="btn btn-danger" onclick="return confirm('Deseja realmente excluir?')">
                <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>

      </table>
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
<?php 
  include_once('layout/footer.php');
?>