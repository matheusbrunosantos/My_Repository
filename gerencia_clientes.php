<?php
include_once('bd/conexao.php');

$acao = $_GET['acao'] ?? 'redirect';
//deletar, salvar, alterar

if(isset($_GET['id']) && $acao == 'deletar'){
	$id = $_GET['id'];

	$sql = "DELETE FROM clientes WHERE id = {$id}";

	$qr = mysqli_query($conexao, $sql);

	if($qr){
		$mensagem = 'Excluído com sucesso';
		$alert = 'success';
	}else{
		$mensagem = 'Erro ao tentar excluir, verifique se o dado não esta relacionado com outro usuário!';
		$alert = 'danger';
	}

	header("Location: clientes.php?mensagem={$mensagem}&alert={$alert}");

}else if($acao == 'salvar') {

	$nome = $_POST['nome'];
	$cpf = $_POST['cpf'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$convenio = $_POST['convenio'];
	$num_convenio = $_POST['num_convenio'];
	$logradouro = $_POST['logradouro'];
	$numero = $_POST['numero'];
	$complemento = $_POST['complemento'];
	$bairro = $_POST['bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$usuario_id = $_POST['usuario_id'];
	$cep = $_POST['cep'];

	if($nome == '' || $cpf == '' || $email == ''){

		$mensagem = "Nome, CPF e Email são obrigatórios";

		header("Location: form_cliente.php?mensagem=}$mensagem}&alert=danger");
		exit;
	}

	$sql = "INSERT INTO clientes 
			(nome,
			cpf,
			email,
			telefone,
			convenio,
			num_convenio,
			logradouro,
			complemento,
			numero,
			bairro,
			cidade,
			estado,
			usuario_id,
			cep) VALUES ('$nome','$cpf','$email','$telefone','$convenio','$num_convenio','$logradouro','$complemento','$numero','$bairro','$cidade','$estado','$usuario_id','$cep');";

			//echo $sql; exit;

	mysqli_query($conexao, $sql);

	$mensagem = 'Salvo com sucesso!';

	header("Location: clientes.php?mensagem={$mensagem}&alert=success");
}


?>