{{ HTML::style('css/Froala/froala_editor.min.css') }}
{{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:300italic,400,300') }}
{{ HTML::style('http://fonts.googleapis.com/css?family=Lato|Josefin+Sans:100,400,100italic,300italic') }}
{{ HTML::script('js/Froala/froala_editor.min.js') }}
{{ HTML::script('js/Froala/plugins/tables.min.js') }}
{{ HTML::script('js/Froala/plugins/lists.min.js') }}
{{ HTML::script('js/Froala/plugins/colors.min.js') }}
{{ HTML::script('js/Froala/plugins/media_manager.min.js') }}
{{ HTML::script('js/Froala/plugins/font_family.min.js') }}
{{ HTML::script('js/Froala/plugins/font_size.min.js') }}
{{ HTML::script('js/Froala/plugins/block_styles.min.js') }}
{{ HTML::script('js/Froala/plugins/video.min.js') }}
{{ HTML::script('js/Froala/plugins/file_upload.min.js') }}
{{ HTML::style('css/Froala/themes/gray.min.css') }}


<style type="text/css">
  .title {}
  .introduction {}
</style>


<div class="container" style="margin-top: 30px; padding-bottom: 30px;">
  <section id="editor">
    <div id='edit'>

    </div>
  </section>
</div>

<script>
  $(function(){
    $('#edit').editable({
      buttons: ["bold", "italic", "underline", "strikeThrough", "sep", "fontFamily", "fontSize", "insertHorizontalRule", "table", "sep",
      "color", "formatBlock", "blockStyle", "align", "sep",
      "insertOrderedList", "insertUnorderedList", "outdent", "indent", "sep",
      "selectAll", "createLink", "insertImage", "insertVideo", "sep",
      "undo", "redo", "html", "save", "sep"],
      inlineMode: false,
      toolbarFixed: false,
      autosave: false,
      theme: 'gray',
      saveURL: '{{ URL::action('AdminController@postUploadNewArticle') }}',
      saveParams: {id: {{ $article == null ? 0 : $article }}},
      saveRequestType: 'POST',
      imageDeleteURL: '{{ URL::action('AdminController@postDeleteArticleImage') }}',
      imageUploadURL: '{{ URL::action('AdminController@postUploadArticleImage') }}',
      fontList: ["Open Sans", "Josefin Sans", "Lato"],
      defaultBlockStyle: {
        'title': 'Title',
        'introduction': 'Introduction'
      },
    })
    .on('editable.saveError', function (e, editor, error) {
      alert('Error : missing title or introduction or image.')
    })
    .on('editable.imageError', function (e, editor, error) {
      alert('Error : upload failed.');
    })
    .on('editable.afterRemoveImage', function (e, editor, $img) {
      editor.options.imageDeleteParams = {src: $img.attr('src')};
      editor.deleteImage($img);
    })
  });
</script>