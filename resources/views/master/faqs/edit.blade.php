<div class="modal fade" id="modalUpdateFaq" tabindex="-1" role="dialog" aria-labelledby="modalUpdateFaqLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" id="formFaqUpdate" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateFaqLabel">Update Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6">
                        <label for="faq_name" class="mb-1">Name</label>
                        <input type="text" name="faq_name" placeholder="Name" class="form-control" id="e_faq_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="categories_id" class="mb-1">Categories</label>
                        <select name="categories_id" id="e_categories_id" class="form-control select2"></select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="faq_content" class="mb-1">Content</label>
                        <textarea name="faq_content" id="e_faq_content" class="form-control" cols="30" rows="10"></textarea>
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
        $('#modalUpdateFaq').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/faqs/${id}`,
            }).done((faqs) => {
                $('#e_faq_name').val(faqs.data.faq_name)
                $('#e_faq_content').val(faqs.data.faq_content)

                ajaxRequest({
                    url: `/apis/categories`,
                }).done((categories) => {
                    setDataSelect({
                        tagid: '#e_categories_id',
                        modalid: '#modalUpdateFaq',
                        data: categories.data.map((item) => {
                            return {
                                id: item.id,
                                text: item.categories_name,
                            }
                        }),
                        dataSelected: faqs.data.categories_id,
                        placeholder: 'Select Categories',
                    })
                })

            })

            $('#formFaqUpdate').ajaxForm({
                url: `/master/faqs/${id}`,
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

                    $('#faq-table').DataTable().ajax.reload()
                    $('#modalUpdateFaq').modal('toggle')
                },
                error: function(errors) {
                    Toast.fire({
                        icon: 'error',
                        title: errors.responseJSON.message,
                    })
                }
            })
        })
    })
</script>