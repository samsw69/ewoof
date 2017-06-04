console.log('JS Connected!')
$(() => {
  const $header = $('header');
  const $window = $(window);
  const $links = $('nav a');
  const $menu = $('.menu');



  $window.scroll(updateHeader).trigger('scroll');
  $links.on('click', scrollToSection);
  $menu.on('click', toggleMenu);


  function toggleMenu() {
    $('.dropdown').slideToggle();
  }

  function updateHeader() {
    const bottomOfHeader = $header.offset().top + $header.height();
    const viewportHeight = $window.height();

    if (bottomOfHeader >= viewportHeight) {
      $header.addClass('opaque');
    } else {
      $header.removeClass('opaque');
    }
  }

  function scrollToSection() {
    const section = $(this).attr('href');
    $('body').animate( {
      scrollTop: $(section).offset().top
    }, 1000, () => {
      if ($window.width() < 575) {
        $('dropdown').slideToggle();
      }
    });
  }
});
