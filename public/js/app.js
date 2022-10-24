/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! ./backend/helpers */ "./resources/js/backend/helpers.js");

__webpack_require__(/*! ./backend/backend */ "./resources/js/backend/backend.js");

__webpack_require__(/*! ./backend/sameHeight */ "./resources/js/backend/sameHeight.js");

__webpack_require__(/*! ./backend/modal */ "./resources/js/backend/modal.js");

__webpack_require__(/*! ./backend/menus */ "./resources/js/backend/menus.js");

/***/ }),

/***/ "./resources/js/backend/backend.js":
/*!*****************************************!*\
  !*** ./resources/js/backend/backend.js ***!
  \*****************************************/
/***/ (() => {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

$(window).add(document).on('ready load resize DOMSubtreeModified', function () {
  var windowWidth = $(window).width(),
      $body = $('body').removeClass('is-desktop is-tablet is-mobile');

  if (windowWidth >= 1024) {
    $body.addClass('is-desktop');
  } else if (windowWidth >= 769) {
    $body.addClass('is-tablet');
  } else {
    $body.addClass('is-mobile');
  }
});
$(document).ready(function () {
  /**
   * Init jQuery UI plugins
   */
  $('.ui-sortable').sortable();
  /**
   * Init Ace Code Editor
   */

  $('textarea.is-code').each(function () {
    var $textarea = $(this).hide(),
        editorMode = $textarea.data('editor-mode') || "ace/mode/html",
        editorMaxLines = $textarea.data('editor-max-lines') || $textarea.attr('rows') || 30;
    var $editor = $('<div />').addClass('code-editor').css('min-height', editorMaxLines + 'em').insertAfter($textarea);
    var editor = ace.edit($editor.get(0), {
      mode: editorMode,
      maxLines: parseInt(editorMaxLines),
      useWorker: false
    });
    editor.setValue($textarea.val(), -1);
    editor.session.on('change', function () {
      $textarea.val(editor.session.getValue());
    });
  });
});
$(document).on('change', '.file .file-input', function (e) {
  var $fileInput = $(this),
      $file = $fileInput.parents('.file').first(),
      $fileLabel = $file.find('label.file-label').first(),
      $fileName = $file.find('.file-name').first();
  $file.addClass('has-name');

  if ($fileName.length === 0) {
    $fileName = $('<span class="file-name"></span>').appendTo($fileLabel);
  }

  if (_typeof(e.target.files) === 'object' && e.target.files.length > 0) {
    $fileName.text(e.target.files[0].name);
  } else {
    $fileName.text('');
  }
});

/***/ }),

/***/ "./resources/js/backend/helpers.js":
/*!*****************************************!*\
  !*** ./resources/js/backend/helpers.js ***!
  \*****************************************/
/***/ (() => {

$(document).on('change sortupdate', 'form.autosave', function () {
  $(this).submit();
}).on('click', '[data-clear]', function (e) {
  e.preventDefault();
  var $this = $(this),
      target = $this.data('clear'),
      $target = $(target),
      $inputs = $target.find(':input');
  $inputs.val('').prop('checked', false);

  if ($this.attr('type') === 'submit') {
    $target.parents('form').submit();
  }
}).on('input', 'input.slug', function () {
  var $input = $(this),
      slug = $input.val().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
  $input.val(slug);
}).on('focus', 'input.slug[data-slug-from]', function () {
  var $input = $(this),
      from = $input.data('slug-from'),
      $from = $(from).first();

  if (!$input.val() && $from.length === 1) {
    var slug = $from.val().toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    $input.val(slug).trigger('input');
  }
}).on('click', '[data-confirm]', function () {
  return window.confirm($(this).data('confirm'));
}).on('mason:lockable:init', '.is-lockable', function (e) {
  var $this = $(this),
      $input = $this.find('.input'),
      $lock = $this.find('.lock'),
      $unlock = $this.find('.unlock');

  if ($this.hasClass('is-locked') || $input.prop('disabled')) {
    $this.trigger('mason:lockable:lock');
  } else {
    $this.trigger('mason:lockable:unlock');
  }

  $lock.on('click', function (e) {
    e.preventDefault();
    $this.trigger('mason:lockable:lock');
  });
  $unlock.on('click', function (e) {
    e.preventDefault();
    $this.trigger('mason:lockable:unlock');
  });
}).on('mason:lockable:lock', '.is-lockable', function () {
  var $this = $(this),
      $input = $this.find('.input'),
      $lock = $this.find('.lock'),
      $unlock = $this.find('.unlock');
  $this.addClass('is-locked');
  $input.prop('disabled', true);
  $lock.addClass('is-hidden');
  $unlock.removeClass('is-hidden');
}).on('mason:lockable:unlock', '.is-lockable', function () {
  var $this = $(this),
      $input = $this.find('.input'),
      $lock = $this.find('.lock'),
      $unlock = $this.find('.unlock');
  $this.removeClass('is-locked');
  $input.prop('disabled', false);
  $unlock.addClass('is-hidden');
  $lock.removeClass('is-hidden');
}).on('ready DOMSubtreeModified', function () {
  $('.is-lockable').trigger('mason:lockable:init');
}).on('click', '[rel="expand"]', function (e) {
  e.preventDefault();
  var $this = $(this),
      href = $this.attr('href'),
      $href = $(href);
  $href.removeClass('is-hidden');
}).on('click', '[rel="collapse"]', function (e) {
  e.preventDefault();
  var $this = $(this),
      href = $this.attr('href'),
      $href = $(href);
  $href.addClass('is-hidden');
}).on('click', '[rel="toggle"]', function (e) {
  e.preventDefault();
  var $this = $(this),
      href = $this.attr('href'),
      $href = $(href);
  $href.toggleClass('is-hidden');
}).on('click', '[data-method]', function (e) {
  e.preventDefault();
  var $this = $(this),
      method = $this.data('method'),
      href = $this.attr('href');
  var $form = $('<form>').attr('action', href).attr('method', 'POST').append($('<input>').attr('type', 'hidden').attr('name', '_method').attr('value', method)).append($('<input>').attr('type', 'hidden').attr('name', '_token').attr('value', $('meta[name="csrf-token"]').attr('content'))).appendTo('body');
  return $form.submit();
});

/***/ }),

