import jsRequest from "../../jsRequest.js";

class editUser {
  /*
   * Init functionality
   *
   */
  static init() {
    jsRequest.bindRequest('#update-user', 'The user has been updated successfully.');
    jsRequest.bindRequest('#assign-school', 'The school has been assigned to a user successfully.');
    jsRequest.onClickConfirm('.btn-delete', 'Are you sure you want to remove this school from a user?', 'The school has been removed from a user successfully.', 'DELETE');
  }
}

// Initialize when page loads
One.onLoad(() => editUser.init());
