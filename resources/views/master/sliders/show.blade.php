<div class="modal fade" id="modalInfoSlider" tabindex="-1" role="dialog" aria-labelledby="modalInfoSliderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInfoSliderLabel">Info Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <tr>
                        <td>Name</td>
                        <td id="info_slider_name"></td>
                    </tr>
                    <tr>
                        <td>Link</td>
                        <td id="info_slider_link"></td>
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
        $('#modalInfoSlider').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');

            ajaxRequest({
                url: `/apis/sliders/${id}`,
            }).done((sliders) => {
                $('#info_slider_name').text(sliders.data.slider_name)
                $('#info_slider_link').text(sliders.data.slider_link)
            })
        })
    })
</script>