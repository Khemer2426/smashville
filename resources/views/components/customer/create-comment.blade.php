<div class="modal fade" id="add-comment-modal" tabindex="-1" role="dialog" aria-labelledby="add-comment-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Add New Comment</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content block-content-full">
            <form action="{{ route('admin.customer.store.comment') }}" method="post" id="create-comment">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" name="title" id="title" placeholder="title" required>
                            <label for="title">Title</label>
                        </div>
                        <div class="form-floating mb-4">
                            <textarea class="form-control" name="comment" id="comment" placeholder="Comment" style="height: 200px;" required></textarea>
                            <label for="comment">Comment</label>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary btn-submit">Add Comment</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>