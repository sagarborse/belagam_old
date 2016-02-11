if(document.readyState !== "complete") {  
	InstantClick.on("change", function () {  				
		if(topNavAnchors = document.querySelectorAll("#primary .nav > li > a")) {
            var subMenus = document.querySelectorAll("#primary .nav > li > ul");

            document.body.onclick = function() {
                for (var s = 0; s < subMenus.length; s++) {
                    if (subMenus[s].classList.contains("visible")) {
                      subMenus[s].classList.remove("visible");
                    }
                }
            };
			
            var topNavLi = document.querySelectorAll("#primary .nav > li ");

			var j = 0;	
			
			for (var i = 0; i < topNavAnchors.length; i++) {   			
				if(topNavLi[i].getElementsByTagName("ul").length != 0) {
					j++;
					topNavAnchors[i].onclick = function(event) {
                        event.preventDefault();
                        event.stopPropagation();
                        for (var s = 0; s < subMenus.length; s++) {
                          if (subMenus[s] !== this.nextElementSibling && subMenus[s].classList.contains("visible")) {
                            subMenus[s].classList.remove("visible");
                          }
                        }
                        if (!this.nextElementSibling.classList.contains("visible")) {
                          this.nextElementSibling.classList.add("visible");
                        }
					}; 			
				}
			}
		}
		
		if(languageForm = document.forms["language"]) {
			var languageSelect = languageForm.getElementsByTagName("select");		
			
			languageSelect[0].onchange= function() {
				languageForm.submit();
			};
		}
		
		if(currencyForm = document.forms["currency"]) {
			var currencySelect = currencyForm.getElementsByTagName("select");				
			
			currencySelect[0].onchange= function() {
				currencyForm.submit();
			};		
		}
		
		if(!supportsSVG()) {			
			document.getElementsByTagName("body")[0].className += " no-svg";			
		}

    prodTabs = document.querySelectorAll('.panel h2');
    if (prodTabs.length != 0) {
      for (var i = 0; i < prodTabs.length; i++) {        
        prodTabs[i].onclick = function(event) {
          this.parentNode.children[1].style.display == "block" ? this.parentNode.children[1].style.display = "none" : 
this.parentNode.children[1].style.display = "block";
          
          if(this.parentNode.classList.contains('opened')) {
            this.parentNode.classList.remove('opened');
          } else {
            if (o = document.querySelector('.panel.opened')) {
                o.children[1].style.display = "none";
                o.classList.remove('opened');
            }

            this.parentNode.classList.add('opened');
          }
        };
      }

      prodTabs[0].parentNode.children[1].style.display = "block";
      prodTabs[0].parentNode.classList.add('opened');
    }

    if (prodTabsCloseLinks = document.querySelectorAll('.panel .panel-content a')) {
      for (var i = 0; i < prodTabsCloseLinks.length; i++) {        
        prodTabsCloseLinks[i].onclick = function(event) {
          this.parentNode.style.display = "none";
          this.parentNode.parentNode.classList.remove('opened');
        };
      }
    }

	}, false);
}

function supportsSVG() {
    return !!document.createElementNS && !!document.createElementNS('http://www.w3.org/2000/svg', "svg").createSVGRect;
}

function focusFirstError(form) {
	document.getElementById($(form.find('.s-error').get(0)).parent().find('input, select').get(0).id).focus();
}

// jQuery Mobile compatibility  plugins
//.submit()
(function($){
    $.fn.submit=function(){
		this.get(0).submit();    	
        return this;
    };
})(jq);

//.before()
(function($){
    $.fn.before = function(opts){
    	for (var i = 0; i < this.length; i++) {
    		$(opts).insertBefore(this[i]);
        }
    	
        return this;
    };
})(jq);

//.after()
(function($){
    $.fn.after = function(opts){
    	for (var i = 0; i < this.length; i++) {
    		$(opts).insertAfter(this[i]);
        }
    	
        return this;
    };
})(jq);

//attr override
(function($){
    $.fn.original_attr = $.fn.attr;

    $.fn.attr = function(attr, value){        
        for (var i = 0; i < this.length; i++) {
            if(value === false) {
                    return $(this).removeAttr(attr);   
            } else {
            	if (value === undefined) {
                    return $(this).original_attr(attr);
                } else {
                    return $(this).original_attr(attr,value);
                }
            }
        }
        //return this;
    };
})(jq);

//.click()
(function($){
    $.fn.click = function(handler){
		$(this).bind("click", handler);
		return this;
    };
})(jq);

/* ----------------------------------
 * SLIDER v1.0.0
 * Licensed under The MIT License
 * Adapted from Brad Birdsall's swipe
 * http://opensource.org/licenses/MIT
 * ---------------------------------- */

