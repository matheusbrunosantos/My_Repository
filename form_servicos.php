<?php 
include_once('layout/header.php');
include_once('layout/menu.php');
include_once('layout/sidebar.php');
 ?>

 <div class="col">
<h2>Novo Serviço</h2>
<?php include_once('layout/mensagens.php'); ?>
      <div class="card">
        <div class="card-body">
         <form action="gerencia_servicos.php?acao=salvar" method="post">
           <div class="row">
             <div class="col-md-3 col-sm-12">
               <div class="form-group">
                 <label for="codigo">Código:</label>
                 <input type="text" name="codigo" id="codigo" class="form-control">
               </div>
             </div>
             <div class="col-md-9 col-sm-12">
               <div class="form-group">
                 <label for="nome">Nome:</label>
                 <input type="text" name="nome" id="nome" class="form-control">
               </div>
             </div>
           </div>
           <div class="row">
             <div class="col-md-4 col-sm-12">
               <div class="form-group">
                 <label for="descricao">Descrição:</label>
                 <input type="text" name="descricao" id="descricao" class="form-control">
               </div>
             </div>
             <div class="col-md-4 col-sm-12">
               <div class="form-group">
                 <label for="preco">Preço:</label>
                 <input type="number" name="preco" id="preco" class="form-control">
               </div>
             </div>
             <div class="col-md-4 col-sm-12">
               <div class="form-group">
                 <label for="categoria">Categoria:</label>
                 <select name="categoria" id="categoria" class="form-control">
                   <option value="">Escolha</option>
                   <?php foreach($categorias as $categoria): ?>
                   <option value="<?php echo $categoria['categoria'] ?>"><?php echo $categoria['categoria'] ?></option>
                  <?php endforeach; ?>
                 </select>
               </div>
             </div>
             <div class="col-md-6 col-sm-12">
               <div class="form-group">
                 <label for="usuario_id">Usuário:</label>
              <input type="text" name="usuario_id" value="1" placeholder="" readonly="">   
           </div>
         </div>
         <div class="col-md-6 col-sm-12">
               <div class="form-group">
                 <label for="categoria_id">Categoria:</label>
               <input type="text" name="categoria_id" value="1" placeholder="" readonly="">
               </div>
               </div>  
           <div class="row">
             <div class="col">
               <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-save"></i> Salvar</button>
             </div>
           </div>

         </form>

        </div>
      </div>
    </div>
 <?php include_once('layout/footer.php');
?>