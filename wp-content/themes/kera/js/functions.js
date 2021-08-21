'use strict';

/**
 * @preserve
 * Project: Bootstrap Hover Dropdown
 * Author: Cameron Spear
 * Version: v2.2.1
 * Contributors: Mattia Larentis
 * Dependencies: Bootstrap's Dropdown plugin, jQuery
 * Description: A simple plugin to enable Bootstrap dropdowns to active on hover and provide a nice user experience.
 * License: MIT
 * Homepage: http://cameronspear.com/blog/bootstrap-dropdown-on-hover-plugin/
 */
(function ($, window, undefined$1) {
    var $allDropdowns = $();
    $.fn.dropdownHover = function (options) {
        if('ontouchstart' in document) return this;
        $allDropdowns = $allDropdowns.add(this.parent());
        return this.each(function () {
            var $this = $(this),
                $parent = $this.parent(),
                defaults = {
                    delay: 500,
                    hoverDelay: 0,
                    instantlyCloseOthers: true
                },
                data = {
                    delay: $(this).data('delay'),
                    hoverDelay: $(this).data('hover-delay'),
                    instantlyCloseOthers: $(this).data('close-others')
                },
                showEvent   = 'show.bs.dropdown',
                hideEvent   = 'hide.bs.dropdown',
                settings = $.extend(true, {}, defaults, options, data),
                timeout, timeoutHover;
            $parent.hover(function (event) {
                if(!$parent.hasClass('open') && !$this.is(event.target)) {
                    return true;
                }
                openDropdown(event);
            }, function () {
                window.clearTimeout(timeoutHover);
                timeout = window.setTimeout(function () {
                    $this.attr('aria-expanded', 'false');
                    $parent.removeClass('open');
                    $this.trigger(hideEvent);
                }, settings.delay);
            });
            $this.hover(function (event) {
                if(!$parent.hasClass('open') && !$parent.is(event.target)) {
                    return true;
                }
                openDropdown(event);
            });
            $parent.find('.dropdown-submenu').each(function (){
                var $this = $(this);
                var subTimeout;
                $this.hover(function () {
                    window.clearTimeout(subTimeout);
                    $this.children('.dropdown-menu').show();
                    $this.siblings().children('.dropdown-menu').hide();
                }, function () {
                    var $submenu = $this.children('.dropdown-menu');
                    subTimeout = window.setTimeout(function () {
                        $submenu.hide();
                    }, settings.delay);
                });
            });
            function openDropdown(event) {
                if($this.parents(".navbar").find(".navbar-toggle").is(":visible")) {
                    return;
                }
                window.clearTimeout(timeout);
                window.clearTimeout(timeoutHover);
                timeoutHover = window.setTimeout(function () {
                    $allDropdowns.find(':focus').blur();
                    if(settings.instantlyCloseOthers === true)
                        $allDropdowns.removeClass('open');
                    window.clearTimeout(timeoutHover);
                    $this.attr('aria-expanded', 'true');
                    $parent.addClass('open');
                    $this.trigger(showEvent);
                }, settings.hoverDelay);
            }
        });
    };
    $(document).ready(function () {
        $('[data-hover="dropdown"]').dropdownHover();
    });
})(jQuery, window);

class StickyHeader {
  constructor() {
    let _this = this;

    this.$tbayHeader = $('.tbay_header-template');
    this.$tbayHeaderMain = $('.tbay_header-template .header-main');

    if (this.$tbayHeader.hasClass('main-sticky-header') && this.$tbayHeaderMain.length > 0) {
      this._initStickyHeader();
    }

    $('.search-min-wrapper .btn-search-min').click(this._onClickSeachMin);
    $('.tbay-search-form .overlay-box').click(this._onClickOverLayBox);
    this._intSearchOffcanvas;
    let sticky_header = $('.element-sticky-header');

    if (sticky_header.length > 0) {
      _this._initELementStickyheader(sticky_header);
    }
  }

