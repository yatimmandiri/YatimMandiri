<div class="modal fade" id="modalUpdateUser" tabindex="-1" role="dialog" aria-labelledby="modalUpdateUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formUserUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateUserLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="e_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email" class="mb-1">Email</label>
                        <input type="email" name="email" placeholder="Email" class="form-control" id="e_email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password" class="mb-1">Password</label>
                        <input type="password" name="password" placeholder="Password" class="form-control" id="e_password" autocomplete="true">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="roles" class="mb-1">Roles</label>
                        <select name="roles" id="e_roles" class="form-control select2"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="updateData" onclick="$(this).submit()">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="module">
    $(document).ready(function() {

        $('#modalUpdateUser').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/users/${id}`,
            }).done((users) => {
                $('#e_name').val(users.data.name)
                $('#e_email').val(users.data.email)

                ajaxRequest({
                    url: `/apis/roles`,
                }).done((roles) => {
                    setDataSelect({
                        tagid: '#e_roles',
                        modalid: '#modalUpdateUser',
                        data: roles.data.map((item) => {
                            return {
                                id: item.name,
                                text: item.name,
                            }
                        }),
                        dataSelected: users.data.relationship.roles.map((item) => {
                            return item.name
                        }),
                        placeholder: 'Select Role',
                    })
                })
            })

            $('#formUserUpdate').ajaxForm({
                url: `/core/users/${id}`,
                type: 'POST',
                resetForm: true,
                beforeSubmit: function(formData) {
                    var formSerialize = $.param(formData);
                    return true;
                },
                success: function(result) {
                    Toast.fire({
                        icon: 'success',
                        title: result.message
                    })

                    $('#user-table').DataTable().ajax.reload()
                    $('#modalUpdateUser').modal('toggle')
                },
                error: function(errors) {
                    Toast.fire({
                        icon: 'error',
                        title: errors.responseJSON.message,
                    })
                }
            });
        })

    })
</script>