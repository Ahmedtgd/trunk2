@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
            <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
            <button type="button" onclick="addbuyerHelp(true)" class="btn btn-primary add-main-buyerHelp">Add Buyer Help</button>
            <br><br>
            <b>Buyer Help Management</b>
            <br><br>
            <ul id="tree3" class="ar_border" style="max-height:600px;overflow:auto;padding-left: 0px;">
            </ul>
        </div>
</div>
<div class="modal fade" id="buyerHelp-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="buyerHelpModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="buyerHelpForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title buyerHelp-title" id="buyerHelpModalLabel">Add Buyer Help</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="porder_id" class="control-label">Order ID</label>
                        <input type="text" class="form-control" name="porder_id" id="porder_id" required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="control-label">Remarks</label>
                        <input type="text" class="form-control" name="remarks" id="remarks" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary buyerHelp-title">Add Buyer Help</button>
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

    var getbuyerHelp = function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/admin/buyerhelp/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    getbuyerHelp();

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
                    appendHtml += '<a href="" onclick="editbuyerHelp()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removebuyerHelp()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removebuyerHelp()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new buyerHelp modal display

    function addbuyerHelp(isMain) {
        $(".mainbuyerHelp").hide();
        formSubmitType = "add";
        $("#buyerHelp-modal").modal('show');
        $(".buyerHelp-title").text("Add Buyer Help");
        if (isMain) {
            $(".mainbuyerHelp").show();
            selectedNode = {};
        }
    }

    // edit buyerHelp modal display

    function editbuyerHelp() {
        $(".mainbuyerHelp").hide();
        if (!selectedNode['data-buyerHelp-id']) {
            $(".mainbuyerHelp").show();
        };
        formSubmitType = "edit";
        $("#name").val(selectedNode.name);
        $("#porder_id").val(selectedNode.porder_id);
        $("#phone").val(selectedNode.phone);
        $("#email").val(selectedNode.email);
        $("#remarks").val(selectedNode.remarks);
        $("#buyerHelp-modal").modal('show');
        $(".buyerHelp-title").text("Edit Buyer Help");
    }

    // remove buyerHelp

    function removebuyerHelp() {

        if (confirm('Are you sure you want to remove buyerHelp?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove buyerHelp form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/buyerhelp/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        getbuyerHelp();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("Buyer Help successfully removed.");
                        $(".success-msg").fadeOut(4000);
                        return false;
                    }
                });
            }
        }
    }

    // submit add or edit buyerHelp form
    $("#buyerHelpForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/buyerhelp/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/buyerhelp/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;

            formData.append('name', $("#name").val());
            formData.append('porder_id', $("#porder_id").val());
            formData.append('phone', $("#phone").val());
            formData.append('remarks', $("#remarks").val());
            formData.append('email', $("#email").val());

            if (selectedNode['data-buyerHelp-id']) {
                formData.append('data-buyerHelp-id', selectedNode['data-buyerHelp-id']);
            }

            // add or edit buyerHelp
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("buyerHelpForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    getbuyerHelp();
                    $("#buyerHelp-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("Buyer Help successfully updated.");
                    } else {
                        $(".success-msg").text("Buyer Help successfully added.");
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

    $('#buyerHelp-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("buyerHelpForm").reset();
    });

</script>
@stop