!function () {

  var pageX;
  var pageY;
  var slider;
  var deltaX;
  var deltaY;
  var offsetX;
  var lastSlide;
  var startTime;
  var resistance;
  var sliderWidth;
  var slideNumber;
  var isScrolling;
  var scrollableArea;

  var getSlider = function (target) {
    var i, sliders = document.querySelectorAll('.slider ul');
    for (; target && target !== document; target = target.parentNode) {
      for (i = sliders.length; i--;) { if (sliders[i] === target) return target; }
    }
  }

  var getScroll = function () {
    var translate3d = slider.style.webkitTransform.match(/translate3d\(([^,]*)/);
    return parseInt(translate3d ? translate3d[1] : 0)
  };

  var setSlideNumber = function (offset) {
    var round = offset ? (deltaX < 0 ? 'ceil' : 'floor') : 'round';
    slideNumber = Math[round](getScroll() / ( scrollableArea / slider.children.length) );
    slideNumber += offset;
    slideNumber = Math.min(slideNumber, 0);
    slideNumber = Math.max(-(slider.children.length - 1), slideNumber);
  }

  var onTouchStart = function (e) {
    slider = getSlider(e.target);

    if (!slider) return;

    var firstItem  = slider.querySelector('li');

    scrollableArea = firstItem.offsetWidth * slider.children.length;
    isScrolling    = undefined;
    sliderWidth    = slider.offsetWidth;
    resistance     = 1;
    lastSlide      = -(slider.children.length - 1);
    startTime      = +new Date;
    pageX          = e.touches[0].pageX;
    pageY          = e.touches[0].pageY;

    setSlideNumber(0);

    slider.style['-webkit-transition-duration'] = 0;
  };

  var onTouchMove = function (e) {
    if (e.touches.length > 1 || !slider) return; // Exit if a pinch || no slider

    deltaX = e.touches[0].pageX - pageX;
    deltaY = e.touches[0].pageY - pageY;
    pageX  = e.touches[0].pageX;
    pageY  = e.touches[0].pageY;

    if (typeof isScrolling == 'undefined') {
      isScrolling = Math.abs(deltaY) > Math.abs(deltaX);
    }

    if (isScrolling) return;

    offsetX = (deltaX / resistance) + getScroll();

    e.preventDefault();

    resistance = slideNumber == 0         && deltaX > 0 ? (pageX / sliderWidth) + 1.25 :
                 slideNumber == lastSlide && deltaX < 0 ? (Math.abs(pageX) / sliderWidth) + 1.25 : 1;

    slider.style.webkitTransform = 'translate3d(' + offsetX + 'px,0,0)';
  };

  var onTouchEnd = function (e) {
    if (!slider || isScrolling) return;

    setSlideNumber(
      (+new Date) - startTime < 1000 && Math.abs(deltaX) > 15 ? (deltaX < 0 ? -1 : 1) : 0
    );

    offsetX = slideNumber * sliderWidth;

    slider.style['-webkit-transition-duration'] = '.2s';
    slider.style.webkitTransform = 'translate3d(' + offsetX + 'px,0,0)';

    e = new CustomEvent('slide', {
      detail: { slideNumber: Math.abs(slideNumber) },
      bubbles: true,
      cancelable: true
    });

    slider.parentNode.dispatchEvent(e);
  };

  window.addEventListener('touchstart', onTouchStart);
  window.addEventListener('touchmove', onTouchMove);
  window.addEventListener('touchend', onTouchEnd);

}();

/*
  classList polyfill
  Copyright © 2014 Remy Sharp, http://remysharp.com
  License: http://rem.mit-license.org
*/

(function () {

if (typeof window.Element === "undefined" || "classList" in document.documentElement) return;

var prototype = Array.prototype,
    push = prototype.push,
    splice = prototype.splice,
    join = prototype.join;

function DOMTokenList(el) {
  this.el = el;
  // The className needs to be trimmed and split on whitespace
  // to retrieve a list of classes.
  var classes = el.className.replace(/^\s+|\s+$/g,'').split(/\s+/);
  for (var i = 0; i < classes.length; i++) {
    push.call(this, classes[i]);
  }
};

DOMTokenList.prototype = {
  add: function(token) {
    if(this.contains(token)) return;
    push.call(this, token);
    this.el.className = this.toString();
  },
  contains: function(token) {
    return this.el.className.indexOf(token) != -1;
  },
  item: function(index) {
    return this[index] || null;
  },
  remove: function(token) {
    if (!this.contains(token)) return;
    for (var i = 0; i < this.length; i++) {
      if (this[i] == token) break;
    }
    splice.call(this, i, 1);
    this.el.className = this.toString();
  },
  toString: function() {
    return join.call(this, ' ');
  },
  toggle: function(token) {
    if (!this.contains(token)) {
      this.add(token);
    } else {
      this.remove(token);
    }

    return this.contains(token);
  }
};

window.DOMTokenList = DOMTokenList;

function defineElementGetter (obj, prop, getter) {
    if (Object.defineProperty) {
        Object.defineProperty(obj, prop,{
            get : getter
        });
    } else {
        obj.__defineGetter__(prop, getter);
    }
}

defineElementGetter(Element.prototype, 'classList', function () {
  return new DOMTokenList(this);
});

})();