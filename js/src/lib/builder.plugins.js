'use strict';


/**!
 * Sortable
 * @author	RubaXa   <trash@rubaxa.org>
 * @license MIT
 */

(function sortableModule(factory) {
	"use strict";

	if (typeof define === "function" && define.amd) {
		define(factory);
	}
	else if (typeof module != "undefined" && typeof module.exports != "undefined") {
		module.exports = factory();
	}
	else if (typeof Package !== "undefined") {
		//noinspection JSUnresolvedVariable
		Sortable = factory();  // export for Meteor.js
	}
	else {
		/* jshint sub:true */
		window["Sortable"] = factory();
	}
})(function sortableFactory() {
	"use strict";

	if (typeof window == "undefined" || !window.document) {
		return function sortableError() {
			throw new Error("Sortable.js requires a window with a document");
		};
	}

	var dragEl,
		parentEl,
		ghostEl,
		cloneEl,
		rootEl,
		nextEl,

		scrollEl,
		scrollParentEl,
		scrollCustomFn,

		lastEl,
		lastCSS,
		lastParentCSS,

		oldIndex,
		newIndex,

		activeGroup,
		putSortable,

		autoScroll = {},

		tapEvt,
		touchEvt,

		moved,

		/** @const */
		RSPACE = /\s+/g,

		expando = 'Sortable' + (new Date).getTime(),

		win = window,
		document = win.document,
		parseInt = win.parseInt,

		$ = win.jQuery || win.Zepto,
		Polymer = win.Polymer,

		supportDraggable = !!('draggable' in document.createElement('div')),
		supportCssPointerEvents = (function (el) {
			// false when IE11
			if (!!navigator.userAgent.match(/Trident.*rv[ :]?11\./)) {
				return false;
			}
			el = document.createElement('x');
			el.style.cssText = 'pointer-events:auto';
			return el.style.pointerEvents === 'auto';
		})(),

		_silent = false,

		abs = Math.abs,
		min = Math.min,
		slice = [].slice,

		touchDragOverListeners = [],

		_autoScroll = _throttle(function (/**Event*/evt, /**Object*/options, /**HTMLElement*/rootEl) {
			// Bug: https://bugzilla.mozilla.org/show_bug.cgi?id=505521
			if (rootEl && options.scroll) {
				var el,
					rect,
					sens = options.scrollSensitivity,
					speed = options.scrollSpeed,

					x = evt.clientX,
					y = evt.clientY,

					winWidth = window.innerWidth,
					winHeight = window.innerHeight,

					vx,
					vy,

					scrollOffsetX,
					scrollOffsetY
				;

				// console.log( "y:" ); console.log( y );

				// Delect scrollEl
				if (scrollParentEl !== rootEl) {
					scrollEl = options.scroll;
					scrollParentEl = rootEl;
					scrollCustomFn = options.scrollFn;

					if (scrollEl === true) {
						scrollEl = rootEl;

						do {
							if ((scrollEl.offsetWidth < scrollEl.scrollWidth) ||
								(scrollEl.offsetHeight < scrollEl.scrollHeight)
							) {
								// console.log( 'GOING TO break' );
								break;
							}
							/* jshint boss:true */
						} while (scrollEl = scrollEl.parentNode);
					}
				}
/*
				if (scrollEl) {
					// console.log( "_autoScroll > 1" );
					// el = scrollEl;
					var iframedoc = document.getElementById('page-builder-frame').contentDocument;
					el = iframedoc.getElementsByTagName('body')[0];
					// console.log( "el:" ); console.log( el );
					rect = el.getBoundingClientRect();
					// rect = scrollEl.getBoundingClientRect();
					// console.log( "rect:" ); console.log( rect );
					// console.log( "(rect.bottom - y):" ); console.log( (abs(rect.bottom - y) <= sens) );
					// console.log( "(rect.top - y):" ); console.log( (abs(rect.top - y) ) );
					console.log( "y:" ); console.log( y );
					console.log( "winHeight - y:" ); console.log( winHeight - y );
					vx = (abs(rect.right - x) <= sens) - (abs(rect.left - x) <= sens);
					vy = (winHeight - y <= sens) - (y <= sens);
					// vy = (abs(rect.bottom - y) <= sens) - (abs(rect.top - y) <= sens);
					// vy = 1;
				}
*/
				// console.log( "if   vy:" + vy );

				// if (!(vx || vy)) {
					// console.log( "_autoScroll > 2" );
					vx = (winWidth - x <= sens) - (x <= sens);
					// console.log( "winHeight: " + winHeight );
					// console.log( "y: " + y );
					// console.log( "sens: " + sens );
					// console.log( "(winHeight - y <= sens):" ); console.log( (winHeight - y <= sens) );
					// console.log( "(y <= sens):" ); console.log( (y <= sens) );
					vy = (winHeight - y <= sens) - (y <= sens);

					// console.log( "vy:" + vy );

					// vy: 0 / 1 - scroll down / -1 - scroll up

					/* jshint expr:true */
					(vx || vy) && (el = win);
				// }

				// document.getElementById('log-1').textContent = 'vx: ' + vx;
				// document.getElementById('log-2').textContent = 'vy: ' + vy;

				// document.getElementById('log-3').textContent = 'autoScroll.vx: ' + autoScroll.vx;
				// document.getElementById('log-4').textContent = 'autoScroll.vy: ' + autoScroll.vy;

				// // autoScroll.vy: 0 / 1 - scroll down / -1 - scroll up

				// document.getElementById('log-5').textContent = 'autoScroll.el: ' + autoScroll.el;
				// document.getElementById('log-6').textContent = 'el: ' + el;


				// if (autoScroll.vx !== vx) {
				// 	console.log('AAAAA');
				// }

				// if (autoScroll.vy !== vy) {
				// 	console.log('BBBBB');
				// }

				// if (autoScroll.el !== el) {
				// 	console.log('CCCCC');
				// }

				if (autoScroll.vx !== vx || autoScroll.vy !== vy || autoScroll.el !== el) {
					// console.log( "_autoScroll > 3" );
					autoScroll.el = el;
					autoScroll.vx = vx;
					autoScroll.vy = vy;


					clearInterval(autoScroll.pid);

					if (el) {
						autoScroll.pid = setInterval(function () {
							console.log( "vy :" ); console.log( vy  );
							scrollOffsetY = vy ? vy * speed : 0;
							scrollOffsetX = vx ? vx * speed : 0;

							if ('function' === typeof(scrollCustomFn)) {
								return scrollCustomFn.call(_this, scrollOffsetX, scrollOffsetY, evt);
							}

							if (el === win) {
								// Scroll the window.
								// console.log( "_autoScroll > 4A" );
								// console.log( "el:" ); console.log( el );
								// console.log( "win:" ); console.log( win );
								var iframewin = document.getElementById('page-builder-frame').contentWindow;
								// console.log( "iframewin.pageYOffset:" ); console.log( iframewin.pageYOffset );
								// console.log( "scrollOffsetY:" ); console.log( scrollOffsetY );
								// console.log( "iframewin.pageXOffset + scrollOffsetX:" ); console.log( iframewin.pageXOffset + scrollOffsetX );
iframewin.scrollTo(iframewin.pageXOffset + scrollOffsetX, iframewin.pageYOffset + scrollOffsetY);
							} else {
								// Scroll the element only.
								// console.log( "_autoScroll > 4B" );
								el.scrollTop += scrollOffsetY;
								el.scrollLeft += scrollOffsetX;
							}
						}, 24);
					}
				}
			}
		}, 30),

		_prepareGroup = function (options) {
			function toFn(value, pull) {
				if (value === void 0 || value === true) {
					value = group.name;
				}

				if (typeof value === 'function') {
					return value;
				} else {
					return function (to, from) {
						var fromGroup = from.options.group.name;

						return pull
							? value
							: value && (value.join
								? value.indexOf(fromGroup) > -1
								: (fromGroup == value)
							);
					};
				}
			}

			var group = {};
			var originalGroup = options.group;

			if (!originalGroup || typeof originalGroup != 'object') {
				originalGroup = {name: originalGroup};
			}

			group.name = originalGroup.name;
			group.checkPull = toFn(originalGroup.pull, true);
			group.checkPut = toFn(originalGroup.put);

			options.group = group;
		}
	;



	/**
	 * @class  Sortable
	 * @param  {HTMLElement}  el
	 * @param  {Object}       [options]
	 */
	function Sortable(el, options) {
		if (!(el && el.nodeType && el.nodeType === 1)) {
			throw 'Sortable: `el` must be HTMLElement, and not ' + {}.toString.call(el);
		}

		this.el = el; // root element
		this.options = options = _extend({}, options);


		// Export instance
		el[expando] = this;


		// Default options
		var defaults = {
			group: Math.random(),
			sort: true,
			disabled: false,
			store: null,
			handle: null,

			scroll: true,
			scrollSensitivity: 230,
			scrollSpeed: 10,

			draggable: /[uo]l/i.test(el.nodeName) ? 'li' : '>*',
			ghostClass: 'sortable-ghost',
			chosenClass: 'sortable-chosen',
			dragClass: 'sortable-drag',
			ignore: 'a, img',
			filter: null,
			animation: 0,
			setData: function (dataTransfer, dragEl) {
				dataTransfer.setData('Text', dragEl.textContent);
			},
			dropBubble: false,
			dragoverBubble: false,
			dataIdAttr: 'data-id',
			delay: 0,
			forceFallback: false,
			fallbackClass: 'sortable-fallback',
			fallbackOnBody: false,
			fallbackTolerance: 0,
			fallbackOffset: {x: 0, y: 0}
		};


		// Set default options
		for (var name in defaults) {
			!(name in options) && (options[name] = defaults[name]);
		}

		_prepareGroup(options);

		// Bind all private methods
		for (var fn in this) {
			if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
				this[fn] = this[fn].bind(this);
			}
		}

		// Setup drag mode
		this.nativeDraggable = options.forceFallback ? false : supportDraggable;

		// Bind events
		_on(el, 'mousedown', this._onTapStart);
		_on(el, 'touchstart', this._onTapStart);
		_on(el, 'pointerdown', this._onTapStart);

		if (this.nativeDraggable) {
			_on(el, 'dragover', this);
			_on(el, 'dragenter', this);
		}

		touchDragOverListeners.push(this._onDragOver);

		// Restore sorting
		options.store && this.sort(options.store.get(this));
	}


	Sortable.prototype = /** @lends Sortable.prototype */ {
		constructor: Sortable,

		_onTapStart: function (/** Event|TouchEvent */evt) {
			var _this = this,
				el = this.el,
				options = this.options,
				type = evt.type,
				touch = evt.touches && evt.touches[0],
				target = (touch || evt).target,
				originalTarget = evt.target.shadowRoot && evt.path[0] || target,
				filter = options.filter,
				startIndex;

			// Don't trigger start event when an element is been dragged, otherwise the evt.oldindex always wrong when set option.group.
			if (dragEl) {
				return;
			}

			if (type === 'mousedown' && evt.button !== 0 || options.disabled) {
				return; // only left button or enabled
			}

			if (options.handle && !_closest(originalTarget, options.handle, el)) {
				return;
			}

			target = _closest(target, options.draggable, el);

			if (!target) {
				return;
			}

			// Get the index of the dragged element within its parent
			startIndex = _index(target, options.draggable);

			// Check filter
			if (typeof filter === 'function') {
				if (filter.call(this, evt, target, this)) {
					_dispatchEvent(_this, originalTarget, 'filter', target, el, startIndex);
					evt.preventDefault();
					return; // cancel dnd
				}
			}
			else if (filter) {
				filter = filter.split(',').some(function (criteria) {
					criteria = _closest(originalTarget, criteria.trim(), el);

					if (criteria) {
						_dispatchEvent(_this, criteria, 'filter', target, el, startIndex);
						return true;
					}
				});

				if (filter) {
					evt.preventDefault();
					return; // cancel dnd
				}
			}

			// Prepare `dragstart`
			this._prepareDragStart(evt, touch, target, startIndex);
		},

		_prepareDragStart: function (/** Event */evt, /** Touch */touch, /** HTMLElement */target, /** Number */startIndex) {
			var _this = this,
				el = _this.el,
				options = _this.options,
				ownerDocument = el.ownerDocument,
				dragStartFn;

			if (target && !dragEl && (target.parentNode === el)) {
				tapEvt = evt;

				rootEl = el;
				dragEl = target;
				parentEl = dragEl.parentNode;
				nextEl = dragEl.nextSibling;
				activeGroup = options.group;
				oldIndex = startIndex;

				this._lastX = (touch || evt).clientX;
				this._lastY = (touch || evt).clientY;

				dragEl.style['will-change'] = 'transform';

				dragStartFn = function () {
					// Delayed drag has been triggered
					// we can re-enable the events: touchmove/mousemove
					_this._disableDelayedDrag();

					// Make the element draggable
					dragEl.draggable = _this.nativeDraggable;

					// Chosen item
					_toggleClass(dragEl, options.chosenClass, true);

					// Bind the events: dragstart/dragend
					_this._triggerDragStart(evt, touch);

					// Drag start event
					_dispatchEvent(_this, rootEl, 'choose', dragEl, rootEl, oldIndex);
				};

				// Disable "draggable"
				options.ignore.split(',').forEach(function (criteria) {
					_find(dragEl, criteria.trim(), _disableDraggable);
				});

				_on(ownerDocument, 'mouseup', _this._onDrop);
				_on(ownerDocument, 'touchend', _this._onDrop);
				_on(ownerDocument, 'touchcancel', _this._onDrop);
				_on(ownerDocument, 'pointercancel', _this._onDrop);

				if (options.delay) {
					// If the user moves the pointer or let go the click or touch
					// before the delay has been reached:
					// disable the delayed drag
					_on(ownerDocument, 'mouseup', _this._disableDelayedDrag);
					_on(ownerDocument, 'touchend', _this._disableDelayedDrag);
					_on(ownerDocument, 'touchcancel', _this._disableDelayedDrag);
					_on(ownerDocument, 'mousemove', _this._disableDelayedDrag);
					_on(ownerDocument, 'touchmove', _this._disableDelayedDrag);
					_on(ownerDocument, 'pointermove', _this._disableDelayedDrag);

					_this._dragStartTimer = setTimeout(dragStartFn, options.delay);
				} else {
					dragStartFn();
				}
			}
		},

		_disableDelayedDrag: function () {
			var ownerDocument = this.el.ownerDocument;

			clearTimeout(this._dragStartTimer);
			_off(ownerDocument, 'mouseup', this._disableDelayedDrag);
			_off(ownerDocument, 'touchend', this._disableDelayedDrag);
			_off(ownerDocument, 'touchcancel', this._disableDelayedDrag);
			_off(ownerDocument, 'mousemove', this._disableDelayedDrag);
			_off(ownerDocument, 'touchmove', this._disableDelayedDrag);
			_off(ownerDocument, 'pointermove', this._disableDelayedDrag);
		},

		_triggerDragStart: function (/** Event */evt, /** Touch */touch) {
			touch = touch || (evt.pointerType == 'touch' ? evt : null);
			if (touch) {
				// Touch device support
				tapEvt = {
					target: dragEl,
					clientX: touch.clientX,
					clientY: touch.clientY
				};

				this._onDragStart(tapEvt, 'touch');
			}
			else if (!this.nativeDraggable) {
				this._onDragStart(tapEvt, true);
			}
			else {
				_on(dragEl, 'dragend', this);
				_on(rootEl, 'dragstart', this._onDragStart);
			}

			try {
				if (document.selection) {					
					// Timeout neccessary for IE9					
					setTimeout(function () {
						document.selection.empty();
					});					
				} else {
					window.getSelection().removeAllRanges();
				}
			} catch (err) {
			}
		},

		_dragStarted: function () {
			if (rootEl && dragEl) {
				var options = this.options;

				// Apply effect
				_toggleClass(dragEl, options.ghostClass, true);
				_toggleClass(dragEl, options.dragClass, false);

				Sortable.active = this;

				// Drag start event
				_dispatchEvent(this, rootEl, 'start', dragEl, rootEl, oldIndex);
			}
		},

		_emulateDragOver: function () {
			if (touchEvt) {
				if (this._lastX === touchEvt.clientX && this._lastY === touchEvt.clientY) {
					return;
				}

				this._lastX = touchEvt.clientX;
				this._lastY = touchEvt.clientY;

				if (!supportCssPointerEvents) {
					_css(ghostEl, 'display', 'none');
				}

				var target = document.elementFromPoint(touchEvt.clientX, touchEvt.clientY),
					parent = target,
					i = touchDragOverListeners.length;

				if (parent) {
					do {
						if (parent[expando]) {
							while (i--) {
								touchDragOverListeners[i]({
									clientX: touchEvt.clientX,
									clientY: touchEvt.clientY,
									target: target,
									rootEl: parent
								});
							}

							break;
						}

						target = parent; // store last element
					}
					/* jshint boss:true */
					while (parent = parent.parentNode);
				}

				if (!supportCssPointerEvents) {
					_css(ghostEl, 'display', '');
				}
			}
		},


		_onTouchMove: function (/**TouchEvent*/evt) {
			console.log( '_onTouchMove' );
			if (tapEvt) {
				var	options = this.options,
					fallbackTolerance = options.fallbackTolerance,
					fallbackOffset = options.fallbackOffset,
					touch = evt.touches ? evt.touches[0] : evt,
					dx = (touch.clientX - tapEvt.clientX) + fallbackOffset.x,
					dy = (touch.clientY - tapEvt.clientY) + fallbackOffset.y,
					translate3d = evt.touches ? 'translate3d(' + dx + 'px,' + dy + 'px,0)' : 'translate(' + dx + 'px,' + dy + 'px)';

				// only set the status to dragging, when we are actually dragging
				if (!Sortable.active) {
					if (fallbackTolerance &&
						min(abs(touch.clientX - this._lastX), abs(touch.clientY - this._lastY)) < fallbackTolerance
					) {
						return;
					}

					this._dragStarted();
				}

				// as well as creating the ghost element on the document body
				this._appendGhost();

				moved = true;
				touchEvt = touch;

				_css(ghostEl, 'webkitTransform', translate3d);
				_css(ghostEl, 'mozTransform', translate3d);
				_css(ghostEl, 'msTransform', translate3d);
				_css(ghostEl, 'transform', translate3d);

				evt.preventDefault();
			}
		},

		_appendGhost: function () {
			if (!ghostEl) {
				var rect = dragEl.getBoundingClientRect(),
					css = _css(dragEl),
					options = this.options,
					ghostRect;

				ghostEl = dragEl.cloneNode(true);

				_toggleClass(ghostEl, options.ghostClass, false);
				_toggleClass(ghostEl, options.fallbackClass, true);
				_toggleClass(ghostEl, options.dragClass, true);

				_css(ghostEl, 'top', rect.top - parseInt(css.marginTop, 10));
				_css(ghostEl, 'left', rect.left - parseInt(css.marginLeft, 10));
				_css(ghostEl, 'width', rect.width);
				_css(ghostEl, 'height', rect.height);
				_css(ghostEl, 'opacity', '0.8');
				_css(ghostEl, 'position', 'fixed');
				_css(ghostEl, 'zIndex', '100000');
				_css(ghostEl, 'pointerEvents', 'none');

				options.fallbackOnBody && document.body.appendChild(ghostEl) || rootEl.appendChild(ghostEl);

				// Fixing dimensions.
				ghostRect = ghostEl.getBoundingClientRect();
				_css(ghostEl, 'width', rect.width * 2 - ghostRect.width);
				_css(ghostEl, 'height', rect.height * 2 - ghostRect.height);
			}
		},

		_onDragStart: function (/**Event*/evt, /**boolean*/useFallback) {
			var dataTransfer = evt.dataTransfer,
				options = this.options;

			this._offUpEvents();

			if (activeGroup.checkPull(this, this, dragEl, evt) == 'clone') {
				cloneEl = _clone(dragEl);
				_css(cloneEl, 'display', 'none');
				rootEl.insertBefore(cloneEl, dragEl);
				_dispatchEvent(this, rootEl, 'clone', dragEl);
			}

			_toggleClass(dragEl, options.dragClass, true);

			if (useFallback) {
				if (useFallback === 'touch') {
					// Bind touch events
					_on(document, 'touchmove', this._onTouchMove);
					_on(document, 'touchend', this._onDrop);
					_on(document, 'touchcancel', this._onDrop);
					_on(document, 'pointermove', this._onTouchMove);
					_on(document, 'pointerup', this._onDrop);
				} else {
					// Old brwoser
					_on(document, 'mousemove', this._onTouchMove);
					_on(document, 'mouseup', this._onDrop);
				}

				this._loopId = setInterval(this._emulateDragOver, 50);
			}
			else {
				if (dataTransfer) {
					dataTransfer.effectAllowed = 'move';
					options.setData && options.setData.call(this, dataTransfer, dragEl);
				}

				_on(document, 'drop', this);
				setTimeout(this._dragStarted, 0);
			}
		},

		_onDragOver: function (/**Event*/evt) {
			var el = this.el,
				target,
				dragRect,
				targetRect,
				revert,
				options = this.options,
				group = options.group,
				activeSortable = Sortable.active,
				isOwner = (activeGroup === group),
				canSort = options.sort;

			if (evt.preventDefault !== void 0) {
				evt.preventDefault();
				!options.dragoverBubble && evt.stopPropagation();
			}

			moved = true;


			// console.log( '_onDragOver' );

			if (activeGroup && !options.disabled &&
				(isOwner
					? canSort || (revert = !rootEl.contains(dragEl)) // Reverting item into the original list
					: (
						putSortable === this ||
						activeGroup.checkPull(this, activeSortable, dragEl, evt) && group.checkPut(this, activeSortable, dragEl, evt)
					)
				) &&
				(evt.rootEl === void 0 || evt.rootEl === this.el) // touch fallback
			) {
				// Smart auto-scrolling
				_autoScroll(evt, options, this.el);

				if (_silent) {
					return;
				}

				target = _closest(evt.target, options.draggable, el);
				dragRect = dragEl.getBoundingClientRect();
				putSortable = this;

				if (revert) {
					_cloneHide(true);
					parentEl = rootEl; // actualization

					if (cloneEl || nextEl) {
						rootEl.insertBefore(dragEl, cloneEl || nextEl);
					}
					else if (!canSort) {
						rootEl.appendChild(dragEl);
					}

					return;
				}


				if ((el.children.length === 0) || (el.children[0] === ghostEl) ||
					(el === evt.target) && (target = _ghostIsLast(el, evt))
				) {
					if (target) {
						if (target.animated) {
							return;
						}

						targetRect = target.getBoundingClientRect();
					}

					_cloneHide(isOwner);

					if (_onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt) !== false) {
						if (!dragEl.contains(el)) {
							el.appendChild(dragEl);
							parentEl = el; // actualization
						}

						this._animate(dragRect, dragEl);
						target && this._animate(targetRect, target);
					}
				}
				else if (target && !target.animated && target !== dragEl && (target.parentNode[expando] !== void 0)) {
					if (lastEl !== target) {
						lastEl = target;
						lastCSS = _css(target);
						lastParentCSS = _css(target.parentNode);
					}

					targetRect = target.getBoundingClientRect();

					var width = targetRect.right - targetRect.left,
						height = targetRect.bottom - targetRect.top,
						floating = /left|right|inline/.test(lastCSS.cssFloat + lastCSS.display)
							|| (lastParentCSS.display == 'flex' && lastParentCSS['flex-direction'].indexOf('row') === 0),
						isWide = (target.offsetWidth > dragEl.offsetWidth),
						isLong = (target.offsetHeight > dragEl.offsetHeight),
						halfway = (floating ? (evt.clientX - targetRect.left) / width : (evt.clientY - targetRect.top) / height) > 0.5,
						nextSibling = target.nextElementSibling,
						moveVector = _onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt),
						after
					;

					if (moveVector !== false) {
						_silent = true;
						setTimeout(_unsilent, 30);

						_cloneHide(isOwner);

						if (moveVector === 1 || moveVector === -1) {
							after = (moveVector === 1);
						}
						else if (floating) {
							var elTop = dragEl.offsetTop,
								tgTop = target.offsetTop;

							if (elTop === tgTop) {
								after = (target.previousElementSibling === dragEl) && !isWide || halfway && isWide;
							}
							else if (target.previousElementSibling === dragEl || dragEl.previousElementSibling === target) {
								after = (evt.clientY - targetRect.top) / height > 0.5;
							} else {
								after = tgTop > elTop;
							}
						} else {
							after = (nextSibling !== dragEl) && !isLong || halfway && isLong;
						}

						if (!dragEl.contains(el)) {
							if (after && !nextSibling) {
								el.appendChild(dragEl);
							} else {
								target.parentNode.insertBefore(dragEl, after ? nextSibling : target);
							}
						}

						parentEl = dragEl.parentNode; // actualization

						this._animate(dragRect, dragEl);
						this._animate(targetRect, target);
					}
				}
			}
		},

		_animate: function (prevRect, target) {
			var ms = this.options.animation;

			if (ms) {
				var currentRect = target.getBoundingClientRect();

				_css(target, 'transition', 'none');
				_css(target, 'transform', 'translate3d('
					+ (prevRect.left - currentRect.left) + 'px,'
					+ (prevRect.top - currentRect.top) + 'px,0)'
				);

				target.offsetWidth; // repaint

				_css(target, 'transition', 'all ' + ms + 'ms');
				_css(target, 'transform', 'translate3d(0,0,0)');

				clearTimeout(target.animated);
				target.animated = setTimeout(function () {
					_css(target, 'transition', '');
					_css(target, 'transform', '');
					target.animated = false;
				}, ms);
			}
		},

		_offUpEvents: function () {
			var ownerDocument = this.el.ownerDocument;

			_off(document, 'touchmove', this._onTouchMove);
			_off(document, 'pointermove', this._onTouchMove);
			_off(ownerDocument, 'mouseup', this._onDrop);
			_off(ownerDocument, 'touchend', this._onDrop);
			_off(ownerDocument, 'pointerup', this._onDrop);
			_off(ownerDocument, 'touchcancel', this._onDrop);
		},

		_onDrop: function (/**Event*/evt) {
			var el = this.el,
				options = this.options;

			clearInterval(this._loopId);
			clearInterval(autoScroll.pid);
			clearTimeout(this._dragStartTimer);

			// Unbind events
			_off(document, 'mousemove', this._onTouchMove);

			if (this.nativeDraggable) {
				_off(document, 'drop', this);
				_off(el, 'dragstart', this._onDragStart);
			}

			this._offUpEvents();

			if (evt) {
				if (moved) {
					evt.preventDefault();
					!options.dropBubble && evt.stopPropagation();
				}

				ghostEl && ghostEl.parentNode.removeChild(ghostEl);

				if (dragEl) {
					if (this.nativeDraggable) {
						_off(dragEl, 'dragend', this);
					}

					_disableDraggable(dragEl);
					dragEl.style['will-change'] = '';

					// Remove class's
					_toggleClass(dragEl, this.options.ghostClass, false);
					_toggleClass(dragEl, this.options.chosenClass, false);

					if (rootEl !== parentEl) {
						newIndex = _index(dragEl, options.draggable);

						if (newIndex >= 0) {

							// Add event
							_dispatchEvent(null, parentEl, 'add', dragEl, rootEl, oldIndex, newIndex);

							// Remove event
							_dispatchEvent(this, rootEl, 'remove', dragEl, rootEl, oldIndex, newIndex);

							// drag from one list and drop into another
							_dispatchEvent(null, parentEl, 'sort', dragEl, rootEl, oldIndex, newIndex);
							_dispatchEvent(this, rootEl, 'sort', dragEl, rootEl, oldIndex, newIndex);
						}
					}
					else {
						// Remove clone
						cloneEl && cloneEl.parentNode.removeChild(cloneEl);

						if (dragEl.nextSibling !== nextEl) {
							// Get the index of the dragged element within its parent
							newIndex = _index(dragEl, options.draggable);

							if (newIndex >= 0) {
								// drag & drop within the same list
								_dispatchEvent(this, rootEl, 'update', dragEl, rootEl, oldIndex, newIndex);
								_dispatchEvent(this, rootEl, 'sort', dragEl, rootEl, oldIndex, newIndex);
							}
						}
					}

					if (Sortable.active) {
						/* jshint eqnull:true */
						if (newIndex == null || newIndex === -1) {
							newIndex = oldIndex;
						}

						_dispatchEvent(this, rootEl, 'end', dragEl, rootEl, oldIndex, newIndex);

						// Save sorting
						this.save();
					}
				}

			}

			this._nulling();
		},

		_nulling: function() {
			rootEl =
			dragEl =
			parentEl =
			ghostEl =
			nextEl =
			cloneEl =

			scrollEl =
			scrollParentEl =

			tapEvt =
			touchEvt =

			moved =
			newIndex =

			lastEl =
			lastCSS =

			putSortable =
			activeGroup =
			Sortable.active = null;
		},

		handleEvent: function (/**Event*/evt) {
			var type = evt.type;

			if (type === 'dragover' || type === 'dragenter') {
				if (dragEl) {
					this._onDragOver(evt);
					_globalDragOver(evt);
				}
			}
			else if (type === 'drop' || type === 'dragend') {
				this._onDrop(evt);
			}
		},


		/**
		 * Serializes the item into an array of string.
		 * @returns {String[]}
		 */
		toArray: function () {
			var order = [],
				el,
				children = this.el.children,
				i = 0,
				n = children.length,
				options = this.options;

			for (; i < n; i++) {
				el = children[i];
				if (_closest(el, options.draggable, this.el)) {
					order.push(el.getAttribute(options.dataIdAttr) || _generateId(el));
				}
			}

			return order;
		},


		/**
		 * Sorts the elements according to the array.
		 * @param  {String[]}  order  order of the items
		 */
		sort: function (order) {
			var items = {}, rootEl = this.el;

			this.toArray().forEach(function (id, i) {
				var el = rootEl.children[i];

				if (_closest(el, this.options.draggable, rootEl)) {
					items[id] = el;
				}
			}, this);

			order.forEach(function (id) {
				if (items[id]) {
					rootEl.removeChild(items[id]);
					rootEl.appendChild(items[id]);
				}
			});
		},


		/**
		 * Save the current sorting
		 */
		save: function () {
			var store = this.options.store;
			store && store.set(this);
		},


		/**
		 * For each element in the set, get the first element that matches the selector by testing the element itself and traversing up through its ancestors in the DOM tree.
		 * @param   {HTMLElement}  el
		 * @param   {String}       [selector]  default: `options.draggable`
		 * @returns {HTMLElement|null}
		 */
		closest: function (el, selector) {
			return _closest(el, selector || this.options.draggable, this.el);
		},


		/**
		 * Set/get option
		 * @param   {string} name
		 * @param   {*}      [value]
		 * @returns {*}
		 */
		option: function (name, value) {
			var options = this.options;

			if (value === void 0) {
				return options[name];
			} else {
				options[name] = value;

				if (name === 'group') {
					_prepareGroup(options);
				}
			}
		},


		/**
		 * Destroy
		 */
		destroy: function () {
			var el = this.el;

			el[expando] = null;

			_off(el, 'mousedown', this._onTapStart);
			_off(el, 'touchstart', this._onTapStart);
			_off(el, 'pointerdown', this._onTapStart);

			if (this.nativeDraggable) {
				_off(el, 'dragover', this);
				_off(el, 'dragenter', this);
			}

			// Remove draggable attributes
			Array.prototype.forEach.call(el.querySelectorAll('[draggable]'), function (el) {
				el.removeAttribute('draggable');
			});

			touchDragOverListeners.splice(touchDragOverListeners.indexOf(this._onDragOver), 1);

			this._onDrop();

			this.el = el = null;
		}
	};


	function _cloneHide(state) {
		if (cloneEl && (cloneEl.state !== state)) {
			_css(cloneEl, 'display', state ? 'none' : '');
			!state && cloneEl.state && rootEl.insertBefore(cloneEl, dragEl);
			cloneEl.state = state;
		}
	}


	function _closest(/**HTMLElement*/el, /**String*/selector, /**HTMLElement*/ctx) {
		if (el) {
			ctx = ctx || document;

			do {
				if ((selector === '>*' && el.parentNode === ctx) || _matches(el, selector)) {
					return el;
				}
				/* jshint boss:true */
			} while (el = _getParentOrHost(el));
		}

		return null;
	}


	function _getParentOrHost(el) {
		var parent = el.host;

		return (parent && parent.nodeType) ? parent : el.parentNode;
	}


	function _globalDragOver(/**Event*/evt) {
		if (evt.dataTransfer) {
			evt.dataTransfer.dropEffect = 'move';
		}
		evt.preventDefault();
	}


	function _on(el, event, fn) {
		el.addEventListener(event, fn, false);
	}


	function _off(el, event, fn) {
		el.removeEventListener(event, fn, false);
	}


	function _toggleClass(el, name, state) {
		if (el) {
			if (el.classList) {
				el.classList[state ? 'add' : 'remove'](name);
			}
			else {
				var className = (' ' + el.className + ' ').replace(RSPACE, ' ').replace(' ' + name + ' ', ' ');
				el.className = (className + (state ? ' ' + name : '')).replace(RSPACE, ' ');
			}
		}
	}


	function _css(el, prop, val) {
		var style = el && el.style;

		if (style) {
			if (val === void 0) {
				if (document.defaultView && document.defaultView.getComputedStyle) {
					val = document.defaultView.getComputedStyle(el, '');
				}
				else if (el.currentStyle) {
					val = el.currentStyle;
				}

				return prop === void 0 ? val : val[prop];
			}
			else {
				if (!(prop in style)) {
					prop = '-webkit-' + prop;
				}

				style[prop] = val + (typeof val === 'string' ? '' : 'px');
			}
		}
	}


	function _find(ctx, tagName, iterator) {
		if (ctx) {
			var list = ctx.getElementsByTagName(tagName), i = 0, n = list.length;

			if (iterator) {
				for (; i < n; i++) {
					iterator(list[i], i);
				}
			}

			return list;
		}

		return [];
	}



	function _dispatchEvent(sortable, rootEl, name, targetEl, fromEl, startIndex, newIndex) {
		sortable = (sortable || rootEl[expando]);

		var evt = document.createEvent('Event'),
			options = sortable.options,
			onName = 'on' + name.charAt(0).toUpperCase() + name.substr(1);

		evt.initEvent(name, true, true);

		evt.to = rootEl;
		evt.from = fromEl || rootEl;
		evt.item = targetEl || rootEl;
		evt.clone = cloneEl;

		evt.oldIndex = startIndex;
		evt.newIndex = newIndex;

		rootEl.dispatchEvent(evt);

		if (options[onName]) {
			options[onName].call(sortable, evt);
		}
	}


	function _onMove(fromEl, toEl, dragEl, dragRect, targetEl, targetRect, originalEvt) {
		var evt,
			sortable = fromEl[expando],
			onMoveFn = sortable.options.onMove,
			retVal;

		evt = document.createEvent('Event');
		evt.initEvent('move', true, true);

		evt.to = toEl;
		evt.from = fromEl;
		evt.dragged = dragEl;
		evt.draggedRect = dragRect;
		evt.related = targetEl || toEl;
		evt.relatedRect = targetRect || toEl.getBoundingClientRect();

		fromEl.dispatchEvent(evt);

		if (onMoveFn) {
			retVal = onMoveFn.call(sortable, evt, originalEvt);
		}

		return retVal;
	}


	function _disableDraggable(el) {
		el.draggable = false;
	}


	function _unsilent() {
		_silent = false;
	}


	/** @returns {HTMLElement|false} */
	function _ghostIsLast(el, evt) {
		var lastEl = el.lastElementChild,
			rect = lastEl.getBoundingClientRect();

		// 5 — min delta
		// abs — нельзя добавлять, а то глюки при наведении сверху
		return (
			(evt.clientY - (rect.top + rect.height) > 5) ||
			(evt.clientX - (rect.right + rect.width) > 5)
		) && lastEl;
	}


	/**
	 * Generate id
	 * @param   {HTMLElement} el
	 * @returns {String}
	 * @private
	 */
	function _generateId(el) {
		var str = el.tagName + el.className + el.src + el.href + el.textContent,
			i = str.length,
			sum = 0;

		while (i--) {
			sum += str.charCodeAt(i);
		}

		return sum.toString(36);
	}

	/**
	 * Returns the index of an element within its parent for a selected set of
	 * elements
	 * @param  {HTMLElement} el
	 * @param  {selector} selector
	 * @return {number}
	 */
	function _index(el, selector) {
		var index = 0;

		if (!el || !el.parentNode) {
			return -1;
		}

		while (el && (el = el.previousElementSibling)) {
			if ((el.nodeName.toUpperCase() !== 'TEMPLATE') && (selector === '>*' || _matches(el, selector))) {
				index++;
			}
		}

		return index;
	}

	function _matches(/**HTMLElement*/el, /**String*/selector) {
		if (el) {
			selector = selector.split('.');

			var tag = selector.shift().toUpperCase(),
				re = new RegExp('\\s(' + selector.join('|') + ')(?=\\s)', 'g');

			return (
				(tag === '' || el.nodeName.toUpperCase() == tag) &&
				(!selector.length || ((' ' + el.className + ' ').match(re) || []).length == selector.length)
			);
		}

		return false;
	}

	function _throttle(callback, ms) {
		var args, _this;

		return function () {
			if (args === void 0) {
				args = arguments;
				_this = this;

				setTimeout(function () {
					if (args.length === 1) {
						callback.call(_this, args[0]);
					} else {
						callback.apply(_this, args);
					}

					args = void 0;
				}, ms);
			}
		};
	}

	function _extend(dst, src) {
		if (dst && src) {
			for (var key in src) {
				if (src.hasOwnProperty(key)) {
					dst[key] = src[key];
				}
			}
		}

		return dst;
	}

	function _clone(el) {
		return $
			? $(el).clone(true)[0]
			: (Polymer && Polymer.dom
				? Polymer.dom(el).cloneNode(true)
				: el.cloneNode(true)
			);
	}


	// Export utils
	Sortable.utils = {
		on: _on,
		off: _off,
		css: _css,
		find: _find,
		is: function (el, selector) {
			return !!_closest(el, selector, el);
		},
		extend: _extend,
		throttle: _throttle,
		closest: _closest,
		toggleClass: _toggleClass,
		clone: _clone,
		index: _index
	};


	/**
	 * Create sortable instance
	 * @param {HTMLElement}  el
	 * @param {Object}      [options]
	 */
	Sortable.create = function (el, options) {
		return new Sortable(el, options);
	};


	// Export
	Sortable.version = '1.5.0-rc1';
	return Sortable;
});

