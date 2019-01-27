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
            border: 1px solid #1BBC9B;
            margin-left: 5px;;
        }
        .deleteBtn{
            float: left;
            margin-left: 5px;
            /*margin-top: 20px;*/
        }
        .manageBtn{
            padding-top:2px;
            padding-bottom:2px;
            float: left;
        }
    </style>
    <?php $i=1; ?>

    <div class="container" style="margin-top:30px;">
        @include('admin/panelHeading')

        <h2>
            <span>General: OpenSupport {{$category->name}} Sub-Category</span>
        </h2>

        <section style="margin-bottom: 20px;">
            <a id="openAddSubcategoryBtn" class="btn btn-default">
                <i class="fa fa-plus-circle"></i> Add Sub-categories
            </a>
            <a id="closeAddSubcategoryBtn" class="btn btn-default" style="display:none;">
                <i class="fa fa-remove-circle"></i> Cancel
            </a>
            <a id="openEditSubcategoryBtn" class="btn btn-default" style="display:none;">
                <i class="fa fa-remove-circle"></i> Edit Sub-category
            </a>
            <a id="closeEditSubcategoryBtn" class="btn btn-default" style="display:none;">
                <i class="fa fa-remove-circle"></i> Cancel
            </a>

            <a href="{{route('generalIndexOpenSupport')}}" id="openSubcategoryBtn" class="btn btn-default">
                <i class="fa fa-plus-circle"></i> Manage Quesstions
            </a>
        </section>

        <section id="osSubcategoryForm" style="display: none;">
            <div class="container">
                <div class="row">
                    <form id="osAddSubcategoryForm" class="form-horizontal" style="margin-top:0; display: none;">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input id="name" name="name" class="form-control" type="text" placeholder="Enter Subcategory">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea id="description" name="description" class="summernote" placeholder="Enter description"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="radio inline" style="padding-left:0;">
                                    <input type="radio" name="status" value="enabled" checked>
                                    <span>Enabled</span>
                                </label>
                                <label class="radio inline">
                                    <div>
                                        <input type="radio" name="status" value="disabled">
                                        <span>Disabled</span>
                                    </div>
                                </label>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button id="saveSubcategoryBtn" type="button" class="btn btn-success pull-right">Save</button>
                            </div>
                        </div>
                        {{$category->id}}
                        <input type="hidden" id="parent_id" name="parent_id" value="{{$category->id}}">
                    </form>
                    <form id="osEditSubcategoryForm" class="form-horizontal" style="margin-top:0;  display: none;">
                        <div class="col-sm-12">
                            <div class="form-group" style="margin-right: 5px;">
                                <input id="name" name="name" class="form-control" type="text" placeholder="Enter Category">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea id="description" name="description" class="summernote" placeholder="Enter description"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="radio inline" style="padding-left:0;">
                                    <input type="radio" name="status" value="enabled" checked>
                                    <span>Enabled</span>
                                </label>
                                <label class="radio inline">
                                    <div>
                                        <input type="radio" name="status" value="disabled">
                                        <span>Disabled</span>
                                    </div>
                                </label>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button id="saveSubcategoryBtn" type="button" class="btn btn-success pull-right">Save</button>
                            </div>
                        </div>
                        <input type="hidden" id="parent_id" name="parent_id" value="{{$category->id}}">
                    </form>
                </div>
            </div>
        </section>

        <section id="osSubcategoryTable" style="margin-bottom: 50px; display:none;">
            <div>
                <form>
                    <table class="table table-bordered table-responsive" cellspacing="0" width="840px" id='merchantTable'>

                        <thead>
                        <tr>
                            <th class="text-center" style="width:50px">
                                <input name="check-all" id="check-all" type="checkbox">&nbsp;S/N
                            </th>
                            <th class="text-left">Name</th>
                            <th class="text-left" style="width:45%;">Description</th>
                            <th class="text-left" style="width:80px;">Action</th>
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
            var category_id = '{{$category->id}}';

            //Initialize summernote
            //-----------------------------------------------------------------------------------------------------
            $('.summernote').summernote({
                minHeight: 100, // set minimum height of editor
                maxHeight: 200, // set maximum height of editor
                callbacks: {
                    onImageUpload: function(image){
//                        uploadImage(image[0], $(this));
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

            //initialize table
            table.initialize = function(settings, json)
            {
                $(".editSubcategoryBtn").click(function(e)
                {
                    e.preventDefault();
                    //forms
                    $("#osSubcategoryTable").hide();
                    $('#osSubcategoryForm').show();

                    $('#osSubcategoryForm').find('#osEditSubcategoryForm').show();
                    $('#osSubcategoryForm').find('#osAddSubcategoryForm').hide();

                    //buttons
                    $('#closeAddSubcategoryBtn').show();
                    $('#openAddSubcategoryBtn').hide();

                    //initialize things
                    var data = JSON.parse(atob($(this).attr('data-text')));
                    var url = $(this).attr('data-url');
                    var form = $('#osEditSubcategoryForm');
                    var name =  form.find('#name');
                    var description = form.find('#description');
                    var parent_id = form.find('#parent_id');

                    //populate edit form
                    name.val(data.name);
                    description.summernote("code", data.description);
                    data.status = 'draft';
                    form.find("input[name=status][value="+data.status+"]").prop("checked",true);

                    var initialData = {
                        name: name.val(),
                        description : description.val(),
                        status : form.find('input[name=status]:checked').val(),
                        parent_id: parent_id.val()
                    };

                    //on edit form save
                    form.find('#saveSubcategoryBtn').click(function(e)
                    {
                        e.preventDefault();

                        var btn = $(this);
                        var btnText = btn.html();

                        var data = {
                            name: name.val(),
                            description : description.val(),
                            status : form.find('input[name=status]:checked').val(),
                            parent_id: parent_id.val()
                        };

                        console.log(data);

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
//                                    table.make(r.data.categories, 'desc');
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

                $(".deleteSubcategoryBtn").click(function(e)
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
                        { "data": "name", className: "text-left"},
                        { "data": "description", className: "text-left"},
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta )
                            {
                                if(full.id != 'undefined')
                                {
                                    return '<button type="button" data-text="'+btoa(JSON.stringify(full))+'" class="btn btn-success editSubcategoryBtn editBtn" data-url="/admin/general/opensupport/sub-category/update/'+full.id+'">Edit</button>' +
                                            '<a class="text-danger deleteSubcategoryBtn deleteBtn" data-url="/admin/general/opensupport/'+category_id+'/sub-category/delete/'+full.id+'"><i class="fa fa-minus-circle fa-2x"></i></a>'
                                }else{ return ''}

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



            //Initialize Table and fetch data/admin/general/opensupport/{category}/sub-category
            //-----------------------------------------------------------------------------------------------------
            $.ajax({
                url:'/admin/general/opensupport/'+category_id+'/sub-category',
                type:'GET',
                dataType: 'json',
                success:function (r)
                {console.log(r)
                    if(r.status==true)
                    {
                        $("#osSubcategoryTable").show();
                        table.make(r.data.sub_categories, 'asc');
                    }else{
                        toastr.error("We have some errors");
                    }
                },
                error: function(r){
                    toastr.error("Ops! Internal server error occurred");
                }
            });

            //Open Add Category
            //-----------------------------------------------------------------------------------------------------
            $('#openAddSubcategoryBtn').click(function()
            {
                $('#osSubcategoryForm').show();
                $("#osSubcategoryTable").hide();
                $('#osSubcategoryForm').find('#osEditSubcategoryForm').hide();
                $('#osSubcategoryForm').find('#osAddSubcategoryForm').show();

                //hide add subcategory button
                $(this).hide();
                //show cancel subcategory button
                $("#closeAddSubcategoryBtn").show();
            });

            $('#osAddSubcategoryForm').find('#saveSubcategoryBtn').click(function(e)
            {
                e.preventDefault();

                var btn = $(this);
                var btnText = btn.html();
                var url = '/admin/general/opensupport/sub-category';
                var form = $('#osAddSubcategoryForm');

                var data = {
                    name: form.find('#name').val(),
                    description : form.find('#description').val(),
                    status : form.find('input[name=status]:checked').val(),
                    parent_id: form.find('#parent_id').val()
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
                            form.find('#name').val('');
                            form.find('#description').summernote('code', '');
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

            //Close Add Subcategory
            //-----------------------------------------------------------------------------------------------------
            $('#closeAddSubcategoryBtn').click(function()
            {
                $("#osSubcategoryForm").hide()
                $("#osSubcategoryTable").show();
                //hide add subcategory button
                $(this).hide();
                //show add subcategory button
                $("#openAddSubcategoryBtn").show();

                $.ajax({
                    url:'/admin/general/opensupport/'+category_id+'/sub-category',
                    type:'GET',
                    dataType: 'json',
                    success:function (r)
                    {
                        if(r.status==true)
                        {
                            $("#osSubcategoryTable").show();
                            table.make(r.data.sub_categories, 'asc');
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
