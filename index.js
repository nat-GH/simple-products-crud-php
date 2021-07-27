const productsTable = $('#products-table');

// Delete Product
let productId = null;
const modalDelete = $("#modalDelete");

modalDelete.on('show.bs.modal', e => {
    productId = $(e.relatedTarget).data('product-id');
});

$("#btnConfirmDelete").on('click', () => {
    const data = new FormData();
    data.append('produtoId', productId);

    $.ajax({
        method: "POST",
        url: "controller/delete.php",
        data,
        processData: false,
        contentType: false,
        success: function (data) {
            productsTable.find(`tr#product-${productId}`).first().remove();
            modalDelete.modal('hide');
        },
        error: function (error) {
            if (error.status === 422) {
                alert('É necessário informar o ID do produto!')
            } else {
                alert('Falha ao deletar produto!');
            }
            console.error(error)
        }
    });
});

// View Product
$("#modalView").on('show.bs.modal', e => {
    const modalViewBody = $(e.target).find('.modal-body').first();
    let product = $(e.relatedTarget).data('product');
    product = typeof product === 'string' ? JSON.parse(product) : product;
    const dateObject = new Date(product.dataCadastro);
    const formattedDate = dateObject instanceof Date && !isNaN(dateObject) ? dateObject.toLocaleDateString('pt-BR') : product.dataCadastro;
    const modalViewBodyHtml = `
        <div class="row">
            <div class="col-6">
                <h6>ID</h6>
                <p>${product.id}</p>
                <h6>Nome do Produto</h6>
                <p>${product.produto}</p>
            </div>            
            <div class="col-6">
                <h6>Valor</h6>
                <p>${parseFloat(product.valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</p>
                <h6>Data de Cadastro</h6>
                <p>${formattedDate}</p>
            </div>
        </div>
    `;

    modalViewBody.html(modalViewBodyHtml);
});

// Edit Product
const modalEdit = $("#modalEdit");
let product = null;

modalEdit.on('show.bs.modal', e => {
    product = $(e.relatedTarget).data('product');
    product = typeof product === 'string' ? JSON.parse(product) : product;
    const modalEditValueField = $(e.target).find('input[name="valor"]:first');
    const modalEditProductField = $(e.target).find('input[name="produto"]:first');

    $(modalEditProductField).val(product.produto);
    $(modalEditValueField).val(product.valor);
});

$("#btnConfirmEdit").on('click', () => {
    const modalEditForm = modalEdit.find('form')[0];
    const data = new FormData(modalEditForm);
    const formattedNewProductValue = parseFloat(data.get('valor')).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
    const newProductName = data.get('produto');
    data.append('produtoId', product.id);

    product.valor = data.get('valor');
    product.produto = data.get('produto');

    $.ajax({
        method: "POST",
        url: "controller/update.php",
        data,
        processData: false,
        contentType: false,
        success: function () {
            const productRow = productsTable.find(`tr#product-${product.id}`).first();
            productRow.find('th.product-name').html(newProductName);
            productRow.find('th.product-value').html(formattedNewProductValue);
            productRow.find('.btn-edit:first').data('product', JSON.stringify(product));
            productRow.find('.btn-view:first').data('product', JSON.stringify(product));
            modalEdit.modal('hide');
        },
        error: function (error) {
            if (error.status === 422) {
                alert('É necessário informar todos os campos do produto!')
            } else {
                alert('Falha ao editar produto!');
            }
            console.error(error)
        }
    });
});

// Create Product
const modalCreate = $("#modalCreate");

$("#btnConfirmCreate").on('click', () => {
    const modalCreateForm = modalCreate.find('form')[0];
    const data = new FormData(modalCreateForm);
    const newProductName = data.get('produto');
    const newProductValue = data.get('valor');

    $.ajax({
        method: "POST",
        url: "controller/create.php",
        data,
        processData: false,
        contentType: false,
        success: function (data) {
            const newProduct = {
                id: data,
                valor: newProductValue,
                produto: newProductName,
                dataCadastro: new Date().toLocaleDateString('pt-BR'),
            };
            const formattedNewProductValue = parseFloat(newProduct.valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })
            const newProductRowHtml = `
                <tr id="product-${newProduct.id}">
                    <th scope="row">${newProduct.id}</th>
                    <th class="product-name" scope="row">${newProduct.produto}</th>
                    <th class="product-value" scope="row">${formattedNewProductValue}</th>
                    <th scope="row">${newProduct.dataCadastro}</th>
                    <td>
                        <button class="btn btn-sm btn-success btn-view" data-product='${JSON.stringify(newProduct)}' data-toggle="modal" data-target="#modalView" type="button">Visualizar</button>
                        <button class="btn btn-sm btn-warning btn-edit" data-product='${JSON.stringify(newProduct)}' data-toggle="modal" data-target="#modalEdit" type="button">Editar</button>
                        <button class="btn btn-sm btn-danger" data-product-id="${newProduct.id}" data-toggle="modal" data-target="#modalDelete" type="button">Excluir</button>
                    </td>
                </tr>
            `;
            productsTable.find('tbody:first').append(newProductRowHtml);
            modalCreate.modal('hide');
        },
        error: function (error) {
            if (error.status === 422) {
                alert('É necessário informar todos os campos do produto!')
            } else {
                alert('Falha ao cadastrar produto!');
            }
            console.error(error)
        }
    });
});