  _initStickyHeader() {
    var _this = this;

    var tbay_width = $(window).width();

    var header_height = _this.$tbayHeader.outerHeight();

    var headerMain_height = _this.$tbayHeaderMain.outerHeight();

    var admin_height = $('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0;

    var sticky = _this.$tbayHeaderMain.offset().top;

    if (tbay_width >= 1024) {
      if (sticky == 0 || sticky == admin_height) {
        if (_this.$tbayHeader.hasClass('sticky-header')) return;

        _this._stickyHeaderOnDesktop(headerMain_height, sticky, admin_height);

        _this.$tbayHeaderMain.addClass('sticky-1');

        $(window).scroll(function () {
          if ($(this).scrollTop() > header_height) {
            _this.$tbayHeaderMain.addClass('sticky-box');
          } else {
            _this.$tbayHeaderMain.removeClass('sticky-box');
          }
        });
      } else {
        $(window).scroll(function () {
          if (!_this.$tbayHeader.hasClass('main-sticky-header')) return;

          if ($(this).scrollTop() > sticky - admin_height) {
            if (_this.$tbayHeader.hasClass('sticky-header')) return;

            _this._stickyHeaderOnDesktop(headerMain_height, sticky, admin_height);
          } else {
            _this.$tbayHeaderMain.css("top", 0).css("position", "relative").removeClass('sticky-header').parent().css('padding-top', 0);

            _this.$tbayHeaderMain.prev().css('margin-bottom', 0);
          }
        });
      }
    }
  }

  _stickyHeaderOnDesktop(headerMain_height, sticky, admin_height) {
    this.$tbayHeaderMain.addClass('sticky-header').css("top", admin_height).css("position", "fixed");

    if (sticky == 0 || sticky == admin_height) {
      this.$tbayHeaderMain.parent().css('padding-top', headerMain_height);
    } else {
      this.$tbayHeaderMain.prev().css('margin-bottom', headerMain_height);
    }
  }

  _onClickSeachMin() {
    $('.tbay-search-form.tbay-search-min form').toggleClass('show');
    $(this).toggleClass('active');
  }

  _onClickOverLayBox() {
    $('.search-min-wrapper .btn-search-min').removeClass('active');
    $('.tbay-search-form.tbay-search-min form').removeClass('show');
  }

  _intSearchOffcanvas() {
    if ($('#tbay-offcanvas-main').length === 0) return;
    $('[data-toggle="offcanvas-main-search"]').on('click', function () {
      $('#wrapper-container').toggleClass('show');
      $('#tbay-offcanvas-main').toggleClass('show');
    });
    var $box_totop = $('#tbay-offcanvas-main, .search');
    $(window).on("click.Bst", function (event) {
      if ($box_totop.has(event.target).length == 0 && !$box_totop.is(event.target)) {
        $('#wrapper-container').removeClass('show');
        $('#tbay-offcanvas-main').removeClass('show');
      }
    });
  }

  _initELementStickyheader(elements) {
    var el = elements.first();

    let _this = this;

    var scroll = false,
        sum = 0,
        prev_sum = 0;
    if (el.parents('.tbay_header-template').length === 0) return;
    var adminbar = $('#wpadminbar').length > 0 ? $('#wpadminbar').outerHeight() : 0,
        sticky_load = el.offset().top - $(window).scrollTop() - adminbar,
        sticky = sticky_load;
    el.prevAll().each(function () {
      prev_sum += $(this).outerHeight();
    });
    elements.each(function () {
      if ($(this).parents('.element-sticky-header').length > 0) return;
      sum += $(this).outerHeight();
    });

    _this._initELementStickyheaderContent(sticky_load, sticky, sum, prev_sum, elements, el, adminbar, scroll);

    $(window).scroll(function () {
      scroll = true;
      if ($(window).scrollTop() === 0) sticky = 0;

      _this._initELementStickyheaderContent(sticky_load, sticky, sum, prev_sum, elements, el, adminbar, scroll);
    });
  }

  _initELementStickyheaderContent(sticky_load, sticky, sum, prev_sum, elements, el, adminbar, scroll) {
    if ($(window).scrollTop() < prev_sum && scroll || $(window).scrollTop() === 0 && scroll) {
      if (el.parent().children().first().hasClass('element-sticky-header')) return;
      el.css('top', '');

      if (sticky === sticky_load || sticky === 0) {
        elements.last().next().css('padding-top', '');
      } else {
        el.prev().css('margin-bottom', '');
      }

      el.parent().css('padding-top', '');
      elements.each(function () {
        $(this).removeClass("sticky");

        if ($(this).prev('.element-sticky-header').length > 0) {
          $(this).css('top', '');
        }
      });
    } else {
      if ($(window).scrollTop() < prev_sum && !scroll) return;
      elements.each(function () {
        if ($(this).parents('.element-sticky-header').length > 0) return;
        $(this).addClass("sticky");

        if ($(this).prevAll('.element-sticky-header').length > 0) {
          let total = 0;
          $(this).prevAll('.element-sticky-header').each(function () {
            total += $(this).outerHeight();
          });
          $(this).css('top', total + adminbar);
        }
      });
      el.css('top', adminbar);

      if (sticky === sticky_load || sticky === 0) {
        el.addClass("sticky");
        el.parent().css('padding-top', sum);
      } else {
        el.prev().css('margin-bottom', sum);
      }
    }
  }

}

const TREE_VIEW_OPTION_MEGA_MENU = {
  animated: 300,
  collapsed: true,
  unique: true,
  persist: "location"
};
const TREE_VIEW_OPTION_MOBILE_MENU = {
  animated: 300,
  collapsed: true,
  unique: true,
  hover: false
};

(function ($) {
  $.extend($.fn, {
    swapClass: function (c1, c2) {
      var c1Elements = this.filter('.' + c1);
      this.filter('.' + c2).removeClass(c2).addClass(c1);
      c1Elements.removeClass(c1).addClass(c2);
      return this;
    },
    replaceClass: function (c1, c2) {
      return this.filter('.' + c1).removeClass(c1).addClass(c2).end();
    },
    hoverClass: function (className) {
      className = className || "hover";
      return this.hover(function () {
        $(this).addClass(className);
      }, function () {
        $(this).removeClass(className);
      });
    },
    heightToggle: function (animated, callback) {
      animated ? this.animate({
        height: "toggle"
      }, animated, callback) : this.each(function () {
        jQuery(this)[jQuery(this).is(":hidden") ? "show" : "hide"]();
        if (callback) callback.apply(this, arguments);
      });
    },
    heightHide: function (animated, callback) {
      if (animated) {
        this.animate({
          height: "hide"
        }, animated, callback);
      } else {
        this.hide();
        if (callback) this.each(callback);
      }
    },
    prepareBranches: function (settings) {
      if (!settings.prerendered) {
        this.filter(":last-child:not(ul)").addClass(CLASSES.last);
        this.filter((settings.collapsed ? "" : "." + CLASSES.closed) + ":not(." + CLASSES.open + ")").find(">ul").hide();
      }

      return this.filter(":has(>ul),:has(>.dropdown-menu)");
    },
    applyClasses: function (settings, toggler) {
      this.filter(":has(>ul):not(:has(>a))").find(">span").click(function (event) {
        toggler.apply($(this).next());
      }).add($("a", this)).hoverClass();

      if (!settings.prerendered) {
        this.filter(":has(>ul:hidden),:has(>.dropdown-menu:hidden)").addClass(CLASSES.expandable).replaceClass(CLASSES.last, CLASSES.lastExpandable);
        this.not(":has(>ul:hidden),:has(>.dropdown-menu:hidden)").addClass(CLASSES.collapsable).replaceClass(CLASSES.last, CLASSES.lastCollapsable);
        this.prepend("<div class=\"" + CLASSES.hitarea + "\"/>").find("div." + CLASSES.hitarea).each(function () {
          var classes = "";
          $.each($(this).parent().attr("class").split(" "), function () {
            classes += this + "-hitarea ";
          });
          $(this).addClass(classes);
        });
      }

      this.find("div." + CLASSES.hitarea).click(toggler);
    },
    treeview: function (settings) {
      settings = $.extend({
        cookieId: "treeview"
      }, settings);

      if (settings.add) {
        return this.trigger("add", [settings.add]);
      }

      if (settings.toggle) {
        var callback = settings.toggle;

        settings.toggle = function () {
          return callback.apply($(this).parent()[0], arguments);
        };
      }

      function treeController(tree, control) {
        function handler(filter) {
          return function () {
            toggler.apply($("div." + CLASSES.hitarea, tree).filter(function () {
              return filter ? $(this).parent("." + filter).length : true;
            }));
            return false;
          };
        }

        $("a:eq(0)", control).click(handler(CLASSES.collapsable));
        $("a:eq(1)", control).click(handler(CLASSES.expandable));
        $("a:eq(2)", control).click(handler());
      }

      function toggler() {
        $(this).parent().find(">.hitarea").swapClass(CLASSES.collapsableHitarea, CLASSES.expandableHitarea).swapClass(CLASSES.lastCollapsableHitarea, CLASSES.lastExpandableHitarea).end().swapClass(CLASSES.collapsable, CLASSES.expandable).swapClass(CLASSES.lastCollapsable, CLASSES.lastExpandable).find(">ul,>.dropdown-menu").heightToggle(settings.animated, settings.toggle);

        if (settings.unique) {
          $(this).parent().siblings().find(">.hitarea").replaceClass(CLASSES.collapsableHitarea, CLASSES.expandableHitarea).replaceClass(CLASSES.lastCollapsableHitarea, CLASSES.lastExpandableHitarea).end().replaceClass(CLASSES.collapsable, CLASSES.expandable).replaceClass(CLASSES.lastCollapsable, CLASSES.lastExpandable).find(">ul,>.dropdown-menu").heightHide(settings.animated, settings.toggle);
        }
      }

      function serialize() {

        var data = [];
        branches.each(function (i, e) {
          data[i] = $(e).is(":has(>ul:visible)") ? 1 : 0;
        });
        $.cookie(settings.cookieId, data.join(""));
      }

      function deserialize() {
        var stored = $.cookie(settings.cookieId);

        if (stored) {
          var data = stored.split("");
          branches.each(function (i, e) {
            $(e).find(">ul")[parseInt(data[i]) ? "show" : "hide"]();
          });
        }
      }

      this.addClass("treeview");
      var branches = this.find("li").prepareBranches(settings);

      switch (settings.persist) {
        case "cookie":
          var toggleCallback = settings.toggle;

          settings.toggle = function () {
            serialize();

            if (toggleCallback) {
              toggleCallback.apply(this, arguments);
            }
          };

          deserialize();
          break;

        case "location":
          var current = this.find("a").filter(function () {
            return this.href.toLowerCase() == location.href.toLowerCase();
          });

          if (current.length) {
            current.addClass("selected").parents("ul, li").add(current.next()).show();
          }

          break;
      }

      branches.applyClasses(settings, toggler);

      if (settings.control) {
        treeController(this, settings.control);
        $(settings.control).show();
      }

      return this.bind("add", function (event, branches) {
        $(branches).prev().removeClass(CLASSES.last).removeClass(CLASSES.lastCollapsable).removeClass(CLASSES.lastExpandable).find(">.hitarea").removeClass(CLASSES.lastCollapsableHitarea).removeClass(CLASSES.lastExpandableHitarea);
        $(branches).find("li").andSelf().prepareBranches(settings).applyClasses(settings, toggler);
      });
    }
  });
  var CLASSES = $.fn.treeview.classes = {
    open: "open",
    closed: "closed",
    expandable: "expandable",
    expandableHitarea: "expandable-hitarea",
    lastExpandableHitarea: "lastExpandable-hitarea",
    collapsable: "collapsable",
    collapsableHitarea: "collapsable-hitarea",
    lastCollapsableHitarea: "lastCollapsable-hitarea",
    lastCollapsable: "lastCollapsable",
    lastExpandable: "lastExpandable",
    last: "last",
    hitarea: "hitarea"
  };
  $.fn.Treeview = $.fn.treeview;
})(jQuery);

class Mobile {
  constructor() {
    this._mobileMenu();

    this._SearchFocusActive();

    this._PopupLoginMobile();

    this._Select_change_form();

    this._initTopNavbar();

    $(window).resize(() => {
      this._initTopNavbar();
    });

    this._login_popup_modal();

    this._categories_popup_modal();

    this._search_popup_modal();

    this._mobile_btn_categories_close();

    this._mobile_btn_login_close();

    this._mobile_btn_share_close();

    this._mobile_btn_filter_close();
  }

