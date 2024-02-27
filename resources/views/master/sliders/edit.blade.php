<div class="modal fade" id="modalUpdateSlider" tabindex="-1" role="dialog" aria-labelledby="modalUpdateSliderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="formSliderUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateSliderLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <label for="slider_name" class="mb-1">Name</label>
                        <input type="text" name="slider_name" placeholder="Name" class="form-control" id="e_slider_name">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="slider_link" class="mb-1">Link</label>
                        <input type="text" name="slider_link" placeholder="Link" class="form-control" id="e_slider_link">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="slider_group" class="mb-1">Group</label>
                        <select name="slider_group" id="e_slider_group" class="form-control select2">
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="slider_featureimage" class="mb-1">Feature Image</label>
                        <input type="file" name="slider_featureimage" placeholder="Name" class="form-control" id="e_slider_featureimage">
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
        $('#modalUpdateSlider').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/sliders/${id}`,
            }).done((sliders) => {
                $('#e_slider_name').val(sliders.data.slider_name)
                $('#e_slider_link').val(sliders.data.slider_link)

                setDataSelect({
                    tagid: '#e_slider_group',
                    data: [{
                        id: 'slider',
                        text: 'Slider',
                    }, {
                        id: 'iklan',
                        text: 'Iklan',
                    }],
                    dataSelected: sliders.data.slider_group,
                    placeholder: 'Select Group',
                    modalid: '#modalUpdateSlider'
                });
            })

            $('#formSliderUpdate').ajaxForm({
                url: `/master/sliders/${id}`,
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
                    $('#modalUpdateSlider').modal('toggle')
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