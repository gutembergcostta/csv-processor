$(document).ready(function () {
  $("#form-csv-processor").submit(function (e) {
    e.preventDefault();

    let formData = new FormData();
    formData.append("csv_file", $("#csv_file")[0].files[0]);
    formData.append("delimiter", $("#delimiter").val());

    $.ajax({
      url: "api.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const obj = JSON.parse(data);

        if (obj.success) {
          $("#importedData").show();
          $("#body-return").html("");
          const products = obj.products;

          products.forEach((product) => {
            let negativePrice = product.negativePrice
              ? 'class="redBackground"'
              : "";

            delete product.negativePrice;

            if (product.showCopyButton) {
              delete product.showCopyButton;

              showCopyButton = `<button class="copyRow" json-product='${JSON.stringify(
                product
              )}'>Copiar</button>`;
            } else {
              showCopyButton = "";
            }

            $("#body-return").append(`
                <tr ${negativePrice}>
                    <td class="centered slim">${
                      showCopyButton
                        ? "<input type='checkbox' class='checkedToCopy'>"
                        : ""
                    }</td>
                    <td class="centered" name="product">${
                      product["codigo"]
                    }</td>
                    <td>${product["nome"]}</td>
                    <td class="rightered">${product["preco"]}</td>
                    <td class="centered">${showCopyButton}
                    </td>
                </tr>
            `);
          });
        }
      },
    });
  });

  $("#csv_file").change(function () {
    $("#importedData").hide();
    var fileName =
      $(this).prop("files").length > 0
        ? $(this).prop("files")[0].name
        : "Nenhum arquivo selecionado";
    $("#file-name").html(fileName);
  });

  $(document).on("click", ".copyRow", function () {
    navigator.clipboard.writeText($(this).attr("data-json-product"));

    alert("Copiado para área de transferência");
  });
});
