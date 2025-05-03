import jsRequest from "../../jsRequest.js";

class adminUsersDatatable {
  
  static initDataTables() {
    var backendUsersTable = $('.table-users').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/admin/users',
      columns: [
          {data: 'user_fullname', name: 'user_fullname', orderable: true, searchable: false},
          {data: 'username', name: 'username', orderable: true, searchable: false},
          {data: 'job_html', name: 'job_html', orderable: true, searchable: false},
          {data: 'status_name', name: 'status_name', orderable: false, searchable: false},
          {data: 'actions', orderable: false, searchable: false, width: 300}
      ],
      order: [[ 0, "asc" ]],
      autoWidth: false,
      initComplete: function() {
        $('.dataTables_filter input').unbind();
        $('.dataTables_filter input').bind('keyup', function(e) {
            if(e.keyCode == 13) {
              backendUsersTable.search(this.value).draw();
            }
        });
      },
      createdRow: function (row, data, dataIndex) {
        $('td', row).addClass('fs-sm');
      },
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initDataTables();
    jsRequest.bindRequest('#create-user', 'New user has been created successfully.');
    jsRequest.onClickConfirm('.btn-delete', 'Are you sure you want to delete?', 'The user has been deleted successfully.', 'DELETE');
    jsRequest.onClickConfirm('.btn-unlock', 'Are you sure you want to unlock this user?', 'The user has been unlocked successfully.');
  }
}

// Initialize when page loads
One.onLoad(() => adminUsersDatatable.init());