  _initTopNavbar() {
    let scroll = $(window).scrollTop();
    let wpadminbar = 0;

    if ($('#wpadminbar').length > 0) {
      if ($(window).width() >= 600) {
        wpadminbar = $('#wpadminbar').outerHeight();
      } else if (scroll === 0) {
        wpadminbar = $('#wpadminbar').outerHeight();
      }
    }

    let el = $('#tbay-mobile-menu-navbar, .mm-page__blocker');
    el.css('top', $('.topbar-device-mobile').outerHeight() + wpadminbar);
  }

  _topBarDevice() {
    var scroll = $(window).scrollTop();
    var objectSelect = $(".topbar-device-mobile").height();
    var scrollmobile = $(window).scrollTop();
    $(".topbar-device-mobile").toggleClass("active", scroll <= objectSelect);
    $("#tbay-mobile-menu").toggleClass("offsetop", scrollmobile == 0);
  }

  _mobileMenu() {
    $('[data-toggle="offcanvas"], .btn-offcanvas').click(function () {
      $('#wrapper-container').toggleClass('active');
      $('#tbay-mobile-menu').toggleClass('active');
    });
    $("#main-mobile-menu .caret").click(function () {
      $("#main-mobile-menu .dropdown").removeClass('open');
      $(event.target).parent().addClass('open');
    });
  }

  _SidebarShopMobile() {
    var _this = this;

    let btn = $('.btn-click.button-filter-mobile');
    if (btn.length === 0) return;
    btn.on('click', function (e) {
      e.preventDefault();
      var status = $(this).attr('data-status'),
          title = $(this).attr('data-title'),
          close = $(this).attr('data-close'),
          event = $(this).attr('data-event'),
          wr_event = $('#wrapper-container').attr('data-event');

      if (typeof wr_event !== "undefined" && wr_event !== event) {
        _this._mobile_btn_remove_event(wr_event, false);
      }

      if (status === 'open') {
        $(this).attr('data-status', 'close');
        $(close).addClass('active');
        $('.topbar-device-mobile').addClass('active-btn-close');

        _this._mobile_btn_open_event(event, title);
      } else if (status === 'close') {
        $(this).attr('data-status', 'open');
        $(close).removeClass('active');
        $('.topbar-device-mobile').removeClass('active-btn-close');

        _this._mobile_btn_remove_event(event, true);
      }
    });
  }

  _SearchFocusActive() {
    let search_mobile = $('.tbay-search-mobile .tbay-search');
    let search_cancel = $('.tbay-search-mobile .button-search-cancel');
    search_mobile.focusin(function () {
      $(search_mobile.parents('#tbay-mobile-menu-navbar')).addClass('search-mobile-focus');
      search_mobile.parent().find('.button-search-cancel').addClass('cancel-active');
    });
    search_cancel.on("click", function () {
      $(search_cancel.parents('#tbay-mobile-menu-navbar')).removeClass('search-mobile-focus');
      search_cancel.removeClass('cancel-active');
    });
  }

  _PopupLoginMobile() {
    let popup_login_mobile = $('.mmenu-account .popup-login a, .footer-device-mobile > .device-account > a.popup-login');
    popup_login_mobile.on("click", function () {
      let api = $("#tbay-mobile-menu-navbar").data("mmenu");
      $('#custom-login-wrapper').modal('show');
      $(popup_login_mobile.parents('#tbay-mobile-menu-navbar')).removeClass('mm-menu_opened');
      api.close();
    });
  }

  _Select_change_form() {
    $('.topbar-device-mobile > form select').on('change', function () {
      this.form.submit();
    });
  }

  _Mobile_icon_more() {
    var _this = this;

    let btn = $('.mobile-icon-more');
    if (btn.length === 0) return;
    btn.on('click', function (e) {
      e.preventDefault();
      $(this).toggleClass('active');
      event = $('#wrapper-container').attr('data-event');

      if (typeof event !== "undefined") {
        _this._mobile_btn_remove_event(event, false);

        $('#wrapper-container').removeAttr('data-event');
        $('body').removeClass('open-event');
      }

      $('.hdmobile-close').removeClass('active').parents('.topbar-device-mobile').removeClass('active-btn-close').removeClass('open-title');

      if ($('.top-cart-mobile .tbay-dropdown-cart').hasClass('active')) {
        $('.top-cart-mobile .tbay-dropdown-cart').removeClass('active');
        $('body').removeClass('open-event');
      }
    });
  }

  _Topbar_Mobile_btn() {
    var _this = this;

    let btn = $('.topbar-icon-more .btn-click');
    btn.on('click', function (e) {
      e.preventDefault();
      var status = $(this).attr('data-status'),
          title = $(this).attr('data-title'),
          event = $(this).attr('data-event'),
          close = $(this).attr('data-close'),
          wr_event = $('#wrapper-container').attr('data-event');

      if (typeof wr_event !== "undefined" && wr_event !== event) {
        _this._mobile_btn_remove_event(wr_event, false);
      }

      if (status === 'open') {
        $(this).addClass('active').attr('data-status', 'close');
        $(this).parents('.topbar-device-mobile').addClass('active-btn-close');
        $(close).addClass('active');

        _this._mobile_btn_open_event(event, title);
      } else if (status === 'close') {
        $(this).removeClass('active').attr('data-status', 'open');
        $(this).parents('.topbar-device-mobile').removeClass('active-btn-close');
        $(close).removeClass('active');

        _this._mobile_btn_remove_event(event, true);
      }
    });
  }

  _Footer_mobile_btn() {
    var _this = this;

    let btn = $('.footer-device-mobile .btn-click');
    btn.on('click', function (e) {
      e.preventDefault();
      var status = $(this).attr('data-status'),
          title = $(this).attr('data-title'),
          close = $(this).attr('data-close'),
          event = $(this).attr('data-event'),
          wr_event = $('#wrapper-container').attr('data-event');

      if (typeof wr_event !== "undefined" && wr_event !== event) {
        _this._mobile_btn_remove_event(wr_event, false);
      }

      if (status === 'open') {
        $(this).addClass('active').attr('data-status', 'close');
        $(close).addClass('active');

        _this._mobile_btn_open_event(event, title);
      } else if (status === 'close') {
        $(this).removeClass('active').attr('data-status', 'open');
        $(close).removeClass('active');

        _this._mobile_btn_remove_event(event, true);
      }
    });
  }

