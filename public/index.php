<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSV Processor</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./assets/js/script.js"></script>
</head>

<body>
    <div id="container">
        <h2>CSV Processor</h2>

        <form action="javascript:;" name="form-csv-processor" id="form-csv-processor">
            <span>
                <label for="file_upload" class="csv-style" id="file-name">Clique aqui para selecionar o CSV</label>
                <input type="file" name="file_upload" id="file_upload">
            </span>
            <span>
                <label for="delimiter">Tipo do separador: </label>
                <select name="delimiter" id="delimiter">
                    <option value=",">Vírgula (,)</option>
                    <option value=";">Ponto e vírgula (;)</option>
                </select>
            </span>

            <span><input type="submit" value="Importar" id="importar"></span>
        </form>
        <br>
        <div id="importedData">
            <h3>Produtos Importados</h3>
            <table>
                <thead>
                    <tr>
                        <th><input type='checkbox' class='checkAll'></th>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody id="body-return">

                </tbody>
            </table>
            <div class="copyButton">
                <button class="copyCheckedToClipboard">Copiar selecionados para área de transferência</button>
            </div>
        </div>

    </div>
</body>

</html>