/*! Sortable 1.4.2 - MIT | git://github.com/rubaxa/Sortable.git */
// !function(a){"use strict";"function"==typeof define&&define.amd?define(a):"undefined"!=typeof module&&"undefined"!=typeof module.exports?module.exports=a():"undefined"!=typeof Package?Sortable=a():window.Sortable=a()}(function(){"use strict";function F(a,b){if(!a||!a.nodeType||1!==a.nodeType)throw"Sortable: `el` must be HTMLElement, and not "+{}.toString.call(a);this.el=a,this.options=b=X({},b),a[t]=this;var c={group:Math.random(),sort:!0,disabled:!1,store:null,handle:null,scroll:!0,scrollSensitivity:30,scrollSpeed:10,draggable:/[uo]l/i.test(a.nodeName)?"li":">*",ghostClass:"sortable-ghost",chosenClass:"sortable-chosen",ignore:"a, img",filter:null,animation:0,setData:function(a,b){a.setData("Text",b.textContent)},dropBubble:!1,dragoverBubble:!1,dataIdAttr:"data-id",delay:0,forceFallback:!1,fallbackClass:"sortable-fallback",fallbackOnBody:!1};for(var d in c)!(d in b)&&(b[d]=c[d]);E(b);for(var e in this)"_"===e.charAt(0)&&(this[e]=this[e].bind(this));this.nativeDraggable=!b.forceFallback&&x,J(a,"mousedown",this._onTapStart),J(a,"touchstart",this._onTapStart),this.nativeDraggable&&(J(a,"dragover",this),J(a,"dragenter",this)),C.push(this._onDragOver),b.store&&this.sort(b.store.get(this))}function G(b){d&&d.state!==b&&(M(d,"display",b?"none":""),!b&&d.state&&e.insertBefore(d,a),d.state=b)}function H(a,b,c){if(a){c=c||v;do if(">*"===b&&a.parentNode===c||V(a,b))return a;while(a!==c&&(a=a.parentNode))}return null}function I(a){a.dataTransfer&&(a.dataTransfer.dropEffect="move"),a.preventDefault()}function J(a,b,c){a.addEventListener(b,c,!1)}function K(a,b,c){a.removeEventListener(b,c,!1)}function L(a,b,c){if(a)if(a.classList)a.classList[c?"add":"remove"](b);else{var d=(" "+a.className+" ").replace(s," ").replace(" "+b+" "," ");a.className=(d+(c?" "+b:"")).replace(s," ")}}function M(a,b,c){var d=a&&a.style;if(d){if(void 0===c)return v.defaultView&&v.defaultView.getComputedStyle?c=v.defaultView.getComputedStyle(a,""):a.currentStyle&&(c=a.currentStyle),void 0===b?c:c[b];b in d||(b="-webkit-"+b),d[b]=c+("string"==typeof c?"":"px")}}function N(a,b,c){if(a){var d=a.getElementsByTagName(b),e=0,f=d.length;if(c)for(;e<f;e++)c(d[e],e);return d}return[]}function O(a,b,c,e,f,g,h){var i=v.createEvent("Event"),j=(a||b[t]).options,k="on"+c.charAt(0).toUpperCase()+c.substr(1);i.initEvent(c,!0,!0),i.to=b,i.from=f||b,i.item=e||b,i.clone=d,i.oldIndex=g,i.newIndex=h,b.dispatchEvent(i),j[k]&&j[k].call(a,i)}function P(a,b,c,d,e,f){var g,j,h=a[t],i=h.options.onMove;return g=v.createEvent("Event"),g.initEvent("move",!0,!0),g.to=b,g.from=a,g.dragged=c,g.draggedRect=d,g.related=e||b,g.relatedRect=f||b.getBoundingClientRect(),a.dispatchEvent(g),i&&(j=i.call(h,g)),j}function Q(a){a.draggable=!1}function R(){z=!1}function S(a,b){var c=a.lastElementChild,d=c.getBoundingClientRect();return(b.clientY-(d.top+d.height)>5||b.clientX-(d.right+d.width)>5)&&c}function T(a){for(var b=a.tagName+a.className+a.src+a.href+a.textContent,c=b.length,d=0;c--;)d+=b.charCodeAt(c);return d.toString(36)}function U(a,b){var c=0;if(!a||!a.parentNode)return-1;for(;a&&(a=a.previousElementSibling);)"TEMPLATE"!==a.nodeName.toUpperCase()&&V(a,b)&&c++;return c}function V(a,b){if(a){b=b.split(".");var c=b.shift().toUpperCase(),d=new RegExp("\\s("+b.join("|")+")(?=\\s)","g");return!(""!==c&&a.nodeName.toUpperCase()!=c||b.length&&((" "+a.className+" ").match(d)||[]).length!=b.length)}return!1}function W(a,b){var c,d;return function(){void 0===c&&(c=arguments,d=this,setTimeout(function(){1===c.length?a.call(d,c[0]):a.apply(d,c),c=void 0},b))}}function X(a,b){if(a&&b)for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c]);return a}if("undefined"==typeof window||"undefined"==typeof window.document)return function(){throw new Error("Sortable.js requires a window with a document")};var a,b,c,d,e,f,g,h,i,j,k,l,m,n,p,q,r,o={},s=/\s+/g,t="Sortable"+(new Date).getTime(),u=window,v=u.document,w=u.parseInt,x=!!("draggable"in v.createElement("div")),y=function(a){return a=v.createElement("x"),a.style.cssText="pointer-events:auto","auto"===a.style.pointerEvents}(),z=!1,A=Math.abs,C=([].slice,[]),D=W(function(a,b,c){if(c&&b.scroll){var d,e,n,p,f=b.scrollSensitivity,i=b.scrollSpeed,j=a.clientX,k=a.clientY,l=window.innerWidth,m=window.innerHeight;if(h!==c&&(g=b.scroll,h=c,g===!0)){g=c;do if(g.offsetWidth<g.scrollWidth||g.offsetHeight<g.scrollHeight)break;while(g=g.parentNode)}g&&(d=g,e=void 0==g.parentNode?g.document.body.getBoundingClientRect():g.getBoundingClientRect(),n=(A(e.right-j)<=f)-(A(e.left-j)<=f),p=(A(e.bottom-k)<=f)-(A(e.top-k)<=f)),n||p||(n=(l-j<=f)-(j<=f),p=(m-k<=f)-(k<=f),(n||p)&&(d=u)),o.vx===n&&o.vy===p&&o.el===d||(o.el=d,o.vx=n,o.vy=p,clearInterval(o.pid),d&&(o.pid=setInterval(function(){d===u?u.scrollTo(u.pageXOffset+n*i,u.pageYOffset+p*i):(p&&(d.scrollTop+=p*i),n&&(d.scrollLeft+=n*i))},24)))}},30),E=function(a){var b=a.group;b&&"object"==typeof b||(b=a.group={name:b}),["pull","put"].forEach(function(a){a in b||(b[a]=!0)}),a.groups=" "+b.name+(b.put.join?" "+b.put.join(" "):"")+" "};return F.prototype={constructor:F,_onTapStart:function(a){var b=this,c=this.el,d=this.options,e=a.type,f=a.touches&&a.touches[0],g=(f||a).target,h=g,i=d.filter;if(!("mousedown"===e&&0!==a.button||d.disabled)&&(g=H(g,d.draggable,c))){if(l=U(g,d.draggable),"function"==typeof i){if(i.call(this,a,g,this))return O(b,h,"filter",g,c,l),void a.preventDefault()}else if(i&&(i=i.split(",").some(function(a){if(a=H(h,a.trim(),c))return O(b,a,"filter",g,c,l),!0})))return void a.preventDefault();d.handle&&!H(h,d.handle,c)||this._prepareDragStart(a,f,g)}},_prepareDragStart:function(c,d,g){var l,h=this,i=h.el,j=h.options,k=i.ownerDocument;g&&!a&&g.parentNode===i&&(p=c,e=i,a=g,b=a.parentNode,f=a.nextSibling,n=j.group,a.style["will-change"]="transform",l=function(){h._disableDelayedDrag(),a.draggable=!0,L(a,h.options.chosenClass,!0),h._triggerDragStart(d)},j.ignore.split(",").forEach(function(b){N(a,b.trim(),Q)}),J(k,"mouseup",h._onDrop),J(k,"touchend",h._onDrop),J(k,"touchcancel",h._onDrop),j.delay?(J(k,"mouseup",h._disableDelayedDrag),J(k,"touchend",h._disableDelayedDrag),J(k,"touchcancel",h._disableDelayedDrag),J(k,"mousemove",h._disableDelayedDrag),J(k,"touchmove",h._disableDelayedDrag),h._dragStartTimer=setTimeout(l,j.delay)):l())},_disableDelayedDrag:function(){var a=this.el.ownerDocument;clearTimeout(this._dragStartTimer),K(a,"mouseup",this._disableDelayedDrag),K(a,"touchend",this._disableDelayedDrag),K(a,"touchcancel",this._disableDelayedDrag),K(a,"mousemove",this._disableDelayedDrag),K(a,"touchmove",this._disableDelayedDrag)},_triggerDragStart:function(b){b?(p={target:a,clientX:b.clientX,clientY:b.clientY},this._onDragStart(p,"touch")):this.nativeDraggable?(J(a,"dragend",this),J(e,"dragstart",this._onDragStart)):this._onDragStart(p,!0);try{v.selection?setTimeout(function(){v.selection.empty()}):window.getSelection().removeAllRanges()}catch(a){}},_dragStarted:function(){e&&a&&(L(a,this.options.ghostClass,!0),F.active=this,O(this,e,"start",a,e,l))},_emulateDragOver:function(){if(q){if(this._lastX===q.clientX&&this._lastY===q.clientY)return;this._lastX=q.clientX,this._lastY=q.clientY,y||M(c,"display","none");var a=v.elementFromPoint(q.clientX,q.clientY),b=a,d=" "+this.options.group.name,e=C.length;if(b)do{if(b[t]&&b[t].options.groups.indexOf(d)>-1){for(;e--;)C[e]({clientX:q.clientX,clientY:q.clientY,target:a,rootEl:b});break}a=b}while(b=b.parentNode);y||M(c,"display","")}},_onTouchMove:function(a){if(p){F.active||this._dragStarted(),this._appendGhost();var b=a.touches?a.touches[0]:a,d=b.clientX-p.clientX,e=b.clientY-p.clientY,f=a.touches?"translate3d("+d+"px,"+e+"px,0)":"translate("+d+"px,"+e+"px)";r=!0,q=b,M(c,"webkitTransform",f),M(c,"mozTransform",f),M(c,"msTransform",f),M(c,"transform",f),a.preventDefault()}},_appendGhost:function(){if(!c){var g,b=a.getBoundingClientRect(),d=M(a),f=this.options;c=a.cloneNode(!0),L(c,f.ghostClass,!1),L(c,f.fallbackClass,!0),M(c,"top",b.top-w(d.marginTop,10)),M(c,"left",b.left-w(d.marginLeft,10)),M(c,"width",b.width),M(c,"height",b.height),M(c,"opacity","0.8"),M(c,"position","fixed"),M(c,"zIndex","100000"),M(c,"pointerEvents","none"),f.fallbackOnBody&&v.body.appendChild(c)||e.appendChild(c),g=c.getBoundingClientRect(),M(c,"width",2*b.width-g.width),M(c,"height",2*b.height-g.height)}},_onDragStart:function(b,c){var f=b.dataTransfer,g=this.options;this._offUpEvents(),"clone"==n.pull&&(d=a.cloneNode(!0),M(d,"display","none"),e.insertBefore(d,a)),c?("touch"===c?(J(v,"touchmove",this._onTouchMove),J(v,"touchend",this._onDrop),J(v,"touchcancel",this._onDrop)):(J(v,"mousemove",this._onTouchMove),J(v,"mouseup",this._onDrop)),this._loopId=setInterval(this._emulateDragOver,50)):(f&&(f.effectAllowed="move",g.setData&&g.setData.call(this,f,a)),J(v,"drop",this),setTimeout(this._dragStarted,0))},_onDragOver:function(g){var l,m,o,h=this.el,p=this.options,q=p.group,s=q.put,u=n===q,v=p.sort;if(void 0!==g.preventDefault&&(g.preventDefault(),!p.dragoverBubble&&g.stopPropagation()),r=!0,n&&!p.disabled&&(u?v||(o=!e.contains(a)):n.pull&&s&&(n.name===q.name||s.indexOf&&~s.indexOf(n.name)))&&(void 0===g.rootEl||g.rootEl===this.el)){if(D(g,p,this.el),z)return;if(l=H(g.target,p.draggable,h),m=a.getBoundingClientRect(),o)return G(!0),void(d||f?e.insertBefore(a,d||f):v||e.appendChild(a));if(0===h.children.length||h.children[0]===c||h===g.target&&(l=S(h,g))){if(l){if(l.animated)return;w=l.getBoundingClientRect()}G(u),P(e,h,a,m,l,w)!==!1&&(a.contains(h)||(h.appendChild(a),b=h),this._animate(m,a),l&&this._animate(w,l))}else if(l&&!l.animated&&l!==a&&void 0!==l.parentNode[t]){i!==l&&(i=l,j=M(l),k=M(l.parentNode));var J,w=l.getBoundingClientRect(),x=w.right-w.left,y=w.bottom-w.top,A=/left|right|inline/.test(j.cssFloat+j.display)||"flex"==k.display&&0===k["flex-direction"].indexOf("row"),B=l.offsetWidth>a.offsetWidth,C=l.offsetHeight>a.offsetHeight,E=(A?(g.clientX-w.left)/x:(g.clientY-w.top)/y)>.5,F=l.nextElementSibling,I=P(e,h,a,m,l,w);if(I!==!1){if(z=!0,setTimeout(R,30),G(u),1===I||I===-1)J=1===I;else if(A){var K=a.offsetTop,L=l.offsetTop;J=K===L?l.previousElementSibling===a&&!B||E&&B:l.previousElementSibling===a||a.previousElementSibling===l?(g.clientY-w.top)/y>.5:L>K}else J=F!==a&&!C||E&&C;a.contains(h)||(J&&!F?h.appendChild(a):l.parentNode.insertBefore(a,J?F:l)),b=a.parentNode,this._animate(m,a),this._animate(w,l)}}}},_animate:function(a,b){var c=this.options.animation;if(c){var d=b.getBoundingClientRect();M(b,"transition","none"),M(b,"transform","translate3d("+(a.left-d.left)+"px,"+(a.top-d.top)+"px,0)"),b.offsetWidth,M(b,"transition","all "+c+"ms"),M(b,"transform","translate3d(0,0,0)"),clearTimeout(b.animated),b.animated=setTimeout(function(){M(b,"transition",""),M(b,"transform",""),b.animated=!1},c)}},_offUpEvents:function(){var a=this.el.ownerDocument;K(v,"touchmove",this._onTouchMove),K(a,"mouseup",this._onDrop),K(a,"touchend",this._onDrop),K(a,"touchcancel",this._onDrop)},_onDrop:function(g){var h=this.el,i=this.options;clearInterval(this._loopId),clearInterval(o.pid),clearTimeout(this._dragStartTimer),K(v,"mousemove",this._onTouchMove),this.nativeDraggable&&(K(v,"drop",this),K(h,"dragstart",this._onDragStart)),this._offUpEvents(),g&&(r&&(g.preventDefault(),!i.dropBubble&&g.stopPropagation()),c&&c.parentNode.removeChild(c),a&&(this.nativeDraggable&&K(a,"dragend",this),Q(a),a.style["will-change"]="",L(a,this.options.ghostClass,!1),L(a,this.options.chosenClass,!1),e!==b?(m=U(a,i.draggable),m>=0&&(O(null,b,"sort",a,e,l,m),O(this,e,"sort",a,e,l,m),O(null,b,"add",a,e,l,m),O(this,e,"remove",a,e,l,m))):(d&&d.parentNode.removeChild(d),a.nextSibling!==f&&(m=U(a,i.draggable),m>=0&&(O(this,e,"update",a,e,l,m),O(this,e,"sort",a,e,l,m)))),F.active&&(null!=m&&m!==-1||(m=l),O(this,e,"end",a,e,l,m),this.save()))),this._nulling()},_nulling:function(){(F.active===this||!F.active)&&(e=a=b=c=f=d=g=h=p=q=r=m=i=j=n=F.active=null)},handleEvent:function(b){var c=b.type;"dragover"===c||"dragenter"===c?a&&(this._onDragOver(b),I(b)):"drop"!==c&&"dragend"!==c||this._onDrop(b)},toArray:function(){for(var b,a=[],c=this.el.children,d=0,e=c.length,f=this.options;d<e;d++)b=c[d],H(b,f.draggable,this.el)&&a.push(b.getAttribute(f.dataIdAttr)||T(b));return a},sort:function(a){var b={},c=this.el;this.toArray().forEach(function(a,d){var e=c.children[d];H(e,this.options.draggable,c)&&(b[a]=e)},this),a.forEach(function(a){b[a]&&(c.removeChild(b[a]),c.appendChild(b[a]))})},save:function(){var a=this.options.store;a&&a.set(this)},closest:function(a,b){return H(a,b||this.options.draggable,this.el)},option:function(a,b){var c=this.options;return void 0===b?c[a]:(c[a]=b,void("group"===a&&E(c)))},destroy:function(){var a=this.el;a[t]=null,K(a,"mousedown",this._onTapStart),K(a,"touchstart",this._onTapStart),this.nativeDraggable&&(K(a,"dragover",this),K(a,"dragenter",this)),Array.prototype.forEach.call(a.querySelectorAll("[draggable]"),function(a){a.removeAttribute("draggable")}),C.splice(C.indexOf(this._onDragOver),1),this._onDrop(),this.el=a=null}},F.utils={on:J,off:K,css:M,find:N,is:function(a,b){return!!H(a,b,a)},extend:X,throttle:W,closest:H,toggleClass:L,index:U},F.create=function(a,b){return new F(a,b)},F.version="1.4.2",F});

