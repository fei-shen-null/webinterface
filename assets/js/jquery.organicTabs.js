(function($) {

    $.organicTabs = function(el, options) {
    
        var base = this;
        base.$el = $(el);
        base.$nav = base.$el.find(".nav");
                  
        base.init = function() {
        
            base.options = $.extend({},$.organicTabs.defaultOptions, options);
                  
            // Accessible hiding fix
            $(".hide").css({
                "position": "relative",
                "top": 0,
                "left": 0,
                "display": "none"
            }); 
            
            base.$nav.delegate("li > a", "click", function(e) {
            
            	// no hash links
            	e.preventDefault();
            
                // Figure out current list via CSS class
                var curList = base.$el.find("a.current").attr("href").substring(1),
                
                // List moving to
                    $newList = $(this),
                    
                // Figure out ID of new list
                    listID = $newList.attr("href").substring(1),
                
                // Set outer wrapper height to (static) height of current inner list
                    $allListWrap = base.$el.find(base.options.contentsSelector),
                    curListHeight = $allListWrap.height();
                    $allListWrap.height(curListHeight);
                                        
                if ((listID != curList) && ( base.$el.find(":animated").length == 0)) {
                                            
                    // Fade out current list
                    base.$el.find("#"+curList).fadeOut(base.options.speed, function() {
                        
                        // Fade in new list on callback
                        base.$el.find("#"+listID).fadeIn(base.options.speed);
                        
                        // Adjust outer wrapper to fit new list snuggly
                        var newHeight = base.$el.find("#"+listID).height();
                        $allListWrap.animate({
                            height: newHeight
                        });
                        
                        // Remove highlighting - Add to just-clicked tab
                        base.$el.find(".nav li a").removeClass("current");
                        $newList.addClass("current");
                            
                    });
                    
                }   
                
                // Don't behave like a regular link
                // Stop propagation and bubbling
                return false;
            });
            
        };
        base.init();
    };
    
    $.organicTabs.defaultOptions = {
        contentsSelector: ".list-wrap",  // jQuery selector string to find contents container(s) inside the target element
      
        fadingSpeed: 300,                // Speed of fading animations
        fadingEasing: "swing",           // Easing used for fading animations
        
        sizingSpeed: 300,                // Speed of resizing animations
        sizingEasing: "swing"            // Easing used for resizing animations
    };
    
    $.fn.organicTabs = function(options) {
        return this.each(function() {
            (new $.organicTabs(this, options));
        });
    };
    
})(jQuery);