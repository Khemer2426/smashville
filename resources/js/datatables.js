
class pageTablesDatatables {
    /*
     * Init DataTables functionality
     *
     */
    static initDataTables() {
      // Override a few default classes
      jQuery.extend(jQuery.fn.DataTable.ext.classes, {
        sWrapper: "dataTables_wrapper dt-bootstrap5",
        sFilterInput: "form-control form-control-sm",
        sLengthSelect: "form-select form-select-sm"
      });
  
      // Override a few defaults
      jQuery.extend(true, jQuery.fn.DataTable.defaults, {
        language: {
          lengthMenu: "_MENU_",
          search: "_INPUT_",
          searchPlaceholder: "Search..",
          info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>",
          paginate: {
            first: '<i class="fa fa-angle-double-left"></i>',
            previous: '<i class="fa fa-angle-left"></i>',
            next: '<i class="fa fa-angle-right"></i>',
            last: '<i class="fa fa-angle-double-right"></i>'
          }
        }
      });
  
      // Init full DataTable
      jQuery('.js-dataTable-full').dataTable({
        pageLength: 20,
        lengthMenu: [[10, 20, 30], [10, 20, 30]],
        autoWidth: false,
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
    }
  }
  
  // Initialize when page loads
  One.onLoad(() => pageTablesDatatables.init());
  