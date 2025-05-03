<div class="modal fade" id="add-customer-modal" tabindex="-1" role="dialog" aria-labelledby="add-customer-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
          <div class="block-header block-header-default">
            <h3 class="block-title">Add New Customer</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa fa-fw fa-times"></i>
              </button>
            </div>
          </div>
          <div class="block-content block-content-full">
            <form action="{{ route('admin.customer.store') }}" method="post" id="create-customer">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="col-12">
                      <div class="form-floating mb-4">
                          <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation" required>
                          <label for="password_confirmation">Password Confirmation</label>
                      </div>
                  </div>
                    <div class="col-12">
                      <div class="form-floating mb-4">
                          <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Surname & Name" required>
                          <label for="full_name">Surname & Name</label>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-floating mb-4">
                          <select name="role" class="form-control form-select" id="role" required>
                              <option value="customer">Customer</option>                     
                          </select>
                          <label for="role">Role</label>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-floating mb-4">
                          <select name="active" class="form-control form-select" id="active" required>
                              <option value="">Choose option</option> 
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                          </select>
                          <label for="active">Active</label>
                      </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary btn-submit">Add Customer</button>
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