  _mobile_btn_categories_close() {
    var _this = this;

    $('#btn-categories-close').on('click', function (e) {
      e.preventDefault();
      $(this).removeClass('active').parents('.topbar-device-mobile').removeClass('active-btn-close');
      $('.mobile-icon-more').removeClass('active');
      $('.topbar-device-mobile .btn-click.categories-icon').removeClass('active').attr('data-status', 'open');

      _this._mobile_btn_remove_event("categories", true);
    });
  }

  _mobile_btn_login_close() {
    var _this = this;

    $('#btn-account-close').on('click', function (e) {
      e.preventDefault();
      $(this).removeClass('active').parents('.topbar-device-mobile').removeClass('active-btn-close');
      $('.mobile-icon-more').removeClass('active');
      $('.topbar-device-mobile .btn-click.mobile-popup-login').removeClass('active').attr('data-status', 'open');

      _this._mobile_btn_remove_event("login", true);
    });
  }

  _mobile_btn_share_close() {
    var _this = this;

    $('#btn-share-close, #btn-share-close-wrapper').on('click', function (e) {
      e.preventDefault();
      $(this).removeClass('active').parents('.topbar-device-mobile').removeClass('active-btn-close');
      $('.mobile-icon-more').removeClass('active');
      $('.topbar-device-mobile .btn-click.more-share').removeClass('active').attr('data-status', 'open');

      _this._mobile_btn_remove_event("share", true);
    });
  }

  _mobile_btn_filter_close() {
    var _this = this;

    $('#btn-filter-close').on('click', function (e) {
      e.preventDefault();
      $(this).removeClass('active').parents('.topbar-device-mobile').removeClass('active-btn-close');
      $('.btn-click.button-filter-mobile').removeClass('active').attr('data-status', 'open');

      _this._mobile_btn_remove_event("filter", true);
    });
  }

  _mobile_btn_open_event(event, title) {
    $('body').addClass('open-event');

    switch (event) {
      case "login":
        this._mobile_login_popup_open(event, title);

        break;

      case "search":
        this._mobile_search_popup_open(event, title);

        break;

      case "categories":
        this._mobile_categories_popup_open(event, title);

        break;

      case "filter":
        this._mobile_filter_open(event, title);

        break;

      default:
        break;
    }
  }

  _mobile_btn_remove_event(event, active) {
    if (active) {
      $('#wrapper-container').removeAttr('data-event');
      $('.topbar-device-mobile').removeClass('open-title');
      $('body').removeClass('open-event');
      $('.hdmobile-title').empty();
    } else {
      switch (event) {
        case "login":
          $('.device-account .btn-click').removeClass('active').attr('data-status', 'open');
          break;

        case "search":
          $('.search-device .btn-click').removeClass('active').attr('data-status', 'open');
          break;

        case "categories":
          $('.categories-device .btn-click').removeClass('active').attr('data-status', 'open');
          break;

        case "share":
          $('.device-share .btn-click').removeClass('active').attr('data-status', 'open');
          break;

        case "filter":
          $('.btn-click.button-filter-mobile').removeClass('active').attr('data-status', 'open');
          break;

        default:
      }
    }

    switch (event) {
      case "login":
        this._mobile_login_popup_remove(event);

        break;

      case "search":
        this._mobile_search_popup_remove(event);

        break;

      case "categories":
        this._mobile_categories_popup_remove(event);

        break;

      case "filter":
        this._mobile_filter_remove(event);

        break;

      default:
        break;
    }
  }

  _mobile_filter_open(event, title) {
    $('#wrapper-container').attr('data-event', event);
    $('.topbar-device-mobile').addClass('open-title');
    $('.hdmobile-title').text(title);
    $('body').addClass('filter-mobile-active');
  }

  _mobile_login_popup_open(event, title) {
    $('.modal-backdrop').addClass('bg-none');
    $('#wrapper-container').attr('data-event', event);
    $('.topbar-device-mobile').addClass('open-title');
    $('.hdmobile-title').text(title);
  }

  _mobile_search_popup_open(event, title) {
    $('.modal-backdrop').addClass('bg-none');
    $('#wrapper-container').attr('data-event', event);
    $('.topbar-device-mobile').addClass('open-title');
    $('.hdmobile-title').text(title);
  }

  _mobile_categories_popup_open(event, title) {
    $('.modal-backdrop').addClass('bg-none');
    $('#wrapper-container').attr('data-event', event);
    $('.topbar-device-mobile').addClass('open-title');
    $('.hdmobile-title').text(title);
  }

  _mobile_login_popup_remove(event) {
    $('.modal-backdrop').removeClass('bg-none');
    $('#custom-login-wrapper').modal('hide');
  }

  _mobile_search_popup_remove(event) {
    $('.modal-backdrop').removeClass('bg-none');
    $('#search-device-content').modal('hide');
  }

  _search_popup_modal() {
    $('#search-device-content').on('shown.bs.modal', function (e) {
      $('body').addClass('tbay-modal-none');
    });
  }

  _mobile_categories_popup_remove(event) {
    $('.modal-backdrop').removeClass('bg-none');
    $('#categories-device-content').modal('hide');
  }

  _categories_popup_modal() {
    $('#categories-device-content').on('shown.bs.modal', function (e) {
      $('body').addClass('tbay-modal-none');
    });
  }

  _mobile_filter_remove(event) {
    $('body').removeClass('filter-mobile-active');
  }

  _login_popup_modal() {
    $('#custom-login-wrapper').on('shown.bs.modal', function (e) {
      $('body').addClass('tbay-modal-none');
    });
  }

  _Mini_cart_click() {
    if (typeof kera_settings === "undefined") return;

    var _this = this;

    $(document.body).on('top_cart_mobile_click', function () {
      $('.topbar-device-mobile').addClass('open-title').removeClass('active-btn-close');
      $('body').addClass('open-event');
      $('.hdmobile-title').text(kera_settings.mobile_title.mini_cart);
      setTimeout(function () {
        event = $('#wrapper-container').attr('data-event');
        if (typeof event === "undefined") return;

        _this._mobile_btn_remove_event(event, false);

        $('#wrapper-container').removeAttr('data-event');

        if ($('.mobile-icon-more').hasClass('active')) {
          $('.mobile-icon-more').removeClass('active');
        }
      }, 10);
    });
    jQuery(".top-cart-mobile .cart-close").on('click', function (event) {
      event.preventDefault();
      if ($('#wrapper-container').hasClass('offcanvas-right')) $('#wrapper-container').removeClass('offcanvas-right');
      $('.topbar-device-mobile').removeClass('open-title');
      $('body').removeClass('open-event');
      $('.hdmobile-title').empty();
    });
    $('.top-cart-mobile .cart-dropdown').on('hidden.bs.dropdown', function () {
      $('.topbar-device-mobile .top-cart-mobile .tbay-dropdown-cart').removeClass('active');
      $('body').removeClass('open-event');
    });
  }

