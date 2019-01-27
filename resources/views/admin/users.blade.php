@extends("common.default")

@section('extra-links')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
@stop

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-sm-3 ">
                @include('admin/leftSidebar')
            </div>
            <div class="col-md-9 equal_to_sidebar_mrgn">
                <p class="bg-success success-msg" style="display:none;padding: 15px;"></p>
                <button type="button" class="btn btn-primary add-main-category" onclick="userShowModal()">Add User
                </button>
                <br><br>
                <b>User Management</b>
                <br><br>
                <div id="usersMgmt">
                    <table id="dynamic-table" class="table table-striped table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="userModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="userForm" class="form-horizontal" action="#">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title category-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div id="submissionError"></div>
                        <div class="form-group">
                            <label for="firstName" class="col-sm-4 control-label">First Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="firstName" id="firstName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="col-sm-4 control-label">Last Name:</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="lastName" id="lastName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birthdate" class="col-sm-4 control-label">Birth date</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="birthdate" id="birthdate" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country" class="col-sm-4 control-label">Country</label>
                            <div class="col-sm-8">
                                {!! Form::select('country', $countries, null, ['id' => 'country']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="col-sm-4 control-label">Gender</label>
                            <div class="col-sm-8">
                                {!! Form::select('gender', ['male' => 'male','female' => 'female'], null, ['id' => 'gender']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobilePhone" class="col-sm-4 control-label">Mobile Phone</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="mobilePhone" id="mobilePhone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="language" class="col-sm-4 control-label">Language</label>
                            <div class="col-sm-8">
                                {!! Form::select('language', $languages, null, ['id' => 'language']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="occupation" class="col-sm-4 control-label">Occupation</label>
                            <div class="col-sm-8">
                                {!! Form::select('occupation', $occupations, null, ['id' => 'occupation']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="roles" class="col-sm-4 control-label">Roles</label>
                            <div class="col-sm-8">
                                {!! Form::select('roles[]', $roles, null, ['id' => 'roles', 'multiple' => 'multiple']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="occupation" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="occupation" class="col-sm-4 control-label">Confirm Password</label>
                            <div class="col-sm-8">
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary category-title">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script>
        var userToEdit = null;
        var formSubmitType = null;

        function userShowModal() {
            $('#birthdate').datetimepicker({format: 'DD/MM/YYYY'});
            $('.select2-container').css('width', '100%');
            $("#userModal").modal('show');
        }

        $('#userModal').on('hidden.bs.modal', function () {
            userToEdit = null;
            formSubmitType = null;
            $('#userForm').trigger("reset");
            $('#roles').val(null).trigger("change");
            // empty the validation error tags
            $('#submissionError').empty();

        });

        $('#userModal').on('show.bs.modal', function () {

            if (formSubmitType == 'edit') {
                $('.modal-title').text('Edit User');
                $('.modal-footer>button:submit').text('Edit User')
            } else {
                $('.modal-title').text('Add User');
                $('.modal-footer>button:submit').text('Add User')
            }

        });

        $(document).ready(function () {


            var table = $("#dynamic-table").DataTable({
                "ajax": {
                    "url": "{{ route('user.all') }}",
                    "type": "GET",
                    "dataSrc": "",
                },
                "columns": [
                    {data: 'first_name'},
                    {data: 'last_name'},
                    {data: 'email'},
                    {
                        data: 'roles',
                        render: function (data) {

                            if (data.length > 0) {
                                var rolesHtml = '';

                                for (key in data) {
                                    if (data[key].hasOwnProperty('description'))
                                        rolesHtml += '<span class="label label-primary">' + data[key].description + '</span>&nbsp;';
                                }

                                return rolesHtml;
                            }

                            return '<span class="label label-default">Not Specified</span>&nbsp;';
                        }
                    },
                    {data: 'last_login'},
                    {
                        data: null,
                        render: function (data) {
                            return '<div class="btn-group" role="group">' +
                                    '<button data-edit-id="' + data.id + '" type="button" class="btn btn-default"><i class="fa fa-edit"></i></button>' +
                                    '<button data-remove-id="' + data.id + '" type="button" class="btn btn-warning"><i class="fa fa-trash"></i></button>' +
                                    '</div>';
                        }
                    }
                ],
                "displayLength": 10,
                "lengthChange": false,
            });

            table.on('click', 'button[data-edit-id]', function () {
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.single') }}",
                    data: {id: $(this).attr('data-edit-id')},
                    success: function (data, textStatus, jqXHR) {
                        userToEdit = data.id;
                        formSubmitType = 'edit';
                        console.log(data);

                        var roles = [];
                        if (data.hasOwnProperty('roles')) {
                            for (var key in data.roles) {
                                if (data.roles[key].hasOwnProperty('id'))
                                    roles.push(data.roles[key].id);
                                ;
                            }
                        }

                        console.log(roles);

                        $('#firstName').val(data.first_name);
                        $('#lastName').val(data.last_name);
                        $('#birthdate').val(data.birthdate);
                        $('#country').val(data.nationality_country_id);
                        $('#gender').val(data.gender);
                        $('#email').val(data.email);
                        $('#mobilePhone').val(data.mobile_no);
                        $('#language').val(data.language_id);
                        $('#roles').val(roles).trigger("change");
                        $('#occupation').val(data.occupation_id);

                        userShowModal();
                    }
                });

            });

            table.on('click', 'button[data-remove-id]', function () {
                if (confirm('Are you sure you want to remove User')) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.remove') }}",
                        data: {id: $(this).attr('data-remove-id')},
                        success: function (data, textStatus, jqXHR) {
                            if (jqXHR.responseJSON) {
                                //reload the table via ajax
                                console.log('after table reload');
                                // display the success message
                                $(".success-msg").fadeIn();
                                $(".success-msg").text("User successfully removed.");
                                $(".success-msg").fadeOut(4000);

                                table.ajax.reload();
                            }
                        }
                    });
                }
            });

            $('#userForm').on('submit', function (event) {

                var formUrl = "{{ route('user.add') }}";
                var formData = new FormData(this);

                if (formSubmitType == 'edit') {
                    formUrl = "{{ route('user.edit') }}";
                    formData.append('id', userToEdit);
                }

                $.ajax({
                    url: formUrl,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function (data, textStatus, jqXHR) {

                        console.log(data);

                        if (jqXHR.status == 200 && jqXHR.responseJSON) {
                            //Hide the modal
                            $("#userModal").modal('hide');
                            //display the success message
                            $(".success-msg").fadeIn();
                            $(".success-msg").text("User successfully added.");
                            $(".success-msg").fadeOut(4000);
                            //reload the table via ajax
                            table.ajax.reload();
                        }
                    },
                    error: function (jqXHR) {
                        console.log(jqXHR);
                        if (jqXHR.status === 422) {
                            var errors = jqXHR.responseJSON; //this will get the errors response data.

                            errorsHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors, function (key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                            });
                            errorsHtml += '</ul></di>';

                            //appending to a <div id="submissionError"></div> inside form
                            $('#submissionError').html(errorsHtml);
                        }
                    }
                });

                event.preventDefault();
            });
        });
    </script>
@stop