/*! Sortable 1.5.0-rc1 - MIT | git://github.com/rubaxa/Sortable.git */
// !function(a){"use strict";"function"==typeof define&&define.amd?define(a):"undefined"!=typeof module&&"undefined"!=typeof module.exports?module.exports=a():"undefined"!=typeof Package?Sortable=a():window.Sortable=a()}(function(){"use strict";function a(a,b){if(!a||!a.nodeType||1!==a.nodeType)throw"Sortable: `el` must be HTMLElement, and not "+{}.toString.call(a);this.el=a,this.options=b=t({},b),a[Q]=this;var c={group:Math.random(),sort:!0,disabled:!1,store:null,handle:null,scroll:!0,scrollSensitivity:30,scrollSpeed:10,draggable:/[uo]l/i.test(a.nodeName)?"li":">*",ghostClass:"sortable-ghost",chosenClass:"sortable-chosen",dragClass:"sortable-drag",ignore:"a, img",filter:null,animation:0,setData:function(a,b){a.setData("Text",b.textContent)},dropBubble:!1,dragoverBubble:!1,dataIdAttr:"data-id",delay:0,forceFallback:!1,fallbackClass:"sortable-fallback",fallbackOnBody:!1,fallbackTolerance:0,fallbackOffset:{x:0,y:0}};for(var d in c)!(d in b)&&(b[d]=c[d]);ba(b);for(var e in this)"_"===e.charAt(0)&&"function"==typeof this[e]&&(this[e]=this[e].bind(this));this.nativeDraggable=!b.forceFallback&&W,f(a,"mousedown",this._onTapStart),f(a,"touchstart",this._onTapStart),f(a,"pointerdown",this._onTapStart),this.nativeDraggable&&(f(a,"dragover",this),f(a,"dragenter",this)),_.push(this._onDragOver),b.store&&this.sort(b.store.get(this))}function b(a){y&&y.state!==a&&(i(y,"display",a?"none":""),!a&&y.state&&z.insertBefore(y,v),y.state=a)}function c(a,b,c){if(a){c=c||S;do if(">*"===b&&a.parentNode===c||r(a,b))return a;while(a=d(a))}return null}function d(a){var b=a.host;return b&&b.nodeType?b:a.parentNode}function e(a){a.dataTransfer&&(a.dataTransfer.dropEffect="move"),a.preventDefault()}function f(a,b,c){a.addEventListener(b,c,!1)}function g(a,b,c){a.removeEventListener(b,c,!1)}function h(a,b,c){if(a)if(a.classList)a.classList[c?"add":"remove"](b);else{var d=(" "+a.className+" ").replace(P," ").replace(" "+b+" "," ");a.className=(d+(c?" "+b:"")).replace(P," ")}}function i(a,b,c){var d=a&&a.style;if(d){if(void 0===c)return S.defaultView&&S.defaultView.getComputedStyle?c=S.defaultView.getComputedStyle(a,""):a.currentStyle&&(c=a.currentStyle),void 0===b?c:c[b];b in d||(b="-webkit-"+b),d[b]=c+("string"==typeof c?"":"px")}}function j(a,b,c){if(a){var d=a.getElementsByTagName(b),e=0,f=d.length;if(c)for(;e<f;e++)c(d[e],e);return d}return[]}function k(a,b,c,d,e,f,g){a=a||b[Q];var h=S.createEvent("Event"),i=a.options,j="on"+c.charAt(0).toUpperCase()+c.substr(1);h.initEvent(c,!0,!0),h.to=b,h.from=e||b,h.item=d||b,h.clone=y,h.oldIndex=f,h.newIndex=g,b.dispatchEvent(h),i[j]&&i[j].call(a,h)}function l(a,b,c,d,e,f,g){var h,i,j=a[Q],k=j.options.onMove;return h=S.createEvent("Event"),h.initEvent("move",!0,!0),h.to=b,h.from=a,h.dragged=c,h.draggedRect=d,h.related=e||b,h.relatedRect=f||b.getBoundingClientRect(),a.dispatchEvent(h),k&&(i=k.call(j,h,g)),i}function m(a){a.draggable=!1}function n(){Y=!1}function o(a,b){var c=a.lastElementChild,d=c.getBoundingClientRect();return(b.clientY-(d.top+d.height)>5||b.clientX-(d.right+d.width)>5)&&c}function p(a){for(var b=a.tagName+a.className+a.src+a.href+a.textContent,c=b.length,d=0;c--;)d+=b.charCodeAt(c);return d.toString(36)}function q(a,b){var c=0;if(!a||!a.parentNode)return-1;for(;a&&(a=a.previousElementSibling);)"TEMPLATE"===a.nodeName.toUpperCase()||">*"!==b&&!r(a,b)||c++;return c}function r(a,b){if(a){b=b.split(".");var c=b.shift().toUpperCase(),d=new RegExp("\\s("+b.join("|")+")(?=\\s)","g");return!(""!==c&&a.nodeName.toUpperCase()!=c||b.length&&((" "+a.className+" ").match(d)||[]).length!=b.length)}return!1}function s(a,b){var c,d;return function(){void 0===c&&(c=arguments,d=this,setTimeout(function(){1===c.length?a.call(d,c[0]):a.apply(d,c),c=void 0},b))}}function t(a,b){if(a&&b)for(var c in b)b.hasOwnProperty(c)&&(a[c]=b[c]);return a}function u(a){return U?U(a).clone(!0)[0]:V&&V.dom?V.dom(a).cloneNode(!0):a.cloneNode(!0)}if("undefined"==typeof window||!window.document)return function(){throw new Error("Sortable.js requires a window with a document")};var v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O={},P=/\s+/g,Q="Sortable"+(new Date).getTime(),R=window,S=R.document,T=R.parseInt,U=R.jQuery||R.Zepto,V=R.Polymer,W=!!("draggable"in S.createElement("div")),X=function(a){return!navigator.userAgent.match(/Trident.*rv[ :]?11\./)&&(a=S.createElement("x"),a.style.cssText="pointer-events:auto","auto"===a.style.pointerEvents)}(),Y=!1,Z=Math.abs,$=Math.min,_=([].slice,[]),aa=s(function(a,b,c){if(c&&b.scroll){var d,e,f,g,h,i,j=b.scrollSensitivity,k=b.scrollSpeed,l=a.clientX,m=a.clientY,n=window.innerWidth,o=window.innerHeight;if(C!==c&&(B=b.scroll,C=c,D=b.scrollFn,B===!0)){B=c;do if(B.offsetWidth<B.scrollWidth||B.offsetHeight<B.scrollHeight)break;while(B=B.parentNode)}B&&(d=B,e=B.getBoundingClientRect(),f=(Z(e.right-l)<=j)-(Z(e.left-l)<=j),g=(Z(e.bottom-m)<=j)-(Z(e.top-m)<=j)),f||g||(f=(n-l<=j)-(l<=j),g=(o-m<=j)-(m<=j),(f||g)&&(d=R)),O.vx===f&&O.vy===g&&O.el===d||(O.el=d,O.vx=f,O.vy=g,clearInterval(O.pid),d&&(O.pid=setInterval(function(){return i=g?g*k:0,h=f?f*k:0,"function"==typeof D?D.call(_this,h,i,a):void(d===R?R.scrollTo(R.pageXOffset+h,R.pageYOffset+i):(d.scrollTop+=i,d.scrollLeft+=h))},24)))}},30),ba=function(a){function b(a,b){return void 0!==a&&a!==!0||(a=c.name),"function"==typeof a?a:function(c,d){var e=d.options.group.name;return b?a:a&&(a.join?a.indexOf(e)>-1:e==a)}}var c={},d=a.group;d&&"object"==typeof d||(d={name:d}),c.name=d.name,c.checkPull=b(d.pull,!0),c.checkPut=b(d.put),a.group=c};return a.prototype={constructor:a,_onTapStart:function(a){var b,d=this,e=this.el,f=this.options,g=a.type,h=a.touches&&a.touches[0],i=(h||a).target,j=a.target.shadowRoot&&a.path[0]||i,l=f.filter;if(!v&&!("mousedown"===g&&0!==a.button||f.disabled)&&(!f.handle||c(j,f.handle,e))&&(i=c(i,f.draggable,e))){if(b=q(i,f.draggable),"function"==typeof l){if(l.call(this,a,i,this))return k(d,j,"filter",i,e,b),void a.preventDefault()}else if(l&&(l=l.split(",").some(function(a){if(a=c(j,a.trim(),e))return k(d,a,"filter",i,e,b),!0})))return void a.preventDefault();this._prepareDragStart(a,h,i,b)}},_prepareDragStart:function(a,b,c,d){var e,g=this,i=g.el,l=g.options,n=i.ownerDocument;c&&!v&&c.parentNode===i&&(L=a,z=i,v=c,w=v.parentNode,A=v.nextSibling,J=l.group,H=d,this._lastX=(b||a).clientX,this._lastY=(b||a).clientY,v.style["will-change"]="transform",e=function(){g._disableDelayedDrag(),v.draggable=g.nativeDraggable,h(v,l.chosenClass,!0),g._triggerDragStart(a,b),k(g,z,"choose",v,z,H)},l.ignore.split(",").forEach(function(a){j(v,a.trim(),m)}),f(n,"mouseup",g._onDrop),f(n,"touchend",g._onDrop),f(n,"touchcancel",g._onDrop),f(n,"pointercancel",g._onDrop),l.delay?(f(n,"mouseup",g._disableDelayedDrag),f(n,"touchend",g._disableDelayedDrag),f(n,"touchcancel",g._disableDelayedDrag),f(n,"mousemove",g._disableDelayedDrag),f(n,"touchmove",g._disableDelayedDrag),f(n,"pointermove",g._disableDelayedDrag),g._dragStartTimer=setTimeout(e,l.delay)):e())},_disableDelayedDrag:function(){var a=this.el.ownerDocument;clearTimeout(this._dragStartTimer),g(a,"mouseup",this._disableDelayedDrag),g(a,"touchend",this._disableDelayedDrag),g(a,"touchcancel",this._disableDelayedDrag),g(a,"mousemove",this._disableDelayedDrag),g(a,"touchmove",this._disableDelayedDrag),g(a,"pointermove",this._disableDelayedDrag)},_triggerDragStart:function(a,b){b=b||("touch"==a.pointerType?a:null),b?(L={target:v,clientX:b.clientX,clientY:b.clientY},this._onDragStart(L,"touch")):this.nativeDraggable?(f(v,"dragend",this),f(z,"dragstart",this._onDragStart)):this._onDragStart(L,!0);try{S.selection?setTimeout(function(){S.selection.empty()}):window.getSelection().removeAllRanges()}catch(a){}},_dragStarted:function(){if(z&&v){var b=this.options;h(v,b.ghostClass,!0),h(v,b.dragClass,!1),a.active=this,k(this,z,"start",v,z,H)}},_emulateDragOver:function(){if(M){if(this._lastX===M.clientX&&this._lastY===M.clientY)return;this._lastX=M.clientX,this._lastY=M.clientY,X||i(x,"display","none");var a=S.elementFromPoint(M.clientX,M.clientY),b=a,c=_.length;if(b)do{if(b[Q]){for(;c--;)_[c]({clientX:M.clientX,clientY:M.clientY,target:a,rootEl:b});break}a=b}while(b=b.parentNode);X||i(x,"display","")}},_onTouchMove:function(b){if(L){var c=this.options,d=c.fallbackTolerance,e=c.fallbackOffset,f=b.touches?b.touches[0]:b,g=f.clientX-L.clientX+e.x,h=f.clientY-L.clientY+e.y,j=b.touches?"translate3d("+g+"px,"+h+"px,0)":"translate("+g+"px,"+h+"px)";if(!a.active){if(d&&$(Z(f.clientX-this._lastX),Z(f.clientY-this._lastY))<d)return;this._dragStarted()}this._appendGhost(),N=!0,M=f,i(x,"webkitTransform",j),i(x,"mozTransform",j),i(x,"msTransform",j),i(x,"transform",j),b.preventDefault()}},_appendGhost:function(){if(!x){var a,b=v.getBoundingClientRect(),c=i(v),d=this.options;x=v.cloneNode(!0),h(x,d.ghostClass,!1),h(x,d.fallbackClass,!0),h(x,d.dragClass,!0),i(x,"top",b.top-T(c.marginTop,10)),i(x,"left",b.left-T(c.marginLeft,10)),i(x,"width",b.width),i(x,"height",b.height),i(x,"opacity","0.8"),i(x,"position","fixed"),i(x,"zIndex","100000"),i(x,"pointerEvents","none"),d.fallbackOnBody&&S.body.appendChild(x)||z.appendChild(x),a=x.getBoundingClientRect(),i(x,"width",2*b.width-a.width),i(x,"height",2*b.height-a.height)}},_onDragStart:function(a,b){var c=a.dataTransfer,d=this.options;this._offUpEvents(),"clone"==J.checkPull(this,this,v,a)&&(y=u(v),i(y,"display","none"),z.insertBefore(y,v),k(this,z,"clone",v)),h(v,d.dragClass,!0),b?("touch"===b?(f(S,"touchmove",this._onTouchMove),f(S,"touchend",this._onDrop),f(S,"touchcancel",this._onDrop),f(S,"pointermove",this._onTouchMove),f(S,"pointerup",this._onDrop)):(f(S,"mousemove",this._onTouchMove),f(S,"mouseup",this._onDrop)),this._loopId=setInterval(this._emulateDragOver,50)):(c&&(c.effectAllowed="move",d.setData&&d.setData.call(this,c,v)),f(S,"drop",this),setTimeout(this._dragStarted,0))},_onDragOver:function(d){var e,f,g,h,j=this.el,k=this.options,m=k.group,p=a.active,q=J===m,r=k.sort;if(void 0!==d.preventDefault&&(d.preventDefault(),!k.dragoverBubble&&d.stopPropagation()),N=!0,J&&!k.disabled&&(q?r||(h=!z.contains(v)):K===this||J.checkPull(this,p,v,d)&&m.checkPut(this,p,v,d))&&(void 0===d.rootEl||d.rootEl===this.el)){if(aa(d,k,this.el),Y)return;if(e=c(d.target,k.draggable,j),f=v.getBoundingClientRect(),K=this,h)return b(!0),w=z,void(y||A?z.insertBefore(v,y||A):r||z.appendChild(v));if(0===j.children.length||j.children[0]===x||j===d.target&&(e=o(j,d))){if(e){if(e.animated)return;g=e.getBoundingClientRect()}b(q),l(z,j,v,f,e,g,d)!==!1&&(v.contains(j)||(j.appendChild(v),w=j),this._animate(f,v),e&&this._animate(g,e))}else if(e&&!e.animated&&e!==v&&void 0!==e.parentNode[Q]){E!==e&&(E=e,F=i(e),G=i(e.parentNode)),g=e.getBoundingClientRect();var s,t=g.right-g.left,u=g.bottom-g.top,B=/left|right|inline/.test(F.cssFloat+F.display)||"flex"==G.display&&0===G["flex-direction"].indexOf("row"),C=e.offsetWidth>v.offsetWidth,D=e.offsetHeight>v.offsetHeight,H=(B?(d.clientX-g.left)/t:(d.clientY-g.top)/u)>.5,I=e.nextElementSibling,L=l(z,j,v,f,e,g,d);if(L!==!1){if(Y=!0,setTimeout(n,30),b(q),1===L||L===-1)s=1===L;else if(B){var M=v.offsetTop,O=e.offsetTop;s=M===O?e.previousElementSibling===v&&!C||H&&C:e.previousElementSibling===v||v.previousElementSibling===e?(d.clientY-g.top)/u>.5:O>M}else s=I!==v&&!D||H&&D;v.contains(j)||(s&&!I?j.appendChild(v):e.parentNode.insertBefore(v,s?I:e)),w=v.parentNode,this._animate(f,v),this._animate(g,e)}}}},_animate:function(a,b){var c=this.options.animation;if(c){var d=b.getBoundingClientRect();i(b,"transition","none"),i(b,"transform","translate3d("+(a.left-d.left)+"px,"+(a.top-d.top)+"px,0)"),b.offsetWidth,i(b,"transition","all "+c+"ms"),i(b,"transform","translate3d(0,0,0)"),clearTimeout(b.animated),b.animated=setTimeout(function(){i(b,"transition",""),i(b,"transform",""),b.animated=!1},c)}},_offUpEvents:function(){var a=this.el.ownerDocument;g(S,"touchmove",this._onTouchMove),g(S,"pointermove",this._onTouchMove),g(a,"mouseup",this._onDrop),g(a,"touchend",this._onDrop),g(a,"pointerup",this._onDrop),g(a,"touchcancel",this._onDrop)},_onDrop:function(b){var c=this.el,d=this.options;clearInterval(this._loopId),clearInterval(O.pid),clearTimeout(this._dragStartTimer),g(S,"mousemove",this._onTouchMove),this.nativeDraggable&&(g(S,"drop",this),g(c,"dragstart",this._onDragStart)),this._offUpEvents(),b&&(N&&(b.preventDefault(),!d.dropBubble&&b.stopPropagation()),x&&x.parentNode.removeChild(x),v&&(this.nativeDraggable&&g(v,"dragend",this),m(v),v.style["will-change"]="",h(v,this.options.ghostClass,!1),h(v,this.options.chosenClass,!1),z!==w?(I=q(v,d.draggable),I>=0&&(k(null,w,"add",v,z,H,I),k(this,z,"remove",v,z,H,I),k(null,w,"sort",v,z,H,I),k(this,z,"sort",v,z,H,I))):(y&&y.parentNode.removeChild(y),v.nextSibling!==A&&(I=q(v,d.draggable),I>=0&&(k(this,z,"update",v,z,H,I),k(this,z,"sort",v,z,H,I)))),a.active&&(null!=I&&I!==-1||(I=H),k(this,z,"end",v,z,H,I),this.save()))),this._nulling()},_nulling:function(){z=v=w=x=A=y=B=C=L=M=N=I=E=F=K=J=a.active=null},handleEvent:function(a){var b=a.type;"dragover"===b||"dragenter"===b?v&&(this._onDragOver(a),e(a)):"drop"!==b&&"dragend"!==b||this._onDrop(a)},toArray:function(){for(var a,b=[],d=this.el.children,e=0,f=d.length,g=this.options;e<f;e++)a=d[e],c(a,g.draggable,this.el)&&b.push(a.getAttribute(g.dataIdAttr)||p(a));return b},sort:function(a){var b={},d=this.el;this.toArray().forEach(function(a,e){var f=d.children[e];c(f,this.options.draggable,d)&&(b[a]=f)},this),a.forEach(function(a){b[a]&&(d.removeChild(b[a]),d.appendChild(b[a]))})},save:function(){var a=this.options.store;a&&a.set(this)},closest:function(a,b){return c(a,b||this.options.draggable,this.el)},option:function(a,b){var c=this.options;return void 0===b?c[a]:(c[a]=b,void("group"===a&&ba(c)))},destroy:function(){var a=this.el;a[Q]=null,g(a,"mousedown",this._onTapStart),g(a,"touchstart",this._onTapStart),g(a,"pointerdown",this._onTapStart),this.nativeDraggable&&(g(a,"dragover",this),g(a,"dragenter",this)),Array.prototype.forEach.call(a.querySelectorAll("[draggable]"),function(a){a.removeAttribute("draggable")}),_.splice(_.indexOf(this._onDragOver),1),this._onDrop(),this.el=a=null}},a.utils={on:f,off:g,css:i,find:j,is:function(a,b){return!!c(a,b,a)},extend:t,throttle:s,closest:c,toggleClass:h,clone:u,index:q},a.create=function(b,c){return new a(b,c)},a.version="1.5.0-rc1",a});