/***/ "./resources/js/backend/menus.js":
/*!***************************************!*\
  !*** ./resources/js/backend/menus.js ***!
  \***************************************/
/***/ (() => {

$(document).on('change', '#item-target', function () {
  var $itemTarget = $(this),
      $itemTargetOptionSelected = $itemTarget.find('option:selected'),
      itemTargetValue = $itemTarget.val(),
      itemTargetText = $itemTargetOptionSelected.length === 1 ? $itemTargetOptionSelected.text() : '',
      itemTargetUrl = $itemTargetOptionSelected.length === 1 ? $itemTargetOptionSelected.data('url') : '',
      $itemTitle = $('#item-title'),
      $itemHref = $('#item-href');

  if ($itemTitle.length === 1) {
    if (itemTargetValue) {
      $itemTitle.val(itemTargetText);
    } else {
      $itemTitle.val('');
    }
  }

  if ($itemHref.length === 1) {
    $itemHref.val(itemTargetUrl);
  }
}).on('ready', function () {
  /**
   * When a new menu item has just been created it will bear the .is-new class and we should trigger the
   * edit action right away, which will open a modal window.
   */
  $('.menu-item.is-new').first().find('.edit-menu-item').click();
});

/***/ }),

/***/ "./resources/js/backend/modal.js":
/*!***************************************!*\
  !*** ./resources/js/backend/modal.js ***!
  \***************************************/
/***/ (() => {

$(document).on('click', '[rel="open-modal"]', function (e) {
  e.preventDefault();
  var $this = $(this),
      href = $this.attr('href'),
      $modal;

  if (typeof href === 'string' && href.length > 0 && href.indexOf("#") === 0) {
    $modal = $(href);
    $modal.trigger('mason:modal:open');
  } else {
    var $modalContainer = $('<div class="modal-container"></div>');
    $modalContainer.appendTo($('body')).load(href, function () {
      $modal = $modalContainer.children('.modal').last().addClass('is-ajax');
      $modal.trigger('mason:modal:open');
    });
  }
}).on('click', '[rel="close-modal"]', function (e) {
  e.preventDefault();
  var $this = $(this),
      href = $this.attr('href'),
      $modal;

  if (typeof href === 'string' && href.length > 0 && href.indexOf("#") === 0) {
    $modal = href;
  } else {
    $modal = $this.parents('.modal').first();
  }

  $modal.trigger('mason:modal:close');
}).on('click', '.modal-background', function (e) {
  e.preventDefault();
  var $modalBackground = $(this),
      $modal = $modalBackground.parents('.modal').first();
  $modal.trigger('mason:modal:close');
}).on('keyup', function (e) {
  if (e.key === "Escape") {
    $('.modal.is-active').trigger('mason:modal:close');
  }
}).on('mason:modal:open', '.modal', function () {
  var $modal = $(this);
  $modal.addClass('is-active');
  $('html').addClass('is-clipped');
  $modal.trigger('mason:modal:open:done');
}).on('mason:modal:close', '.modal', function () {
  var $modal = $(this);
  $modal.removeClass('is-active');

  if ($('.modal.is-active').length === 0) {
    $('html').removeClass('is-clipped');
  }

  $modal.trigger('mason:modal:close:done');

  if ($modal.hasClass('is-ajax')) {
    $modal.remove();
  }
});

/***/ }),

/***/ "./resources/js/backend/sameHeight.js":
/*!********************************************!*\
  !*** ./resources/js/backend/sameHeight.js ***!
  \********************************************/
/***/ (() => {

$(document).on('ready', function () {
  var $body = $('body');
  $(document).on('mason:sameHeight:resize', '.same-height-cards', function () {
    var $group = $(this),
        $cards = $group.find('.card'),
        maxHeight = 0;
    $cards.each(function () {
      var $card = $(this),
          $spacer = $card.children('.card-spacer').height(0),
          height = parseInt($card.height());
      if (height > maxHeight) maxHeight = height;
    });

    if (!$body.hasClass('is-mobile')) {
      $cards.each(function () {
        var $card = $(this),
            height = parseInt($card.height()),
            $spacer = $card.children('.card-spacer').last(),
            spacing = maxHeight - height;
        $spacer.height(spacing);
      });
    }
  });
});
$(window).add(document).on('ready load resize', function () {
  $('.same-height-cards').trigger('mason:sameHeight:resize');
});

/***/ }),

/***/ "./resources/sass/app.sass":
/*!*********************************!*\
  !*** ./resources/sass/app.sass ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.sass")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;