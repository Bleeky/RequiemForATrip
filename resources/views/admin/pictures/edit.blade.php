@extends('layouts.default')
@section('content')

    {!! HTML::style('css/edition_dependencies.css') !!}

    {!! HTML::script('js/edition_dependencies.min.js') !!}

    <div class="container">
        <section id="editor">
            <div id="picture-editor">
                {!! $picture->html !!}
            </div>
        </section>
    </div>

    <script>
        $(function () {
            var csrfToken = '{!! csrf_token() !!}';
            $('#picture-editor').editable({
                buttons: ["bold", "italic", "underline", "strikeThrough", "sep", "fontFamily", "fontSize", "insertHorizontalRule", "table", "sep",
                    "color", "formatBlock", "blockStyle", "align", "sep",
                    "insertOrderedList", "insertUnorderedList", "outdent", "indent", "sep",
                    "selectAll", "createLink", "insertImage", "insertVideo", "sep",
                    "undo", "redo", "html", "save", "fullscreen", "sep", "help"],
                customButtons: {
                    help: {
                        title: 'help',
                        icon: {
                            type: 'font',
                            value: 'fa fa-question'
                        },
                        callback: function () {
                            bootbox.dialog({
                                onEscape: function () {
                                },
                                title: "Article editing",
                                message: 'Fonts size you should use :<br>' +
                                '<b>For content</b> : 16px<br>' +
                                '<b>For titles</b> : 28px with bold' +
                                '<br><br><b>Picture formating :</b><br>' +
                                '<b>Click on the Magic wand</b> and then select the title you ' +
                                'want, and the content you want. The font and style aren\'t important.'
                            });
                        },
                        refresh: function () {
                        }
                    }
                },
                inlineMode: false,
                imageDeleteConfirmation: false,
                toolbarFixed: false,
                autosave: false,
                plainPaste: true,
                theme: 'dark',
                saveURL: '{!! URL::action('PictureAdminController@postSavePicture') !!}',
                saveParams: {id: '{!! $picture->id !!}', _token: csrfToken},
                saveRequestType: 'POST',
                imageUploadParams: {_token: csrfToken},
                imageUploadURL: '{!! URL::action('PictureAdminController@postUploadPictureImage') !!}',
                imageDeleteURL: '{!! URL::action('PictureAdminController@postDeletePictureImage') !!}',
                fontList: ["Open Sans"],
                defaultBlockStyle: {
                    'title': 'Title',
                    'content': 'Content'
                }
            })
                    .on('editable.saveError', function (e, editor, data) {
                        bootbox.dialog({
                            onEscape: function () {
                            }, title: 'Saving', message: 'Save Error.'
                        });
                    })
                    .on('editable.afterSave', function (e, editor, data) {
                        bootbox.dialog({
                            onEscape: function () {
                            }, title: 'Saving', message: 'Save Successful !'
                        });
                    })
                    .on('editable.imageError', function (e, editor, data) {
                        bootbox.dialog({
                            onEscape: function () {
                            }, title: 'Saving', message: 'Upload Error.'
                        });
                    })
            $('#picture-editor').on('editable.afterRemoveImage', function (e, editor, $img) {
                editor.options.imageDeleteParams = {src: $img.attr('src'), _token: csrfToken};
                editor.deleteImage($img);
            });
        });
    </script>

@stop