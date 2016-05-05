/**
 * Extend function
 */

;( function(){
	function extendClass( parent, child ){
		child.prototype = Object.create( parent.prototype );
		child.prototype.constructor = child;
	}

	window.extendClass = extendClass;
}() );