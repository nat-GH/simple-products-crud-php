<?php

require_once 'controller/listAll.php';
require_once 'config.php';

$products = listAll();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CRUD Produtos</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
</head>

<body>
  <div class="container mt-5">
    <div class="mb-3 d-flex justify-content-end">
      <button class="btn btn btn-primary" data-toggle="modal" data-target="#modalCreate" type="button">Novo Produto</button>
    </div>
    <table id="products-table" class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th scope="col">id</th>
          <th scope="col">Produto</th>
          <th scope="col">Valor</th>
          <th scope="col">Data Cadastro</th>
          <th scope="col">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product) : ?>
          <tr id="product-<?= $product['id'] ?>">
            <th scope="row"><?= $product['id'] ?></th>
            <th class="product-name" scope="row"><?= $product['produto'] ?></th>
            <th class="product-value" scope="row">R$ <?= number_format($product['valor'], 2, ',', '.') ?></th>
            <th scope="row"><?= date('d/m/Y', strtotime($product['dataCadastro'])) ?></th>
            <td>
              <button class="btn btn-sm btn-success btn-view" data-product='<?= json_encode($product) ?>' data-toggle="modal" data-target="#modalView" type="button">Visualizar</button>
              <button class="btn btn-sm btn-warning btn-edit" data-product='<?= json_encode($product) ?>' data-toggle="modal" data-target="#modalEdit" type="button">Editar</button>
              <button class="btn btn-sm btn-danger" data-product-id="<?= $product['id'] ?>" data-toggle="modal" data-target="#modalDelete" type="button">Excluir</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalViewLabel">Produto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body"></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCreateLabel">Novo Produto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label>Nome do Produto</label>
                <input class="form-control" type="text" name="produto" placeholder="Digite o nome do produto" />
              </div>
              <div class="form-group">
                <label>Valor</label>
                <input class="form-control" type="number" name="valor" placeholder="Digite o valor do produto" />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button id="btnConfirmCreate" type="button" class="btn btn-success">Salvar produto</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditLabel">Editar Produto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label>Nome do Produto</label>
                <input class="form-control" type="text" name="produto" placeholder="Digite o nome do produto" />
              </div>
              <div class="form-group">
                <label>Valor</label>
                <input class="form-control" type="number" name="valor" placeholder="Digite o valor do produto" />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button id="btnConfirmEdit" type="button" class="btn btn-success">Salvar mudanças</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDeleteLabel">Deletar Produto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4>Deseja realmente excluir este produto?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button id="btnConfirmDelete" type="button" class="btn btn-danger">Excluir</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="index.js"></script>
</body>

</html>