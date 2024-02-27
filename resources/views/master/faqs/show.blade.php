<div class="modal fade" id="modalInfoFaq" tabindex="-1" role="dialog" aria-labelledby="modalInfoFaqLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoFaqLabel">Info Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <tr>
                        <td>Name</td>
                        <td id="info_faq_name"></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td id="info_faq_description"></td>
                    </tr>
                    <tr>
                        <td>Categories</td>
                        <td id="info_categories"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="module">
    $(document).ready(function() {
        $('#modalInfoFaq').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/faqs/${id}`,
            }).done((response) => {
                $('#info_faq_name').text(response.data.faq_name)
                $('#info_faq_description').text(response.data.faq_content)
                $('#info_categories').text(response.data.relationship.categories.categories_name)
            })
        })
    })
</script>