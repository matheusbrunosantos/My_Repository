<?php 
  include_once('layout/header.php');
  include_once('layout/menu.php'); 
  include_once('layout/sidebar.php'); 
?>

  <div class="col">
    Conteúdo gerado no dia <?php echo date('d/m/Y H:i') ?>
    <br>
    <?php 
    echo '<pre>';
      foreach ($itens_menu as $menu) {
        echo '<i class="fas fa-' . $menu['icon'] . '"></i> ';
        echo $menu['item'];
        echo ': ';
        echo '<br>';
          
        foreach($menu['opcoes'] as $subitem) {
            echo ' --- ';
            echo '<a href="' . $subitem['link'] . '" title="">' . $subitem['nome'] . '</a>';
            echo '<br>';
        }

        echo '<br>';
      }
     ?>

  </div>
        
<?php include_once('layout/footer.php'); ?>