/*! SimpleUndo by Matthias Jouan – MIT | Matthias Jouan wrote this piece of software. If we meet some day, and you think this stuff is worth it, you can buy me a beer in return. */
!function(){"use strict";function b(a,b){for(;a.length>b;)a.shift()}var a=function(a){var b=a?a:{},c={provider:function(){throw new Error("No provider!")},maxLength:30,onUpdate:function(){},initialItem:null};this.provider="undefined"!=typeof b.provider?b.provider:c.provider,this.maxLength="undefined"!=typeof b.maxLength?b.maxLength:c.maxLength,this.onUpdate="undefined"!=typeof b.onUpdate?b.onUpdate:c.onUpdate,this.initialItem="undefined"!=typeof b.initialItem?b.initialItem:c.initialItem,this.clear()};a.prototype.initialize=function(a){this.stack[0]=a,this.initialItem=a},a.prototype.clear=function(){this.stack=[this.initialItem],this.position=0,this.onUpdate()},a.prototype.save=function(){this.provider(function(a){b(this.stack,this.maxLength),this.position=Math.min(this.position,this.stack.length-1),this.stack=this.stack.slice(0,this.position+1),this.stack.push(a),this.position++,this.onUpdate()}.bind(this))},a.prototype.undo=function(a){if(this.canUndo()){var b=this.stack[--this.position];this.onUpdate(),a&&a(b)}},a.prototype.redo=function(a){if(this.canRedo()){var b=this.stack[++this.position];this.onUpdate(),a&&a(b)}},a.prototype.canUndo=function(){return this.position>0},a.prototype.canRedo=function(){return this.position<this.count()},a.prototype.count=function(){return this.stack.length-1},"undefined"!=typeof module&&(module.exports=a),"undefined"!=typeof window&&(window.SimpleUndo=a)}();

