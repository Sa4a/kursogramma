var editor = {
    'container':'.editor_fields',
    'widget_name' :'',
    'activate':function(container_tag){
        editor.deactivate();
        editor.widget_name = container_tag;
        let fields = $(container_tag).data('fields').split(',');
        let titles = $(container_tag).data('titles').split(',');
        let types = $(container_tag).data('type').split(',');

        editor.buildContaitner();

        $.each(fields, function(index, field){

            switch(types[index]){
                case 'input': editor.input(titles[index], field); break;
                case 'textarea': editor.textarea(titles[index], field); break;
                case 'image': editor.image(titles[index], field); break;
                case 'video': editor.video(titles[index], field); break;
                case 'audio': editor.audio(titles[index], field); break;
                case 'slider': editor.slider(titles[index], field); break;
            }

        })
    },
    'deactivate':function(){
        $('.editor_fields').remove();
    },
    'buildContaitner':function(){
        let editor_block = $('<div class="editor_fields position-absolute" style="position: absolute;right: 0px;margin-top: -48px;"></div>');
        let close_editor = $('<div class="close" id="close_editor">\n' +
                            '    <span >×</span>\n' +
                            '  </div>');

        $('body').on("click", "#close_editor", function(){
            editor.deactivate();
        });

        close_editor.appendTo(editor_block);
        editor_block.appendTo(editor.widget_name);
    },
    'input':function(label, field){
        let form_group = $('<div class="form-group"></div>');
        $('<label>'+label+'</label>',{
            'class':'control-label',
        }).appendTo(form_group)
        $( "<input/>", {
            "id": field,
            'type': "text",
            'class':'form-control',
            keyup: function() {
                $( editor.widget_name+' .'+field ).html( $( '#'+field ).val());
            }
        }).appendTo(form_group)
        $('<div class="help-block"></div>').appendTo(form_group);
        form_group.appendTo(editor.container)
    },

    video:function(label, field){
        let video_container = $('.'+field).parent('video').parent('div');

        //file
        let form_group = $('<div class="form-group"></div>');
        $('<label>'+label+'</label>',{
            'class':'control-label',
        }).appendTo(form_group)
        $( "<input\>", {
            "id": field,
            'type':'file',
            'class':'form-control'
        }).appendTo(form_group)
        form_group.appendTo(editor.container);

        //youtuve
        let form_group_youtube = $('<div class="form-group"></div>');
        $('<label>Youtube '+label+'</label>',{
            'class':'control-label',
        }).appendTo(form_group_youtube)
        $( "<input\>", {
            "id": 'youtube_'+field,
            'type':'text',
            'class':'form-control',
            'placeholder':'Вставьте код с ютуба',
            'keyup':function(){
                video_container.html($(this).val());
            }
        }).appendTo(form_group_youtube)
        form_group_youtube.appendTo(editor.container);

        //видео по ссылке
        let form_group_link = $('<div class="form-group"></div>');
        $('<label>Видео по ссылке</label>',{
            'class':'control-label',
        }).appendTo(form_group_link)
        $( "<input\>", {
            "id": 'link_'+field,
            'type':'text',
            'class':'form-control',
            'placeholder':'Вставьте ссылку  с видео',
            'keyup':function(){
                video_container.html('');
                $(' <video controls>\n' +
                    '            <source  class="'+field+'" src="'+$(this).val()+'" type="video/ogg">\n' +
                    '            Your browser does not support the audio element.\n' +
                    '        </video>').appendTo(video_container)

            }
        }).appendTo(form_group_link)
        form_group_link.appendTo(editor.container);

        $("body").on('change','#'+field , function(evt){
            var file = evt.target.files; // FileList object
            var f = file[0];
            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                   // console.log({ data: e.target.result, name: f.name });
                    video_container.html('');
                    $('.'+field).parent('video').remove();
                    $(' <video controls>\n' +
                        '            <source fgfgfg class="'+field+'" src="'+e.target.result+'" type="video/ogg">\n' +
                        '            Your browser does not support the audio element.\n' +
                        '        </video>').appendTo(video_container)
                };
            })(f);
            reader.readAsDataURL(f);
        });
    },

    audio:function(label, field){
        let form_group = $('<div class="form-group"></div>');
        $('<label>'+label+'</label>',{
            'class':'control-label',
        }).appendTo(form_group)
        $( "<input\>", {
            "id": field,
            'type':'file',
            'class':'form-control'
        }).appendTo(form_group)
        form_group.appendTo(editor.container);

        $("body").on('change','#'+field , function(evt){
            var file = evt.target.files; // FileList object
            var f = file[0];
            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // console.log({ data: e.target.result, name: f.name });
                    audio_container = $('.'+field).parent('audio').parent('div');
                    $('.'+field).parent('audio').remove();
                    $(' <audio controls>\n' +
                        '            <source  class="'+field+'" src="'+e.target.result+'" type="audio/ogg">\n' +
                        '            Your browser does not support the audio element.\n' +
                        '        </audio>').appendTo(audio_container)
                };
            })(f);
            reader.readAsDataURL(f);
        });
    },

    image:function(label, field){
        let form_group = $('<div class="form-group"></div>');
        $('<label>'+label+'</label>',{
            'class':'control-label',
        }).appendTo(form_group)
        $( "<input\>", {
            "id": field,
            'type':'file',
            'class':'form-control'
        }).appendTo(form_group)
        form_group.appendTo(editor.container);

        $("body").on('change','#'+field , function(evt){
            var file = evt.target.files; // FileList object
            var f = file[0];
            if (!f.type.match('image.*')) {
                alert("Image only please....");
            }
            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    $('.'+field).attr('src', e.target.result);
                };
            })(f);
            reader.readAsDataURL(f);
        });
    },

    textarea:function(label, field){
        let form_group = $('<div class="form-group"></div>');
        $('<label>'+label+'</label>',{
            'class':'control-label',
        }).appendTo(form_group)
        $( "<textarea/>", {
            "id": field,
            'type': "text",
            'value': $( editor.widget_name+' .'+field ).html(),
        }).appendTo(form_group)
        $('<div class="help-block"></div>').appendTo(form_group);
        form_group.appendTo(editor.container)
        tinymce.remove('textarea');
        tinymce.init({
            selector: '#'+field,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
            content_css: '//www.tiny.cloud/css/codepen.min.css',
            setup: function(ed) {
                ed.on('keyup', function(e) {
                    $( editor.widget_name+' .'+field ).html( ed.getContent() );
                });
            }
        });
        setTimeout(function(){ tinymce.activeEditor.selection.setContent($( editor.widget_name+' .'+field ).html()); },1000);
    },
    'slider_create':function(container_slider){

        $('.admin_slider_preview').find('img').each(function(index, el){
            $('.'+container_slider).append('<div class="item slider_item"><img src="'+$(el).attr('src')+'" ></div>');
        })

        $('.'+container_slider).owlCarousel({
            navigation : false, // Show next and prev buttons
            slideSpeed : 300,
            center:true,
            autoplaySpeed:100,
            autoPlay:true,
            autoplay:true,
            autoplayTimeout:100,
            loop:true,
            paginationSpeed : 400,
            singleItem:true
            // "singleItem:true" is a shortcut for:
            // items : 1,
            // itemsDesktop : false,
            // itemsDesktopSmall : false,
            // itemsTablet: false,
            // itemsMobile : false

        });
    },
    'slider':function( label, container_slider ){
        let field = container_slider+'image';
        let form_group = $('<div class="form-group"></div>');
        $('<label>'+label+'</label>',{
            'class':'control-label',
        }).appendTo(form_group)
        $( "<input\>", {
            "id": field,
            'type':'file',
            'class':'form-control'
        }).appendTo(form_group)
        form_group.appendTo(editor.container);

        $('<div></div>',{
            'id':'slider_preview_'+container_slider,
            'class':'admin_slider_preview',
        }).appendTo(editor.container);

        $("body").on('change','#'+field , function(evt){
            var file = evt.target.files; // FileList object
            var f = file[0];
            if (!f.type.match('image.*')) {
                alert("Image only please....");
            }
            var reader = new FileReader();
            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    $('.'+container_slider).html('');
                    let count = $('.admin_slider_preview').find('img').length +1*1;
                   // $('<div><button type="button" class="close"><span>×</span></button></div>');
                    $('<img/>',{
                        width:50,
                        src:e.target.result,
                        'click':function(e){
                            $('.'+container_slider).html('');
                           $(this).remove();
                           editor.slider_create(container_slider)
                        }
                    }).appendTo( $('#'+'slider_preview_'+container_slider));
                    editor.slider_create(container_slider)
                };
            })(f);
            reader.readAsDataURL(f);
        });
    },
}

$("body").on('click','.btn-edite',function(){
    editor.activate('.'+$(this).parent('div').parent('div').data('container_name'))
})
