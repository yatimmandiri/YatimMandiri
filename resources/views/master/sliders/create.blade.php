<div class="modal fade" id="modalCreateSlider" tabindex="-1" role="dialog" aria-labelledby="modalCreateSliderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formSliderCreate" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateSliderLabel">Create Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label for="slider_name" class="mb-1">Name</label>
                        <input type="text" name="slider_name" placeholder="Name" class="form-control" id="slider_name">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="slider_link" class="mb-1">Link</label>
                        <input type="text" name="slider_link" placeholder="Link" class="form-control" id="slider_link">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="slider_group" class="mb-1">Group</label>
                        <select name="slider_group" id="slider_group" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="slider_featureimage" class="mb-1">Feature Image</label>
                        <input type="file" name="slider_featureimage" placeholder="Name" class="form-control" id="slider_featureimage">
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
        $('#modalCreateSlider').on('show.bs.modal', function() {
            setDataSelect({
                tagid: '#slider_group',
                data: [{
                    id: 'slider',
                    text: 'Slider',
                }, {
                    id: 'iklan',
                    text: 'Iklan',
                }],
                placeholder: 'Select Group',
                modalid: '#modalCreateSlider'
            });

            $('#formSliderCreate').ajaxForm({
                url: '/master/sliders',
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

                    $('#slider-table').DataTable().ajax.reload()
                    $('#modalCreateSlider').modal('toggle')
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