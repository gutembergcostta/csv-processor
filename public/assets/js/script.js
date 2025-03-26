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
        console.log(data);
        $("#retorno").html(data);
      },
    });
  });

  $("#csv_file").change(function () {
    var fileName =
      $(this).prop("files").length > 0
        ? $(this).prop("files")[0].name
        : "Nenhum arquivo selecionado";
    $("#file-name").html(fileName);
  });
});

function copyToClipboard(product) {
  navigator.clipboard.writeText(JSON.stringify(product));
  alert("Copiado para área de transferência!");
}
