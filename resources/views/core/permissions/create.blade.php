<div class="modal fade" id="modalCreatePermission" tabindex="-1" role="dialog" aria-labelledby="modalCreatePermissionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formPermissionCreate" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreatePermissionLabel">Create Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label for="name" class="mb-1">Name</label>
                        <input type="text" name="name" placeholder="Name" class="form-control" id="name">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="roles" class="mb-1">Roles</label>
                        <select name="roles[]" id="roles" class="form-control select2" multiple></select>
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
        $('#modalCreatePermission').on('show.bs.modal', function() {

            ajaxRequest({
                url: `/apis/roles`,
            }).done((response) => {
                setDataSelect({
                    tagid: '#roles',
                    modalid: '#modalCreatePermission',
                    data: response.data.map((item) => {
                        return {
                            id: item.name,
                            text: item.name,
                        }
                    }),
                    placeholder: 'Select Role',
                })
            })

            $('#formPermissionCreate').ajaxForm({
                url: '/core/permissions',
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

                    $('#permission-table').DataTable().ajax.reload()
                    $('#modalCreatePermission').modal('toggle')
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