$(document).ready(function () {
  function validationException(message, success = false) {
    let contextTitle = "Erro!";
    let contextIcon = "error";

    if (success === true) {
      contextTitle = "Sucesso!";
      contextIcon = "success";
    }

    Swal.fire({
      title: contextTitle,
      text: message,
      icon: contextIcon,
      confirmButtonText: "Ok",
    });
  }

  function hasNegativePrice(negativePrice) {
    return negativePrice ? 'class="redBackground"' : "";
  }

  function mustShowCopyButton(product) {
    if (product.showCopyButton) {
      delete product.showCopyButton;

      let showCopyButton = `<button class="copyRow" name="${product.nome}" price="${product.preco}" codigo-produto="${product.codigo}">Copiar</button>`;

      return showCopyButton;
    }

    return "";
  }

  function loadTable(products) {
    products.forEach((product) => {
      let negativePrice = hasNegativePrice(product.negativePrice);
      delete product.negativePrice;

      let showCopyButton = mustShowCopyButton(product);

      $("#body-return").append(`
          <tr ${negativePrice}>
              <td class="centered slim">${
                showCopyButton
                  ? "<input type='checkbox' class='checkedToCopy'>"
                  : ""
              }</td>
              <td class="centered" name="product">${product["codigo"]}</td>
              <td>${product["nome"]}</td>
              <td class="rightered">${product["preco"]}</td>
              <td class="centered slim">${showCopyButton}
              </td>
          </tr>
      `);
    });
  }

  function submitFormData(entity) {
    let formData = new FormData();
    formData.append("file_upload", $("#file_upload")[0].files[0]);
    formData.append("delimiter", $("#delimiter").val());

    $.ajax({
      url: "api.php",
      method: "POST",
      data: new FormData(entity),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const obj = JSON.parse(data);

        if (obj.success) {
          $("#importedData").show();
          $("#body-return").html("");

          loadTable(obj.products);
        }

        if (
          obj.typeException == "InvalidArgumentException" ||
          obj.typeException == "RuntimeException"
        ) {
          validationException(obj.message, "error");
        }
      },
    });
  }

  $("#form-csv-processor").submit(function (e) {
    e.preventDefault();
    submitFormData(this);
  });

  $("#file_upload").change(function () {
    $("#importedData").hide();
    var fileName =
      $(this).prop("files").length > 0
        ? $(this).prop("files")[0].name
        : "Nenhum arquivo selecionado";
    $("#file-name").html(fileName);
  });

  $(document).on("click", ".checkAll", function () {
    const isChecked = $(".checkedToCopy").prop("checked");

    $(".checkedToCopy").prop("checked", !isChecked);
  });

  $(document).on("click", ".copyCheckedToClipboard", function () {
    if ($(".checkedToCopy:checked").length > 0) {
      const produtos = [];
      $(".checkedToCopy:checked").each(function name() {
        let row = $(this).closest("tr").find("td:last-child").children();
        let produto = {
          nome: row.attr("name"),
          preco: row.attr("price"),
          codigo: row.attr("codigo-produto"),
        };
        produtos.push(produto);
      });

      navigator.clipboard.writeText(JSON.stringify(produtos));
      validationException("Copiado para área de transferência", true);

      return;
    }

    alert("Marque ao menos um elemento para copiar");
    return false;
  });

  $(document).on("click", ".copyRow", function () {
    const produto = {
      nome: $(this).attr("name"),
      preco: $(this).attr("price"),
      codigo: $(this).attr("codigo-produto"),
    };

    navigator.clipboard.writeText(JSON.stringify(produto));

    validationException("Copiado para área de transferência", true);
  });
});
