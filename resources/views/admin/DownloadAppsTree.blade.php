@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
            <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
            <button type="button" onclick="adddownloadapps(true)" class="btn btn-primary add-main-downloadapps">Add Download Apps</button>
            <br><br>
            <b>Download Apps Management</b>
            <br><br>
            <ul id="tree3" class="ar_border" style="max-height:600px;overflow:auto;padding-left: 0px;">
            </ul>
        </div>
</div>
<div class="modal fade" id="downloadapps-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="downloadappsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="downloadappsForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title downloadapps-title" id="downloadappsModalLabel">Add Download Apps</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="full_name" class="control-label">Name:</label>
                        <input type="text" class="form-control" name="full_name" id="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_number" class="control-label">Contact Number</label>
                        <input type="text" class="form-control" name="contact_number" id="contact_number" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary downloadapps-title">Add Download Apps</button>
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

    var getdownloadapps = function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/admin/downloadapps/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    getdownloadapps();

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
                    appendHtml += '<a href="" onclick="editdownloadapps()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removedownloadapps()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removedownloadapps()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new downloadapps modal display

    function adddownloadapps(isMain) {
        $(".maindownloadapps").hide();
        formSubmitType = "add";
        $("#downloadapps-modal").modal('show');
        $(".downloadapps-title").text("Add Download Apps");
        if (isMain) {
            $(".maindownloadapps").show();
            selectedNode = {};
        }
    }

    // edit downloadapps modal display

    function editdownloadapps() {
        $(".maindownloadapps").hide();
        if (!selectedNode['data-downloadapps-id']) {
            $(".maindownloadapps").show();
        };
        formSubmitType = "edit";
        $("#full_name").val(selectedNode.full_name);
        $("#contact_number").val(selectedNode.contact_number);
        $("#email").val(selectedNode.email);
        $("#downloadapps-modal").modal('show');
        $(".downloadapps-title").text("Edit Download Apps");
    }

    // remove downloadapps

    function removedownloadapps() {

        if (confirm('Are you sure you want to remove downloadapps?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove downloadapps form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/downloadapps/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        getdownloadapps();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("Download Apps successfully removed.");
                        $(".success-msg").fadeOut(4000);
                        return false;
                    }
                });
            }
        }
    }

    // submit add or edit downloadapps form
    $("#downloadappsForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/downloadapps/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/downloadapps/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;

            formData.append('full_name', $("#full_name").val());
            formData.append('contact_number', $("#contact_number").val());
            formData.append('email', $("#email").val());

            if (selectedNode['data-downloadapps-id']) {
                formData.append('data-downloadapps-id', selectedNode['data-downloadapps-id']);
            }

            // add or edit downloadapps
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("downloadappsForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    getdownloadapps();
                    $("#downloadapps-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("Download Apps successfully updated.");
                    } else {
                        $(".success-msg").text("Download Apps successfully added.");
                    }
                    $(".success-msg").fadeOut(4000);
                    formSubmitType = null;
                    return false;
                }
            });
        };
        return false;
        event.preventDefault();
    });

    $('#downloadapps-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("downloadappsForm").reset();
    });

</script>
@stop
