@extends("common.default")

@section("content")
<div class="container" style="margin-top:30px;">
	@include('admin/panelHeading')
        <div class="equal_to_sidebar_mrgn">
            <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
            <button type="button" onclick="addnewsletter(true)" class="btn btn-primary add-main-newsletter">Add Newsletter</button>
            <br><br>
            <b>Newsletter Management</b>
            <br><br>
            <ul id="tree3" class="ar_border" style="max-height:600px;overflow:auto;padding-left: 0px;">
            </ul>
        </div>
</div>
<div class="modal fade" id="newsletter-modal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="newsletterModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="newsletterForm" action="#" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title newsletter-title" id="newsletterModalLabel">Add Newsletter</h4>
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
                    <button type="submit" class="btn btn-primary newsletter-title">Add Newsletter</button>
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

    var getnewsletter = function() {
        $.ajax({
            type: "GET",
            url: "{{ url('/admin/newsletter/get') }}",
            success: function(res) {
                loadTree(res);
            }
        });
    }

    getnewsletter();

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
                    if (!object['data-newsletter-3-id']) {
                        appendHtml += '<a href="" onclick="addnewsletter()" class="custom-add-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-plus" style="color:#FFF;"></span></a>';
                    }
                    appendHtml += '<a href="" onclick="editnewsletter()" class="custom-edit-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-pencil" style="color:#FFF;"></span></a>';
                    if (!object.nodes) {
                        appendHtml += '<a href="" onclick="removenewsletter()" class="custom-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                    } else {
                        if (!object.nodes.length) {
                            appendHtml += '<a href="" onclick="removenewsletter()" class="custom-remove-options">&nbsp;<span class="icon expand-icon glyphicon glyphicon-remove" style="color:#FFF;"></span></a>';
                        };
                    }
                    appendHtml += '</span>';
                    $('#tree3 li.node-selected').append(appendHtml);
                }, 200);
            }
        });
    }

    // Load Categoty in Treeview

    // Add new newsletter modal display

    function addnewsletter(isMain) {
        $(".mainnewsletter").hide();
        formSubmitType = "add";
        $("#newsletter-modal").modal('show');
        $(".newsletter-title").text("Add Newsletter");
        if (isMain) {
            $(".mainnewsletter").show();
            selectedNode = {};
        }
    }

    // edit newsletter modal display

    function editnewsletter() {
        $(".mainnewsletter").hide();
        if (!selectedNode['data-newsletter-id']) {
            $(".mainnewsletter").show();
        };
        formSubmitType = "edit";
        $("#full_name").val(selectedNode.full_name);
        $("#contact_number").val(selectedNode.contact_number);
        $("#email").val(selectedNode.email);
        $("#newsletter-modal").modal('show');
        $(".newsletter-title").text("Edit Newsletter");
    }

    // remove newsletter

    function removenewsletter() {

        if (confirm('Are you sure you want to remove newsletter?')) {

            if (selectedNode) {

                if (selectedNode.nodes) {
                    delete selectedNode.nodes;
                }

                // remove newsletter form database
                $.ajax({
                    type: "POST",
                    url: "{{ url('/admin/newsletter/remove') }}",
                    data: selectedNode,
                    success: function(res) {
                        selectedNode = null;
                        formSubmitType = null;
                        getnewsletter();
                        $(".success-msg").fadeIn();
                        $(".success-msg").text("Newsletter successfully removed.");
                        $(".success-msg").fadeOut(4000);
                        return false;
                    }
                });
            }
        }
    }

    // submit add or edit newsletter form
    $("#newsletterForm").on("submit", function(event) {

        if (selectedNode) {

            if (!formSubmitType) {
                return false;
            };

            var url = "{{ url('/admin/newsletter/add') }}";
            if (formSubmitType == 'edit') {
                url = "{{ url('/admin/newsletter/edit') }}";
            }

            if (selectedNode.nodes) {
                delete selectedNode.nodes;
            }

            var formData = new FormData();;

            formData.append('full_name', $("#full_name").val());
            formData.append('contact_number', $("#contact_number").val());
            formData.append('email', $("#email").val());

            if (selectedNode['data-newsletter-id']) {
                formData.append('data-newsletter-id', selectedNode['data-newsletter-id']);
            }

            // add or edit newsletter
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                cache: false,
                dataType: 'json',
                processData: false, // Don't process the files
                contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                success: function(data, textStatus, jqXHR) {
                    document.getElementById("newsletterForm").reset();
                    selectedNode = null;
                    formData = null;
                    logoFile = null;
                    getnewsletter();
                    $("#newsletter-modal").modal('hide');
                    $(".success-msg").fadeIn();
                    if (formSubmitType == 'edit') {
                        $(".success-msg").text("Newsletter successfully updated.");
                    } else {
                        $(".success-msg").text("Newsletter successfully added.");
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

    $('#newsletter-modal').on('hidden.bs.modal', function(e) {
        selectedNode = null;
        formSubmitType = null;
        document.getElementById("newsletterForm").reset();
    });

</script>
@stop
