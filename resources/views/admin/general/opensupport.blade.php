@extends("common.default")

@section("content")
    <style type="text/css">
        .overlay{
            background-color: rgba(1, 1, 1, 0.7);
            bottom: 0;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            z-index: 1001;
        }
        .overlay p{
            color: white;
            font-size: 72px;
            font-weight: bold;
            margin: 300px 0 0 55%;
        }
        .action_buttons{
            display: flex;
        }
        .role_status_button{
            margin: 10px 0 0 10px;
            width: 85px;
        }
        .com, .pay, .ocom, .opay, .osales {
            width: 170px ;
        }

        table#merchantTable
        {
            table-layout: fixed;
            max-width: none;
            width: auto;
            min-width: 100%;
        }

        .select2-dropdown.select2-dropdown--below{

        }

        .select2-selection__rendered{
            color: #7c7c7c !important;
            padding-left: 10px !important;
        }

        .select2-container--default .select2-selection--single{
            height: 35px;
            padding-top:2px;
            padding-bottom:4px;
            font-size: 1.2em;
            position: relative;
            border-radius: 0;
            border: 1px solid #ccc;
            color: #ccc;
        }

        .maxl{
            margin:25px ;
        }
        .inline{
            display: inline-block;
        }
        .inline + .inline{
            margin-left:10px;
        }
        .radio{
            color:#999;
            font-size:15px;
            position:relative;
        }
        .radio span{
            position:relative;
            padding-left:20px;
        }
        .radio span:after{
            content:'';
            width:15px;
            height:15px;
            border:3px solid;
            position:absolute;
            left:0;
            top:1px;
            border-radius:100%;
            -ms-border-radius:100%;
            -moz-border-radius:100%;
            -webkit-border-radius:100%;
            box-sizing:border-box;
            -ms-box-sizing:border-box;
            -moz-box-sizing:border-box;
            -webkit-box-sizing:border-box;
        }
        .radio input[type="radio"]{
            cursor: pointer;
            position:absolute;
            width:100%;
            height:100%;
            z-index: 1;
            opacity: 0;
            filter: alpha(opacity=0);
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"
        }
        .radio input[type="radio"]:checked + span{
            color:#0B8;
        }
        .radio input[type="radio"]:checked + span:before{
            content:'';
            width:5px;
            height:5px;
            position:absolute;
            background:#0B8;
            left:5px;
            top:6px;
            border-radius:100%;
            -ms-border-radius:100%;
            -moz-border-radius:100%;
            -webkit-border-radius:100%;
        }
        .detail-row{
            display: none;
        }
        .note-editor{
            border: 1px solid #ccc !important;
            border-radius: 0 !important;
            -webkit-border-radius: 0 !important;
            -moz-border-radius: 0 !important;
        }

        .editBtn,
        .editBtn:hover{
            float: left;
            padding-top:2px;
            padding-bottom:2px;
            background: #1BBC9B !important;
            border: 0;
        }
        .deleteBtn{
            float: left;
            margin-left: 10px;
            /*margin-top: 20px;*/
        }

    </style>
    <?php $i=1; ?>

    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')

        <h2>
            <span>General: OpenSupport</span>
            {{--<span class="pull-right" id="msLinkingDate">16/11/2016</span>--}}
        </h2>

        <section style="margin-bottom: 20px;">
            <a id="openAddQuestionBtn" class="btn btn-default">
                <i class="fa fa-plus-circle"></i> Add Questions
            </a>
            <a id="closeAddQuestionBtn" class="btn btn-default" style="display:none;">
                <i class="fa fa-remove-circle"></i> Cancel
            </a>
            <a id="openEditQuestionBtn" class="btn btn-default" style="display:none;">
                <i class="fa fa-remove-circle"></i> Edit Question
            </a>
            <a id="closeEditQuestionBtn" class="btn btn-default" style="display:none;">
                <i class="fa fa-remove-circle"></i> Cancel
            </a>

            <a href="{{route('generalIndexOpenSupportCategory')}}" id="openCategoryBtn" class="btn btn-default">
                <i class="fa fa-plus-circle"></i> Manage Categories
            </a>
        </section>

        <section id="osQuestionForm" style="display: none;">
            <div class="container">
                <div class="row">
                    <form id="osAddQuestionForm" class="form-horizontal" style="margin-top:0; display: none;">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input id="title" name="title" class="form-control" type="text" placeholder="Enter Question">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id="category" name="category" class="form-control">
                                    <option value="" selected="selected">Select Category</option>
                                    @if(isset($categories))
                                        @foreach($categories as $c)
                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group" style="margin-left: 5px;">
                                <select id="subcategory" name="subcategory" class="form-control" disabled="true">
                                    <option value="" selected="selected">Select Subcategory</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea id="answer" name="answer" class="summernote" placeholder="Enter answer"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="radio inline" style="padding-left:0;">
                                    <input type="radio" name="status" value="published" checked>
                                    <span>Published</span>
                                </label>
                                <label class="radio inline">
                                    <div title="This is for organizations which buys B2B for internal usage or consumption; i.e. restaurants buying flour or poultry.">
                                        <input type="radio" name="status" value="draft">
                                        <span>Draft</span>
                                    </div>
                                </label>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button id="saveQuestionBtn" type="button" class="btn btn-success pull-right">Save</button>
                            </div>
                        </div>
                    </form>

                    <form id="osEditQuestionForm" class="form-horizontal" style="margin-top:0;  display: none;">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input id="title" name="title" class="form-control" type="text" placeholder="Enter Question">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id="category" name="category" class="form-control">
                                    <option value="" selected="selected">Select Category</option>
                                    @if(isset($categories))
                                        @foreach($categories as $c)
                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group" style="margin-left: 5px;">
                                <select id="subcategory" name="subcategory" class="form-control" disabled="true">
                                    <option value="" selected="selected">Select Subcategory</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea id="answer" name="answer" class="summernote" placeholder="Enter answer"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="radio inline" style="padding-left:0;">
                                    <input type="radio" name="status" value="published" checked>
                                    <span>Published</span>
                                </label>
                                <label class="radio inline">
                                    <div>
                                        <input type="radio" name="status" value="draft">
                                        <span>Draft</span>
                                    </div>
                                </label>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button id="saveQuestionBtn" type="button" class="btn btn-success pull-right">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section id="osQuestionTable" style="margin-bottom: 50px; display:none;">
            <div>
                <form>
                    <table class="table table-bordered table-responsive" cellspacing="0" width="840px" id='merchantTable'>

                        <thead>
                        <tr>
                            <th class="text-center" style="width:50px">
                                <input name="check-all" id="check-all" type="checkbox">&nbsp;S/N
                            </th>
                            <th class="text-left">Question</th>
                            <th class="text-left" style="width:30%;">Category</th>
                            <th class="text-left" style="width:70px;">Action</th>
                        </tr>
                        </thead>

                        <tfoot>
                        <tr></tr>
                        </tfoot>
                        <tbody>
                        <tr>
                            <td class='text-left'></td>
                            <td class='text-left'></td>
                            <td class='text-left'></td>
                            <td class='text-left'></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function()
        {
            function uploadImg1(files, editor, welEditable, directory, summer, onSuccess) {

                for(var fs = 0; fs < files.length; fs++){
                    var data = new FormData();

                    console.log( files[fs]);

                    data.append("file", files[fs]);
                    data.append("directory", directory);
                    $.ajax({
                        data: data,
                        type: "POST",
                        url: JS_BASE_URL + "/uploadsummernoteimg",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(url) {

                            if(typeof summer != 'undefined' && summer){
                                $('#' + summer).summernote('insertImage', url);
                            }

                            //so we can handle this with call back
                            if(typeof onSuccess == 'function'){
                                onSuccess(url);
                            }
                        }
                    });
                }
            }

//            document.addEventListener('paste', function(e) {  console.log({types:e.clipboardData.types})
//                // e.clipboardData contains the data that is about to be pasted.
//                if (e.clipboardData.types.indexOf('text/html') > -1) {
//
//
//
//
//
//                    // This is necessary to prevent the default paste action.
//                    e.preventDefault();
//                }
//            });

            //Initialize summernote
            //-----------------------------------------------------------------------------------------------------
            $('.summernote').summernote({
                minHeight: 100, // set minimum height of editor
                maxHeight: 200, // set maximum height of editor
                callbacks: {
                    onImageUpload: function(files, editor, welEditable){
                        var _this = $(this);
                        uploadImg1(files, editor, welEditable, 'opensupport', null, function(url){
                            console.log(url)
                            _this.summernote('insertImage', url);
                        });
                    },
                    onPaste: function(e)
                    {
//                        e.preventDefault();

                        var clpData = ((e.originalEvent || e).clipboardData || window.clipboardData);
//                        console.log(e);
//                        console.log(clpData);
//                        console.log(e.originalEvent);
//                        console.log(e.clipboardData);



//                        for (var i = 0 ; i < e.clipboardData.items.length ; i++) {
//                            var item = e.clipboardData.items[i];
//                            console.log("Item type: " + item.type);
//                            if (item.type.indexOf("image") != -1) {
//                                console.log(item.getAsFile());
//                            } else {
//                                console.log("Discarding non-image paste data");
//                            }
//                        }
//                        if (clpData) {
//                            var bufferText = clpData.getData('text/plain');
//                            e.preventDefault();
//
//                            window.setTimeout(function() {
//                                document.execCommand('insertText', false, bufferText);
//                            }, 0);
//                        }

                        var elem = $(this);
                        var clipboardData, found;
                        found = false;
                        clipboardData = e.clipboardData;

                        setTimeout(function()
                        {

                            var options = {
                                callback: $.noop,
                                matchType: /image.*/
                            };

                            var $this, element;
                            element = this;
                            $this = $(this);



//                            var y = Array.prototype.forEach.call(clipboardData.types, function(type, i) {
//                                var file, reader;
//                                if (found) {
//                                    return;
//                                }
//                                if (type.match(options.matchType) || clipboardData.items[i].type.match(options.matchType)) {
//                                    file = clipboardData.items[i].getAsFile();
//                                    reader = new FileReader();
//                                    reader.onload = function(evt) {
//                                        return options.callback.call(elem, {
//                                            dataURL: evt.target.result,
//                                            event: evt,
//                                            file: file,
//                                            name: file.name
//                                        });
//                                    };
//                                    reader.readAsDataURL(file);
//                                    snapshoot();
//                                    return found = true;
//                                }
//                            });
//
//                            console.log(y);


































//                            var code = elem.summernote('code');
//                            var codeElem = $('<div>'+code+'</div>');
//
//                            //find all the images in summernote
//                            var images = codeElem.find('img').map(function()
//                            {
//                                console.log($(this))
//                                return $(this).attr('src')
//                            }).get();
//
//                            //process images
//                            for(var i=0; i < images.length; i++)
//                            {
//
//                            };

                        }, 1000);
                    }
                },
                codemirror: { // codemirror options
                    theme: 'monokai',
                    lineNumbers: true,
                    tabMode: "indent"
                }

            });

            $(".summernote").on("summernote.change", function (e)
            {
                // callback as jquery custom event
                var code = $(this).summernote('code'),
                        filteredContent = code.replace(/\s+/g, '');
                if(filteredContent.length == 0 || code.replace(/\<(?!img).*?\>/g,'').length == 0) {
                    $(this).parent().find(".note-frame").attr("style","border:1px solid #F00 !important");
                    $(this).parent().find(".currentalerr").attr("color","red").text('This field is required.');
                    $(this).parent().find(".currentalerr").show();
                } else {
                    $(this).parent().find(".note-frame").attr("style","");
                    $(this).parent().find(".currentalerr").fadeOut("slow");
                }
            });


            //Helpers
            //-----------------------------------------------------------------------------------------------------
            var table={};

            table.populateSelect = function(url, dataAttr, element, name, callback)
            {
                $.ajax({
                    url:url,
                    type:'GET',
                    dataType: 'json',
                    success:function (r)
                    {console.log(r)
                        if(r.status==true)
                        {
                            var data = typeof dataAttr != 'undefined' ? r.data[dataAttr] : r.data; //sub_categories

                            if(!data.length){
                                toastr.error('No '+name+' was found');
                                return false;
                            }

                            element.prop('disabled', false);

                            var res = [];
                            for(var i  = 0 ; i < data.length; i++) {
                                res.push({id: data[i].id, text: data[i].name});
                            };

                            element.select2({
                                data: res
                            });

                            if(typeof callback != 'undefined') callback(res);

                        }else{
                            toastr.error("We have some errors");
                        }
                    },
                    error: function(r){
                        toastr.error("Ops! Internal server error occurred");
                    }
                });
            };

            //initialize table
            table.initialize = function(settings, json)
            {
                $(".editQuestionBtn").click(function(e)
                {
                    e.preventDefault();
                    //forms
                    $("#osQuestionTable").hide();
                    $('#osQuestionForm').show();

                    $('#osQuestionForm').find('#osEditQuestionForm').show();
                    $('#osQuestionForm').find('#osAddQuestionForm').hide();

                    //buttons
                    $('#closeAddQuestionBtn').show();
                    $('#openAddQuestionBtn').hide();

                    //initialize things
                    var data = JSON.parse(atob($(this).attr('data-text')));
                    var url = $(this).attr('data-url');
                    var form = $('#osEditQuestionForm');
                    var title =  form.find('#title');
                    var answer = form.find('#answer');
                    var category = form.find('#category');
                    var subcategory = form.find('#subcategory');

                    console.log(data)

                    //populate edit form
                    title.val(data.title);
                    answer.summernote("code", data.answer);
                    category.select2('val', null);
                    category.select2('val', data.category_id);
                    data.status = 'draft';
                    form.find("input[name=status][value="+data.status+"]").prop("checked",true);

                    if(typeof data.category_id != 'undefined' && data.category_id)
                    {
                        var urlSubCat = '/admin/general/opensupport/'+data.category_id+'/sub-category';
                        table.populateSelect(urlSubCat, 'sub_categories', subcategory, 'Subcategory', function(data){
                            subcategory.select2('val', null);
                            subcategory.select2('val', data.subcategory_id);
                        });
                    }

                    var initialData = {
                        title: title.val(),
                        ospt_qcategory_id : category.select2("val"),
                        answer : answer.val(),
                        status : form.find('input[name=status]:checked').val(),
                        ospt_qsubcategory_id: subcategory.select2("val")
                    };

                    //on edit form save
                    form.find('#saveQuestionBtn').click(function(e)
                    {
                        e.preventDefault();

                        var btn = $(this);
                        var btnText = btn.html();

                        var data = {
                            title: title.val(),
                            ospt_qcategory_id : category.select2("val"),
                            answer : answer.val(),
                            status : form.find('input[name=status]:checked').val(),
                            ospt_qsubcategory_id: subcategory.select2("val")
                        };

                        //check if change was made
                        if(JSON.stringify(initialData) == JSON.stringify(data)){
                            toastr.error('No changes made');
                            return;
                        }else{
                            btn.html('Saving changes ...');
                            btn.prop('disabled', true);
//                            initialData = data;
                        }

                        $.ajax({
                            url: url,
                            type:'POST',
                            dataType: 'json',
                            data: data,
                            success:function (r)
                            {
                                if (r.status==true){
//                                    table.make(r.data.questions, 'desc');
                                }else{
                                    toastr.error("We have some errors");
                                }
                                toastr.success(r.message);

                                btn.html(btnText);
                                btn.prop('disabled', false);
                            },
                            error: function(r){
                                btn.html(btnText);
                                btn.prop('disabled', false);
                                toastr.error("Ops! Internal server error occurred");
                            }
                        });
                    });
                });

                $(".deleteQuestionBtn").click(function(e)
                {
                    e.preventDefault();
                    var url = $(this).attr('data-url');
                    var btn = $(this);
                    var btnText = btn.html();

                    btn.html('<i class="fa fa-refresh fa-spin fa-2x"></i>');
                    btn.prop('disabled', true);

                    $.ajax({
                        url:url,
                        type:'GET',
                        dataType: 'json',
                        success:function(r)
                        {
                            btn.html(btnText);
                            btn.prop('disabled', false);

                            if (r.status==true){
                                toastr.success(r.message);
                                //remove
                                $('#merchantTable').empty();
                                table.make(r.data); //recreate table
                            }else{
                                toastr.error(r.message);
                            }
                        },
                        error: function(r){
                            btn.html(btnText);
                            btn.prop('disabled', false);
                            console.log(r);
                            toastr.error("Ops! Internal server error occurred");
                        }
                    });
                });
            };

            //makes table
            table.make = function(data, order)
            {
                if(typeof order == 'undefined') order = "desc";
//
                $('#merchantTable').dataTable({
                    "data": data,
                    "columns": [
                        { "data": "id", className: "text-center", sortable: false},
                        { "data": "title", className: "text-left"},
                        { "data": "category", className: "text-left"},
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {

                                return '<button type="button" data-text="'+btoa(JSON.stringify(full))+'" class="btn btn-success editQuestionBtn editBtn" data-url="/admin/general/opensupport/update/'+full.id+'">Edit</button>' +
                                        '<a class="text-danger deleteQuestionBtn deleteBtn" data-url="/admin/general/opensupport/delete/'+full.id+'"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></a>'

                            }
                        }
                    ],
                    "order": [[ 0, 'desc']],
                    "scrollX": true,
                    destroy: true,
                    "initComplete": function( settings, json )
                    {
                        table.initialize(settings, json);
                    }
                }).on('page.dt', function()
                { //on next page event
                    setTimeout(function()
                    {
                        table.initialize(null, null);
                    }, 1000);
                });
            };




            //Initialize Table and fetch data
            //-----------------------------------------------------------------------------------------------------
            $.ajax({
                url:'/admin/general/opensupport',
                type:'GET',
                dataType: 'json',
                success:function (r)
                {
                    if(r.status==true)
                    {
                        $("#osQuestionTable").show();
                        table.make(r.data.questions, 'asc');
                    }else{
                        toastr.error("We have some errors");
                    }
                },
                error: function(r){
                    toastr.error("Ops! Internal server error occurred");
                }
            });

            //Open Add Question
            //-----------------------------------------------------------------------------------------------------
            $('#openAddQuestionBtn').click(function()
            {
                $('#osQuestionForm').show();
                $("#osQuestionTable").hide();
                $('#osQuestionForm').find('#osEditQuestionForm').hide();
                $('#osQuestionForm').find('#osAddQuestionForm').show();

                //hide add question button
                $(this).hide();
                //show cancel question button
                $("#closeAddQuestionBtn").show();
            });



            //on category change
            //-----------------------------------------------------------------------------------------------------
            $('#category').change(function(e){
                var form =  $(this).closest('form');
                var category = $(this).val();
                var subcategory = form.find('#subcategory');

                subcategory.prop('disabled', true);

                if(typeof category != 'undefined' && category){
                    var url = '/admin/general/opensupport/'+category+'/sub-category';
                    table.populateSelect(url, 'sub_categories', subcategory, 'Subcategory', function(data){
                        console.log(data);
                    });
                }
            });




            //Add Question
            //-----------------------------------------------------------------------------------------------------
            $('#osAddQuestionForm').find('#saveQuestionBtn').click(function(e)
            {
                e.preventDefault();

                var btn = $(this);
                var btnText = btn.html();
                var url = '/admin/general/opensupport';
                var form = $('#osAddQuestionForm');

                var data = {
                    title: form.find('#title').val(),
                    ospt_qcategory_id : form.find('#category').select2("val"),
                    answer : form.find('#answer').val(),
                    status : form.find('input[name=status]:checked').val(),
                    ospt_qsubcategory_id: form.find('#subcategory').select2("val")
                };

                btn.html('Saving ...');
                btn.prop('disabled', true);

                $.ajax({
                    url: url,
                    type:'POST',
                    dataType: 'json',
                    data: data,
                    success:function (r)
                    {
                        if (r.status==true){
                            form.find('#title').val('');
                            form.find('#category').select2('val', null);
                            form.find('#subcategory').select2('val', null);
                            form.find('#answer').summernote('code', '');
                        }else{
                            toastr.error("We have some errors");
                        }
                        toastr.success(r.message);

                        btn.html(btnText);
                        btn.prop('disabled', false);
                    },
                    error: function(r){
                        btn.html(btnText);
                        btn.prop('disabled', false);
                        toastr.error("Ops! Internal server error occurred");
                    }
                });
            });

            //Close Add Question
            //-----------------------------------------------------------------------------------------------------
            $('#closeAddQuestionBtn').click(function()
            {
                $("#osQuestionForm").hide()
                $("#osQuestionTable").show();
                //hide add question button
                $(this).hide();
                //show add question button
                $("#openAddQuestionBtn").show();

                $.ajax({
                    url:'/admin/general/opensupport',
                    type:'GET',
                    dataType: 'json',
                    success:function (r)
                    {
                        if(r.status==true)
                        {
                            $("#osQuestionTable").show();
                            table.make(r.data.questions, 'asc');
                        }else{
                            toastr.error("We have some errors");
                        }
                    },
                    error: function(r){
                        toastr.error("Ops! Internal server error occurred");
                    }
                });
            });

        });
    </script>
@stop