  _Mmenu_click() {
    var _this = this;

    jQuery("#mmenu-btn-open").on('click', function (event) {
      event.preventDefault();
      $('.topbar-device-mobile').addClass('open-title');
      $('.hdmobile-title').text($(this).attr('data-title'));
      setTimeout(function () {
        var event = $('#wrapper-container').attr('data-event');
        if (typeof event === "undefined") return;

        _this._mobile_btn_remove_event(event, false);

        $('#wrapper-container').removeAttr('data-event');
        $('body').removeClass('open-event');

        if ($('.top-cart-mobile .tbay-dropdown-cart').hasClass('active')) {
          $('.top-cart-mobile .tbay-dropdown-cart').removeClass('active');
          $('body').removeClass('open-event');
        }

        if ($('.mobile-icon-more').hasClass('active')) {
          $('.mobile-icon-more').removeClass('active');
        }
      }, 100);
    });
    jQuery("#mmenu-btn-close").on('click', function (event) {
      event.preventDefault();
      $('.topbar-device-mobile').removeClass('open-title');
      $('body').removeClass('open-event');
      $('.hdmobile-title').empty();
    });
  }

}
jQuery(document).ready(() => {
  var mobile = new Mobile();

  mobile._Footer_mobile_btn();

  mobile._Topbar_Mobile_btn();

  mobile._Mobile_icon_more();

  mobile._SidebarShopMobile();

  mobile._Mini_cart_click();

  mobile._Mmenu_click();
});

class AccountMenu {
  constructor() {
    this._slideToggleAccountMenu(".tbay-login");

    this._slideToggleAccountMenu(".topbar-mobile");

    this._tbayClickNotMyAccountMenu();
  }

  _tbayClickNotMyAccountMenu() {
    var $win_my_account = $(window);
    var $box_my_account = $('.tbay-login .dropdown .account-menu,.topbar-mobile .dropdown .account-menu,.tbay-login .dropdown .account-button,.topbar-mobile .dropdown .account-button');
    $win_my_account.on("click.Bst", function (event) {
      if ($box_my_account.has(event.target).length == 0 && !$box_my_account.is(event.target)) {
        $(".tbay-login .dropdown .account-menu").slideUp(500);
        $(".topbar-mobile .dropdown .account-menu").slideUp(500);
      }
    });
  }

  _slideToggleAccountMenu(parentSelector) {
    $(parentSelector).find(".dropdown .account-button").click(function () {
      $(parentSelector).find(".dropdown .account-menu").slideToggle(500);
    });
  }

}

class BackToTop {
  constructor() {
    this._init();
  }

  _init() {
    $(window).scroll(function () {
      var isActive = $(this).scrollTop() > 400;
      $('.tbay-to-top').toggleClass('active', isActive);
      $('.tbay-category-fixed').toggleClass('active', isActive);
    });
    $('#back-to-top-mobile, #back-to-top').click(this._onClickBackToTop);
  }

  _onClickBackToTop() {
    $('html, body').animate({
      scrollTop: '0px'
    }, 800);
  }

}

class CanvasMenu {
  constructor() {
    this._init();

    this._remove_click_Outside();

    this._initCanvasMenuSidebar();

    this._initCanvasMenu();
  }

  _init() {
    $("#tbay-offcanvas-main .btn-toggle-canvas").on("click", function () {
      $('#wrapper-container').removeClass('active');
    });
    $("#main-menu-offcanvas .caret").click(function () {
      $("#main-menu-offcanvas .dropdown").removeClass('open');
      $(this).parent().addClass('open');
      return false;
    });
    $('[data-toggle="offcanvas-main"]').on('click', function (event) {
      event.preventDefault();
      $('#wrapper-container').toggleClass('active');
      $('#tbay-offcanvas-main').toggleClass('active');
    });
  }

  _remove_click_Outside() {
    let win = $(window);
    win.on("click.Bst,click touchstart tap", function (event) {
      let box_popup = $('#tbay-offcanvas-main, .btn-toggle-canvas');

      if (box_popup.has(event.target).length == 0 && !box_popup.is(event.target)) {
        $('#wrapper-container').removeClass('active');
        return;
      }
    });
  }

  _initCanvasMenuSidebar() {
    $(document).on('click', '.canvas-menu-sidebar .btn-canvas-menu', function (event) {
      event.preventDefault();
      $('body').toggleClass('canvas-menu-active');
    });
    $(document).on('click', '.close-canvas-menu, .bg-close-canvas-menu', function (event) {
      event.preventDefault();
      $('body').removeClass('canvas-menu-active');
    });
  }

  _initCanvasMenu() {
    if ($(".element-menu-canvas").length === 0) return;
    $(".element-menu-canvas").each(function () {
      $(this).find('.canvas-menu-btn-wrapper > a').on('click', function (event) {
        event.preventDefault();
        $(this).parent().parent().addClass('open');
      });
    });
    $(document).on('click', '.canvas-overlay-wrapper', function (event) {
      event.preventDefault();
      $(this).parent().removeClass('open');
    });
  }

}

class FuncCommon {
  constructor() {
    this._progressAnimation();

    this._createWrapStart();

    $('.mod-heading .widget-title > span').wrapStart();

    this._tbayActiveAdminBar();

    this._tbayResizeMegamenu();

    this._tbayTooltip();

    this._initHeaderCoverBG();

    this._initCanvasSearch();

    this._initTreeviewMenu();

    this._categoryMenu();

    this._initContentMinHeight();

    $(window).scroll(() => {
      this._tbayActiveAdminBar();
    });
    $(window).on("resize", () => {
      this._tbayResizeMegamenu();
    });

    this._addAccordionLoginandCoupon();
  }

  _tbayActiveAdminBar() {
    var objectSelect = $("#wpadminbar");

    if (objectSelect.length > 0) {
      $("body").addClass("active-admin-bar");
    }
  }

  _tbayTooltip() {
    $('[data-toggle="tooltip"]').tooltip();
  }

  _createWrapStart() {
    $.fn.wrapStart = function () {
      return this.each(function () {
        var $this = $(this);
        var node = $this.contents().filter(function () {
          return this.nodeType == 3;
        }).first(),
            text = node.text().trim(),
            first = text.split(' ', 1).join(" ");
        if (!node.length) return;
        node[0].nodeValue = text.slice(first.length);
        node.before('<b>' + first + '</b>');
      });
    };
  }

  _progressAnimation() {
    $("[data-progress-animation]").each(function () {
      var $this = $(this);
      $this.appear(function () {
        var delay = $this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1;
        if (delay > 1) $this.css("animation-delay", delay + "ms");
        setTimeout(function () {
          $this.animate({
            width: $this.attr("data-progress-animation")
          }, 800);
        }, delay);
      }, {
        accX: 0,
        accY: -50
      });
    });
  }

  _tbayResizeMegamenu() {
    var window_size = $('body').innerWidth();

    if ($('.tbay_custom_menu').length > 0 && $('.tbay_custom_menu').hasClass('tbay-vertical-menu')) {
      if (window_size > 767) {
        this._resizeMegaMenuOnDesktop();
      } else {
        this._initTreeViewForMegaMenuOnMobile();
      }
    }

    if ($('.tbay-megamenu').length > 0 && $('.tbay-megamenu,.tbay-offcanvas-main').hasClass('verticle-menu') && window_size > 767) {
      this._resizeMegaMenuVertical();
    }
  }

  _resizeMegaMenuVertical() {
    var full_width = parseInt($('#main-container.container').innerWidth());
    var menu_width = parseInt($('.verticle-menu').innerWidth());
    var w = full_width - menu_width;
    $('.verticle-menu').find('.aligned-fullwidth').children('.dropdown-menu').css({
      "max-width": w,
      "width": full_width - 30
    });
  }

