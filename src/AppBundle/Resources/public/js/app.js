$(() => {
  if (basketCount !== false) {
    $.ajax({
      method: 'GET',
      url: basketCount,
    })
      .done((data) => {
        if (data.result !== false) {
          $('.menu-button .fa-shopping-cart').text(data.result);
        }
      })
      .fail(() => {
        console.log('fail');
      });
  }

  $('.cookie-popup-button-body').click(() => {
    $('.cookie-popup').hide();
    $.ajax({
      method: 'GET',
      url: cookiePopup,
    })
      .done(() => {})
      .fail(() => {});
  });

  $(window).scroll(() => {
    $('.main-left-menu').css('height', getSidebarHeight() + 'px');
  });

  function getSidebarHeight() {
    return $(window).height() + $(window).scrollTop();
  }
});