@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
            <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
            <button type="button" onclick="addsellerHelp(true)" class="btn btn-primary add-main-sellerHelp">Add Seller Help</button>
            <br><br>
            <b>Seller Help Management</b>
            <br><br>
            <ul id="tree3" class="ar_border" style="max-height:600px;overflow:auto;padding-left: 0px;">
            </ul>
        </div>
</div>
<div class="modal fade" id="sellerHelp-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="sellerHelpModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="sellerHelpForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title sellerHelp-title" id="sellerHelpModalLabel">Add Seller Help</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="control-label">Company</label>
                        <input type="text" class="form-control" name="company_name" id="company_name" required>
                    </div>
                    <div class="form-group">
                        <label for="business_reg_no" class="control-label">Business Reg No</label>
                        <input type="text" class="form-control" name="business_reg_no" id="business_reg_no" required>
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
                    <button type="submit" class="btn btn-primary sellerHelp-title">Add Seller Help</button>
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

    var getsellerHelp = function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/admin/sellerhelp/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    getsellerHelp();

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
                    appendHtml += '<a href="" onclick="editsellerHelp()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removesellerHelp()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removesellerHelp()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new sellerHelp modal display

    function addsellerHelp(isMain) {
        $(".mainsellerHelp").hide();
        formSubmitType = "add";
        $("#sellerHelp-modal").modal('show');
        $(".sellerHelp-title").text("Add Seller Help");
        if (isMain) {
            $(".mainsellerHelp").show();
            selectedNode = {};
        }
    }

    // edit sellerHelp modal display

    function editsellerHelp() {
        $(".mainsellerHelp").hide();
        if (!selectedNode['data-sellerHelp-id']) {
            $(".mainsellerHelp").show();
        };
        formSubmitType = "edit";
        $("#name").val(selectedNode.name);
        $("#company_name").val(selectedNode.company_name);
        $("#business_reg_no").val(selectedNode.business_reg_no);
        $("#phone").val(selectedNode.phone);
        $("#email").val(selectedNode.email);
        $("#remarks").val(selectedNode.remarks);
        $("#sellerHelp-modal").modal('show');
        $(".sellerHelp-title").text("Edit Seller Help");
    }

    // remove sellerHelp

    function removesellerHelp() {

        if (confirm('Are you sure you want to remove sellerHelp?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove sellerHelp form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/sellerhelp/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        getsellerHelp();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("Seller Help successfully removed.");
                        $(".success-msg").fadeOut(4000);
                        return false;
                    }
                });
            }
        }
    }

    // submit add or edit sellerHelp form
    $("#sellerHelpForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/sellerhelp/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/sellerhelp/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;

            formData.append('name', $("#name").val());
            formData.append('company_name', $("#company_name").val());
            formData.append('business_reg_no', $("#business_reg_no").val());
            formData.append('phone', $("#phone").val());
            formData.append('remarks', $("#remarks").val());
            formData.append('email', $("#email").val());

            if (selectedNode['data-sellerHelp-id']) {
                formData.append('data-sellerHelp-id', selectedNode['data-sellerHelp-id']);
            }

            // add or edit sellerHelp
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("sellerHelpForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    getsellerHelp();
                    $("#sellerHelp-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("Seller Help successfully updated.");
                    } else {
                        $(".success-msg").text("Seller Help successfully added.");
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

    $('#sellerHelp-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("sellerHelpForm").reset();
    });

</script>
@stop