/**
 * If update sortable library test:
 * – bug when inner content disappear in sortable while dragging
 * – errors in IE
 */

/**!
 * wp-color-picker-alpha
 *
 * Overwrite Automattic Iris for enabled Alpha Channel in wpColorPicker
 * Only run in input and is defined data alpha in true
 *
 * Version: 1.2.2
 * https://github.com/23r9i0/wp-color-picker-alpha
 * Copyright (c) 2015 Sergio P.A. (23r9i0).
 * Licensed under the GPLv2 license.
 */
!function(t){var o="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAAHnlligAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAHJJREFUeNpi+P///4EDBxiAGMgCCCAGFB5AADGCRBgYDh48CCRZIJS9vT2QBAggFBkmBiSAogxFBiCAoHogAKIKAlBUYTELAiAmEtABEECk20G6BOmuIl0CIMBQ/IEMkO0myiSSraaaBhZcbkUOs0HuBwDplz5uFJ3Z4gAAAABJRU5ErkJggg==",i='<a tabindex="0" class="wp-color-result" />',e='<div class="wp-picker-holder" />',r='<div class="wp-picker-container" />',a='<input type="button" class="button button-small hidden" />';Color.fn.toString=function(){if(this._alpha<1)return this.toCSS("rgba",this._alpha).replace(/\s+/g,"");var t=parseInt(this._color,10).toString(16);return this.error?"":(t.length<6&&(t=("00000"+t).substr(-6)),"#"+t)},t.widget("wp.wpColorPicker",t.wp.wpColorPicker,{_create:function(){if(t.support.iris){var n=this,s=n.element;t.extend(n.options,s.data()),n.close=t.proxy(n.close,n),n.initialValue=s.val(),s.addClass("wp-color-picker").hide().wrap(r),n.wrap=s.parent(),n.toggler=t(i).insertBefore(s).css({backgroundColor:n.initialValue}).attr("title",wpColorPickerL10n.pick).attr("data-current",wpColorPickerL10n.current),n.pickerContainer=t(e).insertAfter(s),n.button=t(a),n.options.defaultColor?n.button.addClass("wp-picker-default").val(wpColorPickerL10n.defaultString):n.button.addClass("wp-picker-clear").val(wpColorPickerL10n.clear),s.wrap('<span class="wp-picker-input-wrap" />').after(n.button),s.iris({target:n.pickerContainer,hide:n.options.hide,width:n.options.width,mode:n.options.mode,palettes:n.options.palettes,change:function(i,e){n.options.alpha?(n.toggler.css({"background-image":"url("+o+")"}).html("<span />"),n.toggler.find("span").css({width:"100%",height:"100%",position:"absolute",top:0,left:0,"border-top-left-radius":"3px","border-bottom-left-radius":"3px",background:e.color.toString()})):n.toggler.css({backgroundColor:e.color.toString()}),t.isFunction(n.options.change)&&n.options.change.call(this,i,e)}}),s.val(n.initialValue),n._addListeners(),n.options.hide||n.toggler.click()}},_addListeners:function(){var o=this;o.wrap.on("click.wpcolorpicker",function(t){t.stopPropagation()}),o.toggler.on("click",function(){o.toggler.hasClass("wp-picker-open")?o.close():o.open()}),o.element.on("change",function(i){(""===t(this).val()||o.element.hasClass("iris-error"))&&(o.options.alpha?(o.toggler.removeAttr("style"),o.toggler.find("span").css("backgroundColor","")):o.toggler.css("backgroundColor",""),t.isFunction(o.options.clear)&&o.options.clear.call(this,i))}),o.toggler.on("keyup",function(t){13!==t.keyCode&&32!==t.keyCode||(t.preventDefault(),o.toggler.trigger("click").next().focus())}),o.button.on("click",function(i){t(this).hasClass("wp-picker-clear")?(o.element.val(""),o.options.alpha?(o.toggler.removeAttr("style"),o.toggler.find("span").css("backgroundColor","")):o.toggler.css("backgroundColor",""),t.isFunction(o.options.clear)&&o.options.clear.call(this,i)):t(this).hasClass("wp-picker-default")&&o.element.val(o.options.defaultColor).change()})}}),t.widget("a8c.iris",t.a8c.iris,{_create:function(){if(this._super(),this.options.alpha=this.element.data("alpha")||!1,this.element.is(":input")||(this.options.alpha=!1),"undefined"!=typeof this.options.alpha&&this.options.alpha){var o=this,i=o.element,e='<div class="iris-strip iris-slider iris-alpha-slider"><div class="iris-slider-offset iris-slider-offset-alpha"></div></div>',r=t(e).appendTo(o.picker.find(".iris-picker-inner")),a=r.find(".iris-slider-offset-alpha"),n={aContainer:r,aSlider:a};"undefined"!=typeof i.data("custom-width")?o.options.customWidth=parseInt(i.data("custom-width"))||0:o.options.customWidth=100,o.options.defaultWidth=i.width(),(o._color._alpha<1||-1!=o._color.toString().indexOf("rgb"))&&i.width(parseInt(o.options.defaultWidth+o.options.customWidth)),t.each(n,function(t,i){o.controls[t]=i}),o.controls.square.css({"margin-right":"0"});var s=o.picker.width()-o.controls.square.width()-20,l=s/6,c=s/2-l;t.each(["aContainer","strip"],function(t,i){o.controls[i].width(c).css({"margin-left":l+"px"})}),o._initControls(),o._change()}},_initControls:function(){if(this._super(),this.options.alpha){var t=this,o=t.controls;o.aSlider.slider({orientation:"vertical",min:0,max:100,step:1,value:parseInt(100*t._color._alpha),slide:function(o,i){t._color._alpha=parseFloat(i.value/100),t._change.apply(t,arguments)}})}},_change:function(){this._super();var t=this,i=t.element;if(this.options.alpha){var e=t.controls,r=parseInt(100*t._color._alpha),a=t._color.toRgb(),n=["rgb("+a.r+","+a.g+","+a.b+") 0%","rgba("+a.r+","+a.g+","+a.b+", 0) 100%"],s=t.options.defaultWidth,l=t.options.customWidth,c=t.picker.closest(".wp-picker-container").find(".wp-color-result");e.aContainer.css({background:"linear-gradient(to bottom, "+n.join(", ")+"), url("+o+")"}),c.hasClass("wp-picker-open")&&(e.aSlider.slider("value",r),t._color._alpha<1?(e.strip.attr("style",e.strip.attr("style").replace(/rgba\(([0-9]+,)(\s+)?([0-9]+,)(\s+)?([0-9]+)(,(\s+)?[0-9\.]+)\)/g,"rgb($1$3$5)")),i.width(parseInt(s+l))):i.width(s))}var p=i.data("reset-alpha")||!1;p&&t.picker.find(".iris-palette-container").on("click.palette",".iris-palette",function(){t._color._alpha=1,t.active="external",t._change()})},_addInputListeners:function(t){var o=this,i=100,e=function(i){var e=new Color(t.val()),r=t.val();t.removeClass("iris-error"),e.error?""!==r&&t.addClass("iris-error"):e.toString()!==o._color.toString()&&("keyup"===i.type&&r.match(/^[0-9a-fA-F]{3}$/)||o._setOption("color",e.toString()))};t.on("change",e).on("keyup",o._debounce(e,i)),o.options.hide&&t.on("focus",function(){o.show()})}})}(jQuery),jQuery(document).ready(function(t){t(".color-picker").wpColorPicker()});