  _resizeMegaMenuOnDesktop() {
    let maxWidth = $('#main-container.container').innerWidth() - $('.tbay-vertical-menu').innerWidth();
    let width = $('#main-container.container').innerWidth() - 30;
    $('.tbay-vertical-menu').find('.aligned-fullwidth').children('.dropdown-menu').css({
      'max-width': maxWidth,
      "width": width
    });
  }

  _initTreeViewForMegaMenuOnMobile() {
    $(".tbay-vertical-menu > .widget_nav_menu >.nav > ul").treeview(TREE_VIEW_OPTION_MEGA_MENU);
  }

  _addAccordionLoginandCoupon() {
    $('.showlogin, .showcoupon').click(function (event) {
      $(event.currentTarget).toggleClass('active');
    });
  }

  _initHeaderCoverBG() {
    let menu = $('.tbay-horizontal .navbar-nav > li,.tbay-horizontal-default .navbar-nav > li, .tbay_header-template .product-recently-viewed-header'),
        search = $('.tbay-search-form .tbay-search'),
        btn_category = $('.category-inside .category-inside-title'),
        cart_click = $('.cart-popup');
    menu.mouseenter(function () {
      if ($(this).parents('#tbay-header').length === 0) return;
      if ($(this).children('.dropdown-menu, ul, .content-view').length == 0) return;
      $('.tbay_header-template').addClass('nav-cover-active-1');
    }).mouseleave(function () {
      if ($(this).closest('.dropdown-menu').length) return;
      $('.tbay_header-template').removeClass('nav-cover-active-1');
    });
    search.focusin(function () {
      if ($(this).closest('.dropdown-menu').length) return;
      if (search.parents('.sidebar-canvas-search').length > 0 || $(this).closest('.tbay_header-template').length === 0) return;
      $('.tbay_header-template').addClass('nav-cover-active-2');
    }).focusout(function () {
      $('.tbay_header-template').removeClass('nav-cover-active-2');
    });
    cart_click.on('shown.bs.dropdown', function (event) {
      $(event.target).closest('.tbay_header-template').addClass('nav-cover-active-3');
    }).on('hidden.bs.dropdown', function (event) {
      $(event.target).closest('.tbay_header-template').removeClass('nav-cover-active-3');
    });

    if (btn_category.parents('.tbay_header-template')) {
      $(document.body).on('tbay_category_inside_open', () => {
        $('.tbay_header-template').addClass('nav-cover-active-4');
      });
      $(document.body).on('tbay_category_inside_close', () => {
        $('.tbay_header-template').removeClass('nav-cover-active-4');
      });
    }
  }

  _initCanvasSearch() {
    let input_search = $('#tbay-search-form-canvas .sidebar-canvas-search .sidebar-content .tbay-search');
    input_search.focusin(function () {
      input_search.parent().addClass('search_cv_active');
    }).focusout(function () {
      input_search.parent().removeClass('search_cv_active');
    });
  }

  _initTreeviewMenu() {
    $("#category-menu").addClass('treeview');
    jQuery(".treeview-menu .menu, #category-menu").treeview(TREE_VIEW_OPTION_MEGA_MENU);
    jQuery("#main-mobile-menu, #main-mobile-menu-xlg").treeview(TREE_VIEW_OPTION_MOBILE_MENU);
  }

  _categoryMenu() {
    $(".category-inside .category-inside-title").click(function () {
      $(event.target).parents('.category-inside').toggleClass("open");
      if ($(event.target).parents('.category-inside').hasClass('setting-open')) return;

      if ($(event.target).parents('.category-inside').hasClass('open')) {
        $(document.body).trigger('tbay_category_inside_open');
      } else {
        $(document.body).trigger('tbay_category_inside_close');
      }
    });
    let $win = $(window);
    $win.on("click.Bst,click touchstart tap", function (event) {
      let $box = $('.category-inside .category-inside-title, .category-inside-content');
      if (!$('.category-inside').hasClass('open') && !$('.tbay_header-template').hasClass('nav-cover-active-4')) return;

      if ($box.has(event.target).length == 0 && !$box.is(event.target)) {
        let insides = $('.category-inside');
        $.each(insides, function (key, inside) {
          if (!$(inside).hasClass('setting-open')) {
            $(inside).removeClass('open');
            $('.tbay_header-template').removeClass('nav-cover-active-4');
          }
        });
      }
    });
  }

  _initContentMinHeight() {
    let window_size = $('body').innerWidth(),
        $screen = $(window).height(),
        $header = $('.tbay_header-template').outerHeight(),
        $content = $('#tbay-main-content').outerHeight();

    if ($content < $screen && window_size > 1200) {
      $('#tbay-main-content').css('min-height', $screen - $header);
    }
  }

}

class NewsLetter {
  constructor() {
    this._init();
  }

  _init() {
    if ($('#popupNewsletterModal').length === 0) return;
    $('#popupNewsletterModal').on('hidden.bs.modal', function () {
      Cookies.set('hiddenmodal', 1, {
        expires: 0.1,
        path: '/'
      });
    });
    setTimeout(function () {
      if (Cookies.get('hiddenmodal') == "" || typeof Cookies.get('hiddenmodal') === "undefined") {
        $('#popupNewsletterModal').modal('show');
      }
    }, 3000);
  }

}

class Banner {
  constructor() {
    this._init();
  }

  _init() {
    let btnRemove = $('.banner-remove');

    if (btnRemove.length === 0) {
      $('.elementor-widget-kera-banner-close').each(function () {
        $(this).closest('section').addClass('section-banner-close');
      });
    } else {
      btnRemove.on('click', function (event) {
        event.preventDefault();
        let id = $(this).data('id');
        $(this).parents('.elementor-widget-kera-banner-close').slideUp("slow");
        Cookies.set('banner_remove_' + id, 'hidden', {
          expires: 0.1,
          path: '/'
        });
      });
    }
  }

}

class Search {
  constructor() {
    this._init();
  }

  _init() {
    this._searchToTop();

    this._searchCanvasForm();

    this._searchCanvasFormV3();

    $('.button-show-search').click(() => $('.tbay-search-form').addClass('active'));
    $('.button-hidden-search').click(() => $('.tbay-search-form').removeClass('active'));
  }

  _tbaySearchMobile() {
    $(".topbar-mobile .search-popup, .search-device-mobile").each(function () {
      $(this).find(".show-search").click(event => {
        $(this).find(".tbay-search-form").slideToggle(500);
        $(this).find(".tbay-search-form .input-group .tbay-search").focus();
        $(event.currentTarget).toggleClass('active');
      });
    });
    $(window).on("click.Bst,click touchstart tap", function (event) {
      var $box = $('.footer-device-mobile > div i, .topbar-device-mobile .search-device-mobile i ,.search-device-mobile .tbay-search-form form');
      if (!$(".search-device-mobile .show-search").hasClass('active')) return;

      if ($box.has(event.target).length == 0 && !$box.is(event.target)) {
        $(".search-device-mobile .tbay-search-form").slideUp(500);
        $(".search-device-mobile .show-search").removeClass('active');
        $("body").removeClass('mobile-search-active');
      }
    });
    $('.topbar-mobile .dropdown-menu').click(function (e) {
      e.stopPropagation();
    });
  }

  _searchToTop() {
    $('.search-totop-wrapper .btn-search-totop').click(function () {
      $('.search-totop-content').toggleClass('active');
      $(this).toggleClass('active');
    });
    var $box_totop = $('.search-totop-wrapper .btn-search-totop, .search-totop-content');
    $(window).on("click.Bst", function (event) {
      if ($box_totop.has(event.target).length == 0 && !$box_totop.is(event.target)) {
        $('.search-totop-wrapper .btn-search-totop').removeClass('active');
        $('.search-totop-content').removeClass('active');
      }
    });
  }

