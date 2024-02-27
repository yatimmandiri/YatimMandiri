<div class="modal fade" id="modalCreateUser" tabindex="-1" role="dialog" aria-labelledby="modalCreateUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formUserCreate" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateUserLabel">Create Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email" class="mb-1">Email</label>
                        <input type="email" name="email" placeholder="Email" class="form-control" id="email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password" class="mb-1">Password</label>
                        <input type="password" name="password" placeholder="Password" class="form-control" id="password" autocomplete="true">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="roles" class="mb-1">Roles</label>
                        <select name="roles" id="roles" class="form-control select2"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitData" onclick="$(this).submit()">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#modalCreateUser').on('show.bs.modal', function() {

            ajaxRequest({
                url: `/apis/roles`,
            }).done((response) => {
                setDataSelect({
                    tagid: '#roles',
                    modalid: '#modalCreateUser',
                    data: response.data.map((item) => {
                        return {
                            id: item.name,
                            text: item.name,
                        }
                    }),
                    placeholder: 'Select Role',
                })
            })

            $('#formUserCreate').ajaxForm({
                url: '/core/users',
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
                    $('#modalCreateUser').modal('toggle')
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