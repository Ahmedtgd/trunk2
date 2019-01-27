@extends("common.default")


@section("content")
<div class="container" style="margin-top:30px;">
    @include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
            <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
            <button type="button" onclick="addtermsandCondition(true)" class="btn btn-primary add-main-termsandCondition">Add Terms & Condition</button>
            <br><br>
            <b>Terms & Condition Management</b>
            <br><br>
            <ul id="tree3" class="ar_border" style="max-height:600px;overflow:auto;padding-left: 0px;">
            </ul>
        </div>
</div>
<div class="modal fade" id="termsandCondition-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="termsandConditionModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="termsandConditionForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title termsandCondition-title" id="termsandConditionModalLabel">Add Terms & Condition</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ip_address" class="control-label">Ip Address</label>
                        <input type="text" class="form-control" name="ip_address" id="ip_address" required>
                    </div>
                    <div class="form-group">
                        <label for="agree" class="control-label">Agree</label>
                        <input type="checkbox" class="form-control" name="agree" id="agree">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary termsandCondition-title">Add Terms & Condition</button>
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

    var gettermsandCondition = function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/admin/termsandcondition/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    gettermsandCondition();

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
                    appendHtml += '<a href="" onclick="edittermsandCondition()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removetermsandCondition()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removetermsandCondition()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new termsandCondition modal display

    function addtermsandCondition(isMain) {
        $(".maintermsandCondition").hide();
        formSubmitType = "add";
        $("#termsandCondition-modal").modal('show');
        $(".termsandCondition-title").text("Add Terms & Condition");
        if (isMain) {
            $(".maintermsandCondition").show();
            selectedNode = {};
        }
    }

    // edit termsandCondition modal display

    function edittermsandCondition() {
        $(".maintermsandCondition").hide();
        if (!selectedNode['data-termsandcondition-id']) {
            $(".maintermsandCondition").show();
        };
        formSubmitType = "edit";
        $("#ip_address").val(selectedNode.ip_address);
         if(selectedNode.agree === 1){
            $("#agree").attr('checked',true);
        }else{
            $("#agree").attr('checked',false);
        }
        $("#termsandCondition-modal").modal('show');
        $(".termsandCondition-title").text("Edit Terms & Condition");
    }

    // remove termsandCondition

    function removetermsandCondition() {

        if (confirm('Are you sure you want to remove termsandCondition?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove termsandCondition form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/termsandcondition/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        gettermsandCondition();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("termsandCondition successfully removed.");
                        $(".success-msg").fadeOut(4000);
                        return false;
                    }
                });
            }
        }
    }

    // submit add or edit termsandCondition form
    $("#termsandConditionForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/termsandcondition/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/termsandcondition/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;
            formData.append('ip_address', $("#ip_address").val());
            if($('#agree').is(':checked'))
                formData.append('agree', 1);
            else
                formData.append('agree', 0);

            if (selectedNode['data-termsandcondition-id']) {
                formData.append('data-termsandcondition-id', selectedNode['data-termsandcondition-id']);
            }

            // add or edit termsandCondition
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("termsandConditionForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    gettermsandCondition();
                    $("#termsandCondition-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("termsandCondition successfully updated.");
                    } else {
                        $(".success-msg").text("termsandCondition successfully added.");
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

    $('#termsandCondition-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("termsandConditionForm").reset();
    });

</script>
@stop
