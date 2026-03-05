$(document).ready(function(){
    $('.slick-container').slick({
      arrows: true,
      dots: true,
      infinite: true,
      // lazyLoad:'ondemand',
      slidesToShow: 3,
      slidesToScroll: 3,
      variableWidth: true,
      // autoplay: true,
      // autoplaySpeed: 7000,
      // pauseOnHover: true,
      // swipe: true,
      // draggable: false,
      // fade: true,
      // cssEase: 'linear',
      responsive: [
        {
          breakpoint: 1023,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        }
      ]
    });
  });