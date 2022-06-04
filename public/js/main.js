$(function () {
  // Variables
  let bodyTag = $("body");
  toUpBtn = $("#to-up"),
    modal = $(".modal"),
    navbar = $(".navbar"),
    navbarH = navbar.outerHeight(),
    navbarToggle = $(".navbar-toggle"),
    navbarNav = $(".navbar-nav"),
    target = $("main > :first-child"),
    positionTarget = $(target).height() + $(target).offset().top;

  // Navbar Toggle
  navbarToggle.on("click", function () {
    $(navbarNav).toggleClass("show");
    $(this).toggleClass("active");
    if ($(navbarNav).hasClass("show")) {
      $(navbarNav).attr("tabindex", "-1");
      navbarNav.focus();
    }
    else $(navbarNav).removeAttr("tabindex", "-1")
  })
  navbarNav.on("blur keyup", function (e) {
    if ($(e.relatedTarget).hasClass("nav-link") || $(e.relatedTarget).hasClass("navbar-toggle")) {
      return false;
    } else {
      if (e.which == 27 || e.which == 8 || e.type == "blur") {
        $(navbarToggle).removeClass("active");
        $(this).removeClass("show");
        $(this).removeAttr("tabindex", "-1");
      }
    }
  })
  navbarNav.on("click", ".nav-link", function (e) {
    if ($(this).hasClass("nav-link")) {
      $(navbarToggle).removeClass("active");
      $(e.delegateTarget).removeClass("show");
      $(e.delegateTarget).removeAttr("tabindex", "-1");
    }
  })

  // Scroll Events
  $(document).on("scroll", function (e) {
    // console.log(Math.round(positionTarget));
    if ($(this).scrollTop() > positionTarget - navbarH) {
      bodyTag.css("margin-top", `${navbarH}px`);
      navbar.addClass("fixed");
      toUpBtn.fadeIn();
    } else {
      bodyTag.css("margin-top", 0);
      navbar.removeClass("fixed");
      toUpBtn.fadeOut();
    }
  })
  if ($(document).scrollTop() > positionTarget - navbarH) {
    bodyTag.css("margin-top", `${navbarH}px`);
    navbar.addClass("fixed");
    toUpBtn.fadeIn();
  }
  $("#to-up").on("click", function (e) {
    e.preventDefault();
    $("html").animate({ scrollTop: 0 }, "slow");
  })

  //// Modal Toggle
  let modalImgTarget = $(".modal .modal-body img");
  let modalSearchTarget = $(".modal .modal-body .modal-search");
  modalImgTarget.on("click", function (e) {
    e.stopPropagation();
  })
  modalSearchTarget.on("click", function (e) {
    e.stopPropagation();
  })
  // Open Modal
  $(".modal-open, .open-modal-search").on("click", function (e) {
    modal.fadeIn(function () {
      $(this).attr("tabindex", "-1").find(".modal-body").css("animation", "");
      if ($(e.delegateTarget).hasClass("modal-open")) {
        $(this).focus();
      }
    })
    .find(".modal-body").css("animation", "slide-in 0.5s");
    if ($(this).hasClass("open-modal-search")) {
      $(".modal-search").show().find("input").val("").focus();
      $(".modal-content").hide();
    } else {
      modalImgTarget.attr("src", $(this).data("image"));
      $(".modal-content").show();
      $(".modal-search").hide();
    }
  })
  // Close Modal
  modal.on("click keyup", function (e) {
    if (e.which == 27 || e.which == 8 || e.type == "click") {
      $(this).fadeOut(function () {
        $(this).removeAttr("tabindex").find(".modal-body").css("animation", "");
        modalImgTarget.attr("src", "");
      })
        .find(".modal-body").css("animation", "slide-in 0.5s reverse");
    }
  })

  //// Carousel
  function carousel(parent, target) {
    // Get time duration function from transition class:
    function getTimeTransition(className) {
      let classTimeEl = document.querySelector(className);
      let classTimeObj = getComputedStyle(classTimeEl);
      let getTimeClass = classTimeObj.getPropertyValue("transition-duration");
      return getTimeClass.replace("s", "") * 1000;
    }
    let carouselItems = $(parent).find(".carousel-item");
    let carouselIndex = 0;
    let carouselLen = carouselItems.length;
    // Hide All Items without Active Item:
    carouselItems.each((index, item) => {
      if ($(item).hasClass("active")) {
        carouselIndex = index;
      }
      $(item).not(".active").hide();
    })
    control = ariaControl;
    let controlRev = control == "next" ? "prev" : "next";
    $(target).prop("disabled", true);

    let currentIndex = carouselIndex;
    let nextIndex = (currentIndex + (1 % carouselLen) + carouselLen) % carouselLen;
    let prevIndex = (currentIndex + (-1 % carouselLen) + carouselLen) % carouselLen;
    // Carousel slide effect:
    if ($(parent).hasClass("slide")) {
      // Add Classes to Current Item
      $(carouselItems[currentIndex]).show(0, function () {
        let clasessNames = `carousel-${control}-active carousel-${controlRev}-leave-to`;
        $(this).addClass(clasessNames).removeClass("active");
        let delayTime = getTimeTransition(`.carousel-${control}-active`);
        $(this).delay(delayTime).fadeOut(0, function () {
          $(this).removeClass(clasessNames);
          $(target).prop("disabled", false);
        });
      });
      // Add Classes to Next or Prev Item
      $(carouselItems[(control == "prev" ? prevIndex : nextIndex)]).addClass(`carousel-${control}-enter active`);
      $(carouselItems[(control == "prev" ? prevIndex : nextIndex)]).show(0, function () {
        let clasessNames = `carousel-${control}-active carousel-${controlRev}-enter-to`;
        $(this).removeClass(`carousel-${control}-enter`).addClass(clasessNames);
        let delayTime = getTimeTransition(`.carousel-${control}-active`);
        $(this).delay(delayTime).fadeIn(0, function () {
          $(this).removeClass(clasessNames);
        });
      });
    } else {
      // Carousel fade effect:
      $(carouselItems[(control == "prev" ? prevIndex : nextIndex)])
      .addClass("active").fadeIn(function () {
        $(target).prop("disabled", false);
      }).siblings().removeClass("active").fadeOut();
    }
    carouselIndex = control == "prev" ? prevIndex : nextIndex;
  }
  let ariaControl = "next";
  // Play Carousel on Click
  $(".carousel").on("click", ".next, .prev", function (e) {
    ariaControl = $(e.target).attr("aria-controls");
    if ($(this).hasClass("next") || $(this).hasClass("prev")) {
      carousel(e.delegateTarget, e.target);
    }
  })
  // Autoplay Carousel
  function autoPlayCarousel(element, interval) {
    let itemsLen = element.find(".carousel-item").length;
    // console.log(itemsLen);
    let intervalStart;
    function IntervalCheck() {
      if (!intervalStart && itemsLen > 1) {
        intervalStart = setInterval(() => carousel(element), interval);
      }
    }
    IntervalCheck();
    $(element).hover(function () {
      clearInterval(intervalStart);
      intervalStart = null;
    }, function () {
      IntervalCheck();
    })
  }

  $(".carousel").each(function () {
    autoPlayCarousel($(this), 4000);
  })

  //// Slider FadeIn Loop
  function slideFadeIn(elements, interval) {
    let currentIndex = 0;
    let itemsLen = elements.length;
    $(elements).each((index, item) => {
      if ($(item).hasClass("active")) currentIndex = index;
      else $(item).hide();
    })

    let intervalEl;
    function fadeInItem() {
      if (!intervalEl && itemsLen > 1) {
        intervalEl = setInterval(getItem, interval);
      }
    }
    function getItem() {
      let nextIndex = (currentIndex + (1 % itemsLen) + itemsLen) % itemsLen;
      $(elements[nextIndex]).fadeIn().siblings().fadeOut();
      currentIndex = nextIndex;
      // console.log(intervalEl);
    }
    fadeInItem();
    $(elements).hover(function () {
      clearInterval(intervalEl);
      intervalEl = null;
    }, function () {
      fadeInItem();
    })
  }
  // slideFadeIn($(".heading .carousel-item"), 4000);

  // Mulit-Slider
  $('.slider').multislider({
    // endless scrolling
    continuous: false,
    // slide all visible slides, or just one at a time
    slideAll: false,
    // autoplay interval
    // 0 or 'false' prevents auto-sliding
    interval: false,
    // duration of slide animation
    duration: 500,
    // pause carousel on hover
    hoverPause: true,
    // pause above specified screen width
    pauseAbove: null,
    // pause below specified screen width
    pauseBelow: null
  });

  //// Shuflle
  $(".shuflle").on("click", "[data-list]:not(.active)", function (e) {
    e.preventDefault();
    // Add Class Active to Target:
    $(this).addClass("active").siblings().removeClass("active");

    // Applay Effects on the items:
    let dataList = $(this).data("list");
    $(e.delegateTarget).find("[data-sort]").finish().fadeOut(0, function () {
      $(this).filter(function (index, item) {
        return dataList == "all" ? item : $(item).is(`[data-sort=${dataList}]`);
      }).fadeIn(700);
    });
  });

  //// Animate effetc fade-in on section elements
  function fadeSection(item) {
    let scrTop = $(window).scrollTop();
    let winHei = $(window).height();
    if ((scrTop + winHei) > ($(item).offset().top + (winHei / 3)) && scrTop < ($(item).offset().top + $(item).height() - (winHei / 3))) {
      $(item).animate({
        "opacity": 1,
      }, 700).removeClass("animate");
    }
  }
  $(".animate").each(function (index, item) {
    $(".animate").css("opacity", "0");
    fadeSection(item);
    $(window).on("scroll", function () {
      if ($(".animate").length > 0)
        fadeSection(item);
      else
        $(this).off();
    })
  })
})
