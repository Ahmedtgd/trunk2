@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
	<br>
        <div class="equal_to_sidebar_mrgn">
            <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
            <h2 style="display:inline;padding-left:15px">Brand Management</h2>
            <button type="button" onclick="addbrand(true)"
			class="btn btn-primary add-main-brand col-md-offset-1"
			style="margin-bottom:10px">Add Brand</button>
            <ul id="tree3" class="ar_border"
			style="max-height:600px;overflow:auto;padding-left: 0px;">
            </ul>
        </div>
</div>
<div class="modal fade" id="brand-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="brandModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="brandForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="brandModalLabel">Brand</h4>
                </div>
                <div class="modal-body">
                     <div class="form-group">
                        <label for="brandDescription" class="control-label">System Name:</label>
                        <input type="text" class="form-control" name="brandDescription" id="brandDescription" required>
                    </div> 
                    <div class="form-group">
                        <label for="brandName" class="control-label">Public Description:</label>
                        <input type="text" class="form-control" name="brandName" id="brandName" required>
                    </div>
                    <div class="form-group">
                        <img src="" id="brandImage" width="100%" height="150"
							style="object-fit:contain;background-color:rgba(204,204,204,0.31);">
                        <div class="form-group">
                            <label for="brandLogo" class="control-label">Logo</label>
                            <input type="file" name="brandLogo" id="brandLogo">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary brand-title">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ URL::asset('js/bootstrap-treeview.js')}}"></script>
<script type="text/javascript">

    var treeData = [];
    var selectedNode = null;
    var formSubmitType = null;

    $(function(){
        $('.btn-number').click(function(e){
            var type = $(this).attr('data-type');
            var input = $("input[name='floor']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if(type == 'minus') {
                    if (currentVal == 0) {
                        return false;
                    }
                    input.val(currentVal - 1)

                } else if(type == 'plus') {
                    input.val(currentVal + 1);
                }
            } else {
                input.val(0);
            }
        });
    });

    var getbrand = function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/admin/brand/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    getbrand();

    var loadTree = function(treeData) {
        $('#tree3').treeview('remove');
        $('#tree3').treeview({
            levels: 1,
            data: treeData,
            nodeUnselected: function(event, object) {
                selectedNode = null;
                formSubmitType = null;
            },
            onNodeSelected: function(event, object) {

                selectedNode = object;
                $('#tree3 li .custom-options').remove();

                setTimeout(function() {
                    var appendHtml = '<span class="pull-right custom-options">';
                    appendHtml += '<a href="" onclick="editbrand()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removebrand()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removebrand()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new brand modal display

    function addbrand(isMain) {
        $(".mainbrand").hide();
        $("label[for='brandLogo']").text('Logo');
        formSubmitType = "add";
        $("#brand-modal").modal('show');
        $(".brand-title").text("Save");
        if (isMain) {
            $("label[for='brandLogo']").text('Logo White');
            $(".mainbrand").show();
            $('img#brandImage').hide();
            $('img#brandGreenImage').hide();
            selectedNode = {};
        }
    }

    // edit brand modal display

    function editbrand() {
        $(".mainbrand").hide();
        $("label[for='brandLogo']").text('Logo');
        if (!selectedNode['data-brand-id']) {
            $("label[for='brandLogo']").text('Logo');
            $(".mainbrand").show();
        };
        formSubmitType = "edit";
        if (selectedNode.logo) {
            $('img#brandImage').show();
            $('img#brandImage').attr('src', selectedNode.logo);
        } else {
            $('img#brandImage').hide();
        }
        console.log(selectedNode);

        $("#brandName").val(selectedNode.name);
        $("#brandDescription").val(selectedNode.brandDescription);
        $("#brand-modal").modal('show');
        $(".brand-title").text("Save");
    }

    // remove brand

    function removebrand() {

        if (confirm('Are you sure you want to remove brand?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove brand form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/brand/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        getbrand();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("Brand successfully removed.");
                        $(".success-msg").fadeOut(4000);
						getbrand();
                        return false;
                    }
                });
            }
        }
    }

    var logoFile = null;
    $("input#brandLogo").on('change', function(event) {
        logoFile = event.target.files;
    });

    // submit add or edit brand form
    $("#brandForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/brand/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/brand/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;

            if (logoFile) {
                formData.append('logo', logoFile[0]);
            }

            formData.append('brandName', $("#brandName").val());
            formData.append('brandDescription', $("#brandDescription").val());

            if (selectedNode['data-brand-id']) {
                formData.append('data-brand-id', selectedNode['data-brand-id']);
            }

            // add or edit brand
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery
									// will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("brandForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    getbrand();
                    $("#brand-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("Brand successfully updated.");
                    } else {
                        $(".success-msg").text("Brand successfully added.");
                    }
                    $(".success-msg").fadeOut(4000);
                    formSubmitType = null;
					getbrand();
                    return false;
                }
            });
        };
        return false;
        event.preventDefault();
    });

    $('#brand-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("brandForm").reset();
    });

</script>
@stop
