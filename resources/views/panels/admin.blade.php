<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Управление товарами</title>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/homepage.css">
    <link rel="stylesheet" href="/css/main_colors.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome-ie7.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css"
          href="//cdn.datatables.net/v/bs4-4.1.1/dt-1.10.23/b-1.6.5/datatables.min.css"/>
    <link rel="stylesheet" href="/css/panel.css">
    <link rel="stylesheet" href="/css/main_colors.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="block-light">
@include('panels.panel_header')

<!-- Main -->

<div class="block-light">
    <div class="block-header">
        <div class="block-header-text">
            <span class="fas fa-box light"></span>
            <span class="header-text light">Управление товарами</span>
        </div>
        <hr class="header-delimiter bg-light">
    </div>
    <div class="block-body">

        <!-- Modal -->

        <div class="modal fade" id="productEditorModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
             aria-labelledby="productEditorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productEditorModalLabel">Создать новый товар</h5>
                    </div>
                    <div class="modal-body">
                        <label for="productName">Название товара</label>
                        <input type="text" class="form-control green-input-border"
                               id="productName" aria-describedby="productNameHelp">
                        <small id="productNameHelp" class="form-text text-muted"></small>
                        <label for="descriptionEditor">Описание товара</label>
                        <textarea name="descriptionEditor"></textarea>
                        <label id="fileInputLabel" class="modal-label">Изображение товара</label>
                        <div class="input-group mb-3 input-file">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input green-input-border" id="fileInput"
                                       accept="image/bmp,image/png,image/jpg,image/jpeg">
                                <label class="custom-file-label text-muted" id="inputtedFileName" for="fileInput">
                                    Выберите файл
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <small class="error-text"></small>
                        <div class="modal-buttons">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="button" class="btn btn-primary submit-button" id="submitProductButton">
                                Создать
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End of editor modal -->

        <div class="datatable">
            <table id="products" class="table table-striped table-bordered centered-table">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>id</th>
                    <th>Название</th>
                    <th>Фото</th>
                    <th>Ссылка</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- show photo modal -->

<div class="modal fade" id="photoModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="productEditorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PhotoModalLabel">Фотография товара</h5>
            </div>
            <div class="modal-body d-flex justify-content-center align-items-center">
                <img class="product-photo" id="productPhoto" alt="Фотография товара" src="">
            </div>
            <div class="modal-footer">
                <div class="modal-buttons">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End of show photo modal -->

<!-- Scripts -->

<script src="//kit.fontawesome.com/22adceb6fe.js" crossorigin="anonymous"></script>
<script
    src="//code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/2.3.6/plupload.full.min.js"
        integrity="sha512-2I/HALGXULhv/y2AKXxWm8sQBIEB444qgzg4g3FhjE6312m5sHXySdBhdfx1sddbwPg9eHKmZy/ExR49uM5N7w=="
        crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.23/b-1.6.5/datatables.min.js"></script>
<script src="https://cdn.ckeditor.com/4.15.1/basic/ckeditor.js"></script>
<script src="{{ url('resources/js/panels/admin.js') }}"></script>
</body>
</html>
