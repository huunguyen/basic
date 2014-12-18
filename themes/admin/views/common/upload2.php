<!-- The template to display files available for upload -->
<script id="template-upload2" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade" style="width:80%">
        <td class="preview">
            <span class="fade"></span>
        </td>
        <td class="name" colspan="2">
            <span>{%=file.name%}</span><br/>
            <span>{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            <label>Tóm tắt nội dung(*)</label>
            <input type="text" name="title" autocomplete="off" required /><br />            
            <label>Mô tả chi tiết(*)</label>
            <textarea name="description" rows="3" required ></textarea><br />
        </td>        
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>