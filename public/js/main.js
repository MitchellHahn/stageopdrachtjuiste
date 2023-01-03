/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/main.js":
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var slide_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! slide-element */ "./node_modules/.pnpm/slide-element@2.3.0/node_modules/slide-element/dist/index.es.js");

var mobileNav = document.querySelector('#navbarSupportedContent');
var navBtn = document.querySelector('.nav-btn');
if (navBtn) {
  navBtn.addEventListener('click', function () {
    if (this.classList.contains('is-active')) {
      this.classList.remove('is-active');
      (0,slide_element__WEBPACK_IMPORTED_MODULE_0__.up)(mobileNav);
    } else {
      this.classList.add('is-active');
      (0,slide_element__WEBPACK_IMPORTED_MODULE_0__.down)(mobileNav);
    }
  });
}

/***/ }),

/***/ "./resources/sass/style.scss":
/*!***********************************!*\
  !*** ./resources/sass/style.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/.pnpm/slide-element@2.3.0/node_modules/slide-element/dist/index.es.js":
/*!********************************************************************************************!*\
  !*** ./node_modules/.pnpm/slide-element@2.3.0/node_modules/slide-element/dist/index.es.js ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "down": () => (/* binding */ down),
/* harmony export */   "toggle": () => (/* binding */ toggle),
/* harmony export */   "up": () => (/* binding */ up)
/* harmony export */ });
const afterNextRepaint = (callback) => {
  return new Promise((resolve) => {
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        callback(resolve);
      });
    });
  });
};
let defaultOptions = {
  easing: "ease",
  duration: 250,
  fill: "backwards",
  display: "block",
  overflow: "hidden"
};
let nonAnimatableOptions = ["overflow", "display"];
let SlideController = (element, options) => {
  let mergedOptions = Object.assign({}, defaultOptions, options);
  let openDisplayValue = mergedOptions.display;
  let closedDisplayValue = "none";
  let setDisplay = (value) => element.style.display = value;
  let getHeight = () => element.clientHeight + "px";
  let getComputed = () => window.getComputedStyle(element);
  let setOverflow = (set) => element.style.overflow = set ? mergedOptions.overflow : "";
  let getAnimations = () => element.getAnimations();
  let createAnimation = (willOpen, lowerBound) => {
    var _a;
    nonAnimatableOptions.forEach((property) => delete mergedOptions[property]);
    let currentHeight = getHeight();
    let frames = [currentHeight, lowerBound].map((height) => ({
      height,
      paddingTop: "0px",
      paddingBottom: "0px"
    }));
    let { paddingTop, paddingBottom } = getComputed();
    frames[0].paddingTop = paddingTop;
    frames[0].paddingBottom = paddingBottom;
    if (willOpen) {
      frames[0].height = currentHeight;
      frames.reverse();
    }
    if ((_a = window.matchMedia("(prefers-reduced-motion: reduce)")) == null ? void 0 : _a.matches) {
      mergedOptions.duration = 0;
    }
    let animation = element.animate(frames, mergedOptions);
    animation.id = (+willOpen).toString();
    return animation;
  };
  let triggerAnimation = async (willOpen) => {
    let finishedAnimations = getAnimations().map((a) => a.finish());
    await afterNextRepaint(async (resolve) => {
      let currentHeight = willOpen ? getHeight() : "0px";
      if (willOpen)
        setDisplay(openDisplayValue);
      setOverflow(true);
      await createAnimation(willOpen, currentHeight).finished;
      setOverflow(false);
      if (!willOpen)
        setDisplay(closedDisplayValue);
      resolve();
    });
    return finishedAnimations.length ? null : willOpen;
  };
  let up2 = async () => triggerAnimation(false);
  let down2 = async () => triggerAnimation(true);
  let toggle2 = async () => {
    var _a;
    let existingAnimationId = (_a = getAnimations()[0]) == null ? void 0 : _a.id;
    let condition = existingAnimationId ? existingAnimationId === "1" : element.offsetHeight;
    return (condition ? up2 : down2)();
  };
  return {
    up: up2,
    down: down2,
    toggle: toggle2
  };
};
let down = (element, options = {}) => SlideController(element, options).down();
let up = (element, options = {}) => SlideController(element, options).up();
let toggle = (element, options = {}) => SlideController(element, options).toggle();



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
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
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
/******/ 			"/js/main": 0,
/******/ 			"css/style": 0
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
/******/ 	__webpack_require__.O(undefined, ["css/style"], () => (__webpack_require__("./resources/js/main.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/style"], () => (__webpack_require__("./resources/sass/style.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;