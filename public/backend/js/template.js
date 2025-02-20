(function($) {
  'use strict';
  $(function() {
    var body = $('body');
    var sidebar = $('.sidebar');

    // Enable feather-icons with SVG markup
    feather.replace();

    // Close other submenus at the same level while keeping parents open
    sidebar.on('show.bs.collapse', '.collapse', function(event) {
      var $this = $(this);

      // Only close sibling menus at the same level
      $this.closest('.nav-item, .submenu-item')
        .siblings('.nav-item, .submenu-item')
        .find('.collapse.show')
        .collapse('hide');
    });

    // Handle two-level menu (First & Second level)
    sidebar.on('click', '.nav-item.has-submenu > .nav-link', function(e) {
      e.preventDefault();
      var $submenu = $(this).next('.collapse');

      // Keep parent menu open
      if (!$submenu.hasClass('show')) {
        $submenu.collapse('show');
      } else {
        $submenu.collapse('hide');
      }
    });

    // Handle three-level menu (Third level)
    sidebar.on('click', '.submenu-item.has-submenu > .nav-link', function(e) {
      e.preventDefault();
      var $subsubmenu = $(this).next('.collapse');

      // Keep second-level menu open while toggling third-level
      if (!$subsubmenu.hasClass('show')) {
        $subsubmenu.collapse('show');
      } else {
        $subsubmenu.collapse('hide');
      }
    });

    // Sidebar toggle
    $('.sidebar-toggler').on('click', function(e) {
      e.preventDefault();
      if (window.matchMedia('(min-width: 992px)').matches) {
        body.toggleClass('sidebar-folded');
      } else {
        body.toggleClass('sidebar-open');
      }
    });

    // Close sidebar when clicking outside on mobile
    $(document).on('click touchstart', function(e) {
      if (!$(e.target).closest('.sidebar, .sidebar-toggler').length) {
        body.removeClass('sidebar-open');
      }
    });
  });
})(jQuery);
