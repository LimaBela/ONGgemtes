<?php
include("protect.php");
protect();

$conexao = mysqli_connect("localhost", "root", "", "assistido");
if (!$conexao) {die("Conexão falhou: " . mysqli_connect_error());} 
$id = isset($_GET['id']) ? intval($_GET['id']) : 0; if ($id <= 0) { echo "ID inválido!"; exit;}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $Nome_Completo = mysqli_real_escape_string($conexao, $_POST['Nome_Completo']);
        $Data_Nascimento = mysqli_real_escape_string($conexao, $_POST['Data_Nascimento']);
        $Idade_Cog = mysqli_real_escape_string($conexao, $_POST['Idade_Cog']);
        $Encaminhamento = mysqli_real_escape_string($conexao, $_POST['Encaminhamento']);
        $Nome_Responsavel = mysqli_real_escape_string($conexao, $_POST['Nome_Responsavel']);
        $Telefone = mysqli_real_escape_string($conexao, $_POST['Telefone']);
        $Grau_Parentesco = mysqli_real_escape_string($conexao, $_POST['Grau_Parentesco']);
        $CPF = mysqli_real_escape_string($conexao, $_POST['CPF']);

        $update_sql = "UPDATE cadastro_do_assistido SET Nome_Completo='$Nome_Completo', Data_Nascimento='$Data_Nascimento', Idade_Cog='$Idade_Cog', 
            Encaminhamento='$Encaminhamento', Nome_Responsavel='$Nome_Responsavel', Telefone='$Telefone', Grau_Parentesco='$Grau_Parentesco', CPF='$CPF' 
            WHERE id=$id";
        if (mysqli_query($conexao, $update_sql)) { echo "Registro atualizado com sucesso!";} else {echo "Erro ao atualizar o registro: " . mysqli_error($conexao);}
        } elseif (isset($_POST['delete'])) {
        $delete_sql = "DELETE FROM cadastro_do_assistido WHERE id=$id";
        if (mysqli_query($conexao, $delete_sql)) {echo "Registro removido com sucesso!"; header("Location: assistidos.php"); exit;
        } else { echo "Erro ao remover o registro: " . mysqli_error($conexao); }
    }
  }
  $sql = "SELECT * FROM cadastro_do_assistido WHERE id=$id";
  $tabela = mysqli_query($conexao, $sql);
  $linha = mysqli_fetch_array($tabela);
  if (!$linha) {  echo "Item não encontrado!"; exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <title>Página no assistido</title>
</head>
<body class="FundoCinza">
  <header class="py-3 mb-3 border-bottom headerTelaInicial">
    <div class="container-fluid d-grid gap-3 align-items-center" style="grid-template-columns: 1fr 2fr">
      <div class="dropdown">
        <a href="./telaInicial.php" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="bi me-2" height="32" src="./Imagens/logoGemtes.png" />
        </a>
        <ul class="dropdown-menu text-small shadow">
          <li><a class="dropdown-item" href="./telaInicial.php">Home</a></li>
          <li><a class="dropdown-item" href="./assistidos.php">Assistidos</a></li>
          <li><a class="dropdown-item" href="./cadastrarAssistido.php">Cadastrar Assistido</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li>
            <a class="dropdown-item" href="./avaliacao.html">Avaliação</a>
          </li>
          <li>
            <a class="dropdown-item" href="./consultas.html">Consultas</a>
          </li>
        </ul>
      </div>

      <div class="d-flex align-items-center">
        <form class="w-100 me-3" role="search">
          <input type="search" class="form-control bordaAzulGemtes" placeholder="Procurar assistido..." aria-label="Search" />
        </form>

        <div class="flex-shrink-0 dropdown">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" alt="mdo" width="25" height="25" class="rounded-circle" fill="#10A1DF" class="bi bi-person" viewBox="0 0 16 16">
              <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
            </svg>
          </a>
          <ul class="dropdown-menu text-small shadow">
            <li>
              <a class="dropdown-item" href="./perfilUsuario.html">Sobre</a>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li><a class="dropdown-item" href="./sair.php">Sair</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <div class="container">
    <form id="assistido-form" method="POST" action="">
      <input type="hidden" name="id" value="<?php echo $linha["id"]; ?>">
      <fieldset>
        <h3>Informações do Assistido</h3>
        <div class="row g-3">
          <div class="mb-3 col-md-6">
            <label for="nome_completo" class="form-label">Nome Completo</label>
            <input type="text" id="nome_completo" name="Nome_Completo" class="form-control" placeholder="Exemplo do nome completo" value="<?php echo htmlspecialchars($linha["Nome_Completo"]); ?>" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
            <input type="date" id="data_nascimento" class="form-control" placeholder="Data de Nascimento" name="Data_Nascimento" value="<?php echo htmlspecialchars($linha["Data_Nascimento"]); ?>" required>
          </div>
        </div>

        <div class="row g-3">
          <div class="mb-3 col-md-6">
            <label for="idade_cog" class="form-label">Idade Cognitiva</label>
            <input type="number" id="idade_cog" class="form-control" placeholder="Idade Cognitiva" name="Idade_Cog" value="<?php echo ($linha["Idade_Cog"] != 0) ? htmlspecialchars($linha["Idade_Cog"]) : ""; ?>">
          </div>
          <div class="mb-3 col-md-6">
            <label for="encaminhamento" class="form-label">Encaminhamento</label>
            <input type="text" id="encaminhamento" class="form-control" placeholder="Encaminhamento" name="Encaminhamento" value="<?php echo ($linha["Encaminhamento"] != 0) ? htmlspecialchars($linha["Encaminhamento"]) : ""; ?>">
          </div>
        </div>

        <h3>Informações do Responsável</h3>
        <div class="row g-3">
          <div class="mb-3 col-md-6">
            <label for="nome_responsavel" class="form-label">Nome Completo</label>
            <input type="text" id="nome_responsavel" class="form-control" placeholder="Exemplo do nome completo" name="Nome_Responsavel" value="<?php echo htmlspecialchars($linha["Nome_Responsavel"]); ?>" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="number" id="telefone" class="form-control" placeholder="Telefone" name="Telefone" value="<?php echo ($linha["Telefone"] != NULL) ? htmlspecialchars($linha["Telefone"]) : ""; ?>">
          </div>
        </div>
        <div class="row g-3">
          <div class="mb-3 col-md-6">
            <label for="grau_parentesco" class="form-label">Grau de Parentesco</label>
            <input type="text" id="grau_parentesco" class="form-control" placeholder="Parentesco" name="Grau_Parentesco" value="<?php echo ($linha["Grau_Parentesco"] != NULL) ? htmlspecialchars($linha["Grau_Parentesco"]) : ""; ?>">
          </div>
          <div class="mb-3 col-md-6">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" id="cpf" class="form-control" placeholder="CPF" name="CPF" value="<?php echo htmlspecialchars($linha["CPF"]); ?>" required>
          </div>
        </div>
        <button type="submit" name="update" class="btn btn-primary azulGemtes bordaAzulGemtes">Editar Cadastro</button>
        <button type="button" id="delete-button" class="btn btn-danger">Remover</button>
        <div class="col-3">
          <button type="button" class="botaoAssistido btn btn-outline-primary textoazulGemtes bordaAzulGemtes">
            <a class="botaoAssistido textoAzulGemtes" href="./assistidos.php">Voltar para Assistidos</a>
          </button>
        </div>
      </fieldset>
    </form>
  </div>

  <script>
    document.getElementById('delete-button').addEventListener('click', function() {
      if (confirm('Tem certeza de que deseja remover este registro?')) {
        const form = document.getElementById('assistido-form');
        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'delete';
        deleteInput.value = '1';
        form.appendChild(deleteInput);
        form.submit();
      }
    });
  </script>
</body>
</html>