  _searchCanvasForm() {
    let searchform = $('#tbay-search-form-canvas');
    searchform.find('button.search-open').click(function () {
      $(event.target).parents('#tbay-search-form-canvas').toggleClass("open");
      $('body').toggleClass("active-search-canvas");
    });
    let window_searchcanvas = $(window);
    let forcussidebar = $('#tbay-search-form-canvas .search-open, #tbay-search-form-canvas .sidebar-content');
    window_searchcanvas.on("click.Bst", function (event) {
      if (!searchform.hasClass('open')) return;

      if (forcussidebar.has(event.target).length == 0 && !forcussidebar.is(event.target)) {
        searchform.removeClass("open");
        $('body').removeClass("active-search-canvas");
      }
    });
    searchform.find('button.btn-search-close').click(function () {
      if (!searchform.hasClass('open')) return;
      searchform.removeClass("open");
      $('body').removeClass("active-search-canvas");
    });
  }

  _searchCanvasFormV3() {
    let searchform = $('#tbay-search-form-canvas-v3');
    searchform.find('button.search-open').click(function () {
      $(event.target).parents('#tbay-search-form-canvas-v3').toggleClass("open");
      $('body').toggleClass("active-search-canvas");
    });
    let window_searchcanvas = $(window);
    let forcussidebar = $('#tbay-search-form-canvas-v3 .search-open, #tbay-search-form-canvas-v3 .sidebar-content');
    window_searchcanvas.on("click.Bst", function (event) {
      if (!searchform.hasClass('open')) return;

      if (forcussidebar.has(event.target).length == 0 && !forcussidebar.is(event.target)) {
        searchform.removeClass("open");
        $('body').removeClass("active-search-canvas");
      }
    });
    searchform.find('button.btn-search-close').click(function () {
      if (!searchform.hasClass('open')) return;
      searchform.removeClass("open");
      $('body').removeClass("active-search-canvas");
    });
  }

}

class TreeView {
  constructor() {
    this._tbayTreeViewMenu();
  }

  _tbayTreeViewMenu() {
    if (typeof $.fn.treeview === "undefined" || typeof $('.tbay-treeview') === "undefined") return;
    $(".tbay-treeview").each(function () {
      $(this).find('> ul').treeview({
        animated: 400,
        collapsed: true,
        unique: true,
        persist: "location"
      });
    });
  }

}

class Section {
  constructor() {
    this._tbayMegaMenu();

    this._tbayRecentlyView();
  }

  _tbayMegaMenu() {
    let menu = $('.elementor-widget-kera-nav-menu');
    if (menu.length === 0) return;
    menu.find('.tbay-element-nav-menu').each(function () {
      if ($(this).data('wrapper').layout !== "horizontal") return;

      if (!$(this).closest('.elementor-top-column').hasClass('tbay-column-static')) {
        $(this).closest('.elementor-top-column').addClass('tbay-column-static');
      }

      if (!$(this).closest('section').hasClass('tbay-section-static')) {
        $(this).closest('section').addClass('tbay-section-static');
      }
    });
  }

  _tbayRecentlyView() {
    let recently = $('.tbay-element-product-recently-viewed');
    if (recently.length === 0) return;
    recently.each(function () {
      if ($(this).data('wrapper').layout !== "header") return;

      if (!$(this).closest('.elementor-top-column').hasClass('tbay-column-static')) {
        $(this).closest('.elementor-top-column').addClass('tbay-column-static');
      }

      if (!$(this).closest('.elementor-top-column').hasClass('tbay-column-recentlyviewed')) {
        $(this).closest('.elementor-top-column').addClass('tbay-column-recentlyviewed');
      }

      if (!$(this).closest('section').hasClass('tbay-section-recentlyviewed')) {
        $(this).closest('section').addClass('tbay-section-recentlyviewed');
      }

      if (!$(this).closest('section').hasClass('tbay-section-static')) {
        $(this).closest('section').addClass('tbay-section-static');
      }
    });
  }

}

class Preload {
  constructor() {
    this._init();
  }

  _init() {
    if ($.fn.jpreLoader) {
      var $preloader = $('.js-preloader');
      $preloader.jpreLoader({}, function () {
        $preloader.addClass('preloader-done');
        $('body').trigger('preloader-done');
        $(window).trigger('resize');
      });
    }

    $('.tbay-page-loader').delay(100).fadeOut(400, function () {
      $('body').removeClass('tbay-body-loading');
      $(this).remove();
    });

    if ($(document.body).hasClass('tbay-body-loader')) {
      setTimeout(function () {
        $(document.body).removeClass('tbay-body-loader');
        $('.tbay-page-loader').fadeOut(250);
      }, 300);
    }
  }

}

class Accordion {
  constructor() {
    this._init();
  }

  _init() {
    if ($('.single-product').length === 0) return;
    $('#accordion').on('shown.bs.collapse', function (e) {
      var offset = $(this).find('.collapse.show').prev('.tabs-title');

      if (offset) {
        $('html,body').animate({
          scrollTop: $(offset).offset().top - 150
        }, 500);
      }
    });
  }

}

class MenuDropdownsAJAX {
  constructor() {
    this._initmenuDropdownsAJAX();
  }

  _initmenuDropdownsAJAX() {
    var _this = this;

    $('body').on('mousemove', function () {
      $('.menu').has('.dropdown-load-ajax').each(function () {
        var $menu = $(this);

        if ($menu.hasClass('dropdowns-loading') || $menu.hasClass('dropdowns-loaded')) {
          return;
        }

        if (!_this.isNear($menu, 50, event)) {
          return;
        }

        _this.loadDropdowns($menu);
      });
    });
  }

  loadDropdowns($menu) {
    var _this = this;

    $menu.addClass('dropdowns-loading');
    var storageKey = '',
        unparsedData = '',
        menu_mobile_id = '';

    if ($menu.closest('nav').attr('id') === 'tbay-mobile-menu-navbar') {
      if ($('#main-mobile-menu-mmenu-wrapper').length > 0) {
        menu_mobile_id += '_' + $('#main-mobile-menu-mmenu-wrapper').data('id');
      }

      if ($('#main-mobile-second-mmenu-wrapper').length > 0) {
        menu_mobile_id += '_' + $('#main-mobile-second-mmenu-wrapper').data('id');
      }

      storageKey = kera_settings.storage_key + '_megamenu_mobile' + menu_mobile_id;
    } else {
      storageKey = kera_settings.storage_key + '_megamenu_' + $menu.closest('nav').find('ul').data('id');
    }

    unparsedData = localStorage.getItem(storageKey);
    var storedData = false;
    var $items = $menu.find('.dropdown-load-ajax'),
        ids = [];
    $items.each(function () {
      ids.push($(this).find('.dropdown-html-placeholder').data('id'));
    });

    try {
      storedData = JSON.parse(unparsedData);
    } catch (e) {
      console.log('cant parse Json', e);
    }

    if (storedData) {
      _this.renderResults(storedData, $menu);

      if ($menu.attr('id') !== 'tbay-mobile-menu-navbar') {
        $menu.removeClass('dropdowns-loading').addClass('dropdowns-loaded');
      }
    } else {
      $.ajax({
        url: kera_settings.ajaxurl,
        data: {
          action: 'kera_load_html_dropdowns',
          ids: ids
        },
        dataType: 'json',
        method: 'POST',
        success: function (response) {
          if (response.status === 'success') {
            _this.renderResults(response.data, $menu);

            localStorage.setItem(storageKey, JSON.stringify(response.data));
          } else {
            console.log('loading html dropdowns returns wrong data - ', response.message);
          }
        },
        error: function () {
          console.log('loading html dropdowns ajax error');
        }
      });
    }
  }

