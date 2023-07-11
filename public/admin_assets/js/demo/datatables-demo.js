// Call the dataTables jQuery plugin
/* $(document).ready(function() {
  $('#dataTable').DataTable();
});
 */

//var table = new DataTable('#dataTable');

var table = new DataTable('#dataTable', {
  language: {
      url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
  },
  responsive: true,
  autoWidth: false,
  order: [[0, 'desc']]
});