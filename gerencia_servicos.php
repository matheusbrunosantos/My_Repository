<?php 
include_once('bd/conexao.php');

$acao = $_GET['acao'] ?? 'redirect';
//deletar, salvar, alterar

if(isset($_GET['id']) && $acao == 'deletar') {
	$id = $_GET['id'];

	$sql = "DELETE FROM servicos WHERE id = {$id}";
	if(mysqli_query($conexao, $sql));
	$mensagem = 'Excluído com sucesso!';
	$alert = 'success';

	}else {
		$mensagem = 'Erro ao tentar excluir, verifique se o dado não está relacionado com outro registro!';
		$alert = 'danger';


	
	header("Location: servicos.php?mensagem={$mensagem}&alert={alert}");

} if ($acao == 'salvar') {

$codigo = $_POST['codigo'];
$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$categoria = $_POST['categoria'];
	
$sql = "INSERT INTO servicos 
			(codigo, 
			nome, 
			descricao, 
			preco 
			) 
			VALUES
			('$codigo', '$nome', '$descricao', '$preco');";


	mysqli_query($conexao, $sql);

	$mensagem = 'Salvo com sucesso!';

	header("Location: servicos.php?mensagem={$mensagem}&alert=success");

}

?>

