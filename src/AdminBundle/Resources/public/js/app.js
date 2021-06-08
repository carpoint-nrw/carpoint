$(() => {
  $('.sidebar').css('height', getSidebarHeight() + 'px');

  window.onresize = () => {
    $('.sidebar').css('height', getSidebarHeight() + 'px');
  };

  let $mainBody = $('.main-padding');
  let $sidebar = $('.sidebar-main');
  if (sidebar) {
    $sidebar
      .css('display', 'block')
      .css('width', '8%')
      .addClass('sidebar-active');
    $mainBody.css('width', '92%');
  } else {
    $('.fa-angle-double-right').toggleClass('transform');
    $mainBody.css('width', '100%');
  }

  $('.sidebar-size-icon').click(() => {
    $sidebar
      .css('width', '8%')
      .animate({width:'toggle'}, 350);
    let $sidebarActive = $('.sidebar-active');
    let $type = false;
    if ($sidebarActive.length > 0) {
      $sidebarActive.removeClass('sidebar-active');
      $mainBody.css('width', '100%');
    } else {
      $type = true;
      $sidebar.addClass('sidebar-active');
      $mainBody.css('width', '92%');
    }
    $('.fa-angle-double-right').toggleClass('transform');

    $.ajax({
      method: 'GET',
      url: changeSidebar,
      data: {
        'userId': userId,
        'type': $type
      },
    })
      .done($data => {})
      .fail(() => {});
  });

  function getSidebarHeight() {
    let $bodyHeight = $('body').innerHeight();
    let $browserHeight = window.innerHeight;
    return $bodyHeight < $browserHeight ? $browserHeight : $bodyHeight;
  }
});