  renderResults(data, $menu) {
    var _this = this;

    Object.keys(data).forEach(function (id) {
      _this.removeDuplicatedStylesFromHTML(data[id], function (html) {
        let html2 = html;
        const regex1 = '<li[^>]*><a[^>]*href=["]' + window.location.href + '["]>.*?<\/a><\/li>';
        let content = html.match(regex1);

        if (content !== null) {
          let $url = content[0];
          let $class = $url.match(/(?:class)=(?:["']\W+\s*(?:\w+)\()?["']([^'"]+)['"]/g)[0].split('"')[1];
          let $class_new = $class + ' active';
          let $url_new = $url.replace($class, $class_new);
          html2 = html2.replace($url, $url_new);
        }

        $menu.find('[data-id="' + id + '"]').replaceWith(html2);

        if ($menu.attr('id') !== 'tbay-mobile-menu-navbar') {
          $menu.addClass('dropdowns-loaded');
          setTimeout(function () {
            $menu.removeClass('dropdowns-loading');
          }, 1000);
        }
      });
    });
  }

  isNear($element, distance, event) {
    var left = $element.offset().left - distance,
        top = $element.offset().top - distance,
        right = left + $element.width() + 2 * distance,
        bottom = top + $element.height() + 2 * distance,
        x = event.pageX,
        y = event.pageY;
    return x > left && x < right && y > top && y < bottom;
  }

  removeDuplicatedStylesFromHTML(html, callback) {
    if (kera_settings.combined_css) {
      callback(html);
      return;
    } else {
      const regex = /<style>.*?<\/style>/mg;
      let output = html.replace(regex, "");
      callback(output);
      return;
    }
  }

}

class MenuClickAJAX {
  constructor() {
    if (typeof kera_settings === "undefined") return;

    this._initmenuClickAJAX();
  }

  _initmenuClickAJAX() {
    $('.element-menu-ajax.ajax-active').each(function () {
      var $menu = $(this);
      $menu.find('.menu-click').off('click').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.closest('.element-menu-ajax').hasClass('ajax-active')) return;
        var element = $this.closest('.tbay-element'),
            type_menu = element.data('wrapper')['type_menu'],
            layout = element.data('wrapper')['layout'];

        if (type_menu === 'toggle') {
          var nav = element.find('.category-inside-content > nav');
        } else {
          var nav = element.find('.menu-canvas-content > nav');
        }

        var slug = nav.data('id');
        var storageKey = kera_settings.storage_key + '_' + slug + '_' + layout;
        var storedData = false;
        var unparsedData = localStorage.getItem(storageKey);

        try {
          storedData = JSON.parse(unparsedData);
        } catch (e) {
          console.log('cant parse Json', e);
        }

        if (storedData) {
          nav.html(storedData);
          element.removeClass('load-ajax');
          $this.closest('.element-menu-ajax').removeClass('ajax-active');

          if (layout === 'treeview') {
            $(document.body).trigger('tbay_load_html_click_treeview');
          } else {
            $(document.body).trigger('tbay_load_html_click');
          }
        } else {
          $.ajax({
            url: kera_settings.ajaxurl,
            data: {
              action: 'kera_load_html_click',
              slug: slug,
              type_menu: type_menu,
              layout: layout
            },
            dataType: 'json',
            method: 'POST',
            beforeSend: function (xhr) {
              element.addClass('load-ajax');
            },
            success: function (response) {
              if (response.status === 'success') {
                nav.html(response.data);
                localStorage.setItem(storageKey, JSON.stringify(response.data));

                if (layout === 'treeview') {
                  $(document.body).trigger('tbay_load_html_click_treeview');
                } else {
                  $(document.body).trigger('tbay_load_html_click');
                }
              } else {
                console.log('loading html dropdowns returns wrong data - ', response.message);
              }

              element.removeClass('load-ajax');
              $this.closest('.element-menu-ajax').removeClass('ajax-active');
            },
            error: function () {
              console.log('loading html dropdowns ajax error');
            }
          });
        }
      });
    });
  }

}

class CanvastemplateAJAX {
  constructor() {
    this._initcanvastemplateAJAX();
  }

  _initcanvastemplateAJAX() {
    $('.canvas-template-ajax.ajax-active').each(function () {
      var $menu = $(this);
      $menu.find('.menu-click').off('click').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.closest('.canvas-template-ajax').hasClass('ajax-active')) return;
        var element = $this.parent().find('.canvas-menu-content'),
            nav = element.find('.content-canvas-menu');
        var id = $this.data('id');
        var storageKey = kera_settings.storage_key + '_' + id;
        var storedData = false;
        var unparsedData = localStorage.getItem(storageKey);

        try {
          storedData = JSON.parse(unparsedData);
        } catch (e) {
          console.log('cant parse Json', e);
        }

        if (storedData) {
          nav.html(storedData);
          element.removeClass('load-ajax');
          $this.closest('.canvas-template-ajax').removeClass('ajax-active');
          $(document.body).trigger('tbay_load_canvas_template_html_click');
        } else {
          $.ajax({
            url: kera_settings.ajaxurl,
            data: {
              action: 'kera_load_html_canvas_template_click',
              id: id
            },
            dataType: 'json',
            method: 'POST',
            beforeSend: function (xhr) {
              element.addClass('load-ajax');
            },
            success: function (response) {
              if (response.status === 'success') {
                nav.html(response.data);
                localStorage.setItem(storageKey, JSON.stringify(response.data));
                $(document.body).trigger('tbay_load_canvas_template_html_click');
              } else {
                console.log('loading html dropdowns returns wrong data - ', response.message);
              }

              element.removeClass('load-ajax');
              $this.closest('.canvas-template-ajax').removeClass('ajax-active');
            },
            error: function () {
              console.log('loading html dropdowns ajax error');
            }
          });
        }
      });
    });
  }

}

window.$ = window.jQuery;
$(document).ready(() => {
  new CanvastemplateAJAX(), new MenuDropdownsAJAX(), new MenuClickAJAX(), new StickyHeader(), new AccountMenu(), new BackToTop(), new CanvasMenu(), new FuncCommon(), new NewsLetter(), new Banner(), new Preload(), new Search(), new TreeView(), new Accordion(), new Section();

  if (jQuery.browser.mobile || $(window).width() < 1200) {
    var mobile = new Mobile();

    mobile._topBarDevice();

    jQuery(window).scroll(() => {
      mobile._topBarDevice();

      mobile._initTopNavbar();
    });
  }
});
setTimeout(function () {
  jQuery(document.body).on('tbay_load_html_click_treeview', () => {
    new TreeView();
  });
}, 2000);
$(window).on("resize", () => {
  if (jQuery.browser.mobile || $(window).width() < 1200) {
    var mobile = new Mobile();

    mobile._topBarDevice();

    jQuery(window).scroll(() => {
      mobile._topBarDevice();

      mobile._initTopNavbar();
    });
  }
});

var CanvasMenuHandler = function ($scope, $) {
  var Canvasmenu = new CanvasMenu();

  Canvasmenu._initCanvasMenu();
};

jQuery(window).on('elementor/frontend/init', function () {
  elementorFrontend.hooks.addFilter('frontend/element_ready/kera-nav-menu.default', CanvasMenuHandler);
});