/**
 * Mutation observer library written by Alexey Petlenko
 *
 * @author Alexey Petlenko(Massique)
 */

;(function(){

	'use strict';

	var observerClass = function(element, callback, config) {

		if ( ! window.MutationObserver ) {

			console.error('mq_mutation_obs:: Browser does not support mutations! Please, install IE11+ or update your current browser to newest version.' );
			return false;
		}

		if( ! element || typeof callback != 'function' || ( typeof config != 'object' && config ) ) {

			console.error('mq_mutation_obs:: invalid arguments in class constructor');
			return false;
		}

		// create an observer instance
		var observer = new MutationObserver(function(mutations) {

		    mutations.forEach(callback);
		});

		// configuration of the observer:
		var configFinal = config || { attributes: true, childList: true, characterData: true };

		// pass in the target node, as well as the observer options
		observer.observe(element, configFinal);

		return observer;
	}

	window.mqMutationObserver = observerClass;
}());


/**
 * Hide element when click on another element on the page
 *
 * @author Alexey Petlenko
 */
jQuery.fn.outerHide = function(params)
{
    var $ = jQuery;
    params = params ? params : {};

    var self = this;

    if ( 'destroy' == params ) {

        $(document).unbind('click.outer_hide');
        return false;
    }

    $(document).bind('click.outer_hide', function(e) {

        if ($(e.target).closest(self).length == 0 &&
            e.target != self &&
            $.inArray($(e.target)[0], $(params.clickObj)) == -1 &&
            $(self).css('display') != 'none'
        )
        {
            if(params.clbk)
            {
                params.clbk();
            }else{
                $(self).hide();
            }
        }
    });
};



/**
 * Element.closest() Polyfill
 * https://developer.mozilla.org/en-US/docs/Web/API/Element/closest
 * github.com/jonathantneal/closest
 */

 (function (ElementProto) {
 	if (typeof ElementProto.matches !== 'function') {
 		ElementProto.matches = ElementProto.msMatchesSelector || ElementProto.mozMatchesSelector || ElementProto.webkitMatchesSelector || function matches(selector) {
 			var element = this;
 			var elements = (element.document || element.ownerDocument).querySelectorAll(selector);
 			var index = 0;

 			while (elements[index] && elements[index] !== element) {
 				++index;
 			}

 			return Boolean(elements[index]);
 		};
 	}

 	if (typeof ElementProto.closest !== 'function') {
 		ElementProto.closest = function closest(selector) {
 			var element = this;

 			while (element && element.nodeType === 1) {
 				if (element.matches(selector)) {
 					return element;
 				}

 				element = element.parentNode;
 			}

 			return null;
 		};
 	}
 })(window.Element.prototype);