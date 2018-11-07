import tippy from 'tippy.js';

// Display dropdown menu on button click
$('.qm-dropdown-button').on('click', function() {
  $(this).parent().find('.qm-dropdown-menu').toggle();
});

// Display record data
$('.qm-view-data').on('click', function() {
  var id = $(this).data('job-id');

  $('.qm-table-data[data-job-id=' + id + ']').toggle();
});
