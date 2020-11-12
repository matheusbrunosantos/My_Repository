<?php 
include_once('../bd/conexao.php');

$acao = $_GET['acao'] ?? 'redirect';
//deletar, salvar, alterar
$metodo = $_SERVER['REQUEST_METHOD'];

if(isset($_GET['id']) && $acao == 'deletar' && $metodo == 'DELETE') {
	$id = $_GET['id'];
	if ($id == '' || !is_numeric($id)) {
		$data['mensagem'] = 'ID é obrigatório e deve ser númerico';
		$data['alert'] = 'danger';
		http_response_code(400);
		echo json_encode($data);
		exit;
	}

	$sql = "DELETE FROM produtos WHERE id = {$id}";
	$qr = mysqli_query($conexao, $sql);

	$data['mensagem'] = 'Excluido com sucesso!';
	$data['alert'] = 'success';
	http_response_code(200);
	echo json_encode($data);
	exit;
}if ($acao == 'listar' && $metodo == 'GET') {
	
	$sql = "SELECT p.*, c.categoria 
			FROM produtos p 
			LEFT JOIN categoria c ON c.id = p.categoria_id";
	$qr = mysqli_query($conexao, $sql);
	$produtos = mysqli_fetch_all($qr, MYSQLI_ASSOC);
	$data['mensagem'] = 'Dados carregados com sucesso';
	$data['alert'] = 'success';
	$data['dados'] = $produtos;
	http_response_code(200);
	echo json_encode($data);
	exit;
} else if(isset($_GET['id']) && $_GET['acao'] == 'exibir' && $metodo == 'GET') {
	$id = $_GET['id'];
	if($id == '' || !is_numeric($id)) {
		$data['mensagem'] = 'ID é obrigatório e deve ser númerico';
	    $data['alert'] = 'danger';
		http_response_code(400);
		echo json_encode($data);
		exit;
	}
	$sql = "SELECT p.id, p.codigo, p.nome, p.categoria_id, p.estoque, p.data_compra, usuario_id, p.preco
			FROM produtos p 
			LEFT JOIN categoria c ON c.id = p.categoria_id
			WHERE p.id = {$id}";
	$qr = mysqli_query($conexao, $sql);
	$produto = mysqli_fetch_assoc($qr);
	if ($produto == null) {
	$data['mensagem'] = 'Registro não encontrado';
    $data['alert'] = 'danger';
	http_response_code(400);
	echo json_encode($data);
	exit;
	}

	$data['mensagem'] = 'Dados carregados com sucesso!';
    $data['alert'] = 'success';
    $data['dados'] = $produto;
	http_response_code(200);
	echo json_encode($data);
	exit;

} else if($acao == 'salvar' && $metodo == 'POST') {

	$codigo = $_POST['codigo'];
	$nome = $_POST['nome'];
	$categoria_id = $_POST['categoria_id'];
	$estoque = $_POST['estoque'];
	$data_compra = $_POST['data_compra'];
	$usuario_id = $_POST['usuario_id'];
	$preco = $_POST['preco'];
	$id = $_POST['id'];

	if ($id == '') {
		$sql = "INSERT INTO produtos (codigo, nome, categoria_id, estoque, data_compra,usuario_id, preco) VALUES ('$codigo', '$nome', '$categoria_id', '$estoque', '$data_compra','$usuario_id', '$preco',1);";
	} else {
		$sql = "UPDATE produtos SET 
		              codigo = '{$codigo}',
		              nome = '{$nome}',
		              categoria_id = '{$categoria_id}',
		              estoque = '{$estoque}',
		              data_compra = '{$data_compra}'
		              usuario_id = '{$usuario_id}'
		              preco = '{$preco}'
		              WHERE id = {$id}";
	}

	if(mysqli_query($conexao, $sql)) {
		$mensagem = 'Salvo com sucesso!';
		$alert = 'success';

		if($id == '') {
			$id = mysqli_insert_id($conexao);
		}

	}else {
		$data['mensagem'] = 'Erro ao salvar: ' . mysqli_error($conexao);
	    $data['alert'] = 'danger';
		http_response_code(400);
		echo json_encode($data);
		exit;

		} 

	$sql_dados = "SELECT * FROM produtos WHERE id = " . $id;
	$qr_dados = mysqli_query($conexao, $sql_dados);
	$produto = mysqli_fetch_assoc($qr_dados);

    $data['dados'] = $produto;
	http_response_code(201);
	echo json_encode($data);
	exit;

} else {
	$data['mensagem'] = 'Método não permitido!';
    $data['alert'] = 'danger';
	http_response_code(405);
	echo json_encode($data);
	exit;
}



 ?>