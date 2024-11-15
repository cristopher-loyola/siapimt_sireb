// Script para cambiar el valor seleccionado del select al hacer clic en él
document.querySelectorAll('.custom-select select').forEach(function(select) {
    select.addEventListener('click', function() {
        this.style.border = '2px solid #007BFF'; // Cambia el borde al hacer clic
    });
    select.addEventListener('blur', function() {
        this.style.border = '1px solid #ccc'; // Restaura el borde al perder el foco
    });
});








$.fn.selectify = function() {
    var select = $(this);
    var option = $("option");
    var placeholder = select.attr("placeholder");
  
    // reorganize DOM, since <select> isn't much styleable
    // create the wrapper
    select.wrap("<div class='select-wrap'></div>");
  
    // create the filter wrap and the options in it
    select.after("<ul class='filter-wrap'></ul>");
    option.each(function() {
      var label = $(this).text();
  
      $(".select-wrap ul").append("<li>" + label + "</li>");
    });
  
    // replace the <select> with a div
    select.replaceWith("<div class='select'></div>");
  
    // add the expand arrow and the label
    $(".select-wrap .select")
      .prepend("<div class='arrow'></div>")
      .prepend("<p>" + placeholder + "</p>");
  
    // update variables
    select = $(".select-wrap");
    var filters = select.find("ul");
    option = select.find("ul li");
    placeholder = select.find("p");
  
    // open click
    select.find(".arrow").click(function() {
      $(select).toggleClass("open");
  
      filters.slideToggle(400, "easeInOutBack");
    });
    
    // add filter click
    $(document).on("click", ".select-wrap ul li", function() {
      var dis = $(this);
  
      function inFilter() {
        // add same filter to box
        var filter = $("<div class='filter'>" + dis.text() + "</div>");
        $(".select").append(filter);
  
        // remove transition
        dis.addClass("remove");
  
        // collapse list and remove the element
        setTimeout(function() {
          dis.slideToggle(200, function() {
            dis.remove();
          });
  
          // set filter to inline block
          filter.css("display", "inline-block");
  
          // make it visible with transition
          setTimeout(function() {
            filter.addClass("active");
          }, 200);
        }, 300);
      }
      
      // change styling if there are no filters left
      if ($(".filter-wrap").children().length == 1){
        $(".select").css("border-radius", "8px");
        $(".arrow").fadeOut();
      }
      else{
        $(".select").removeAttr('style');
        $(".arrow").fadeIn();
      }
  
      // fade out placeholder if its the first filter
      if ($(".select").children(".filter").length == 0) {
        placeholder.css({'margin': '-45px 0 15px 0'});
        inFilter();
      } else {
        inFilter();
      }
    });
  
    // remove filter click
    $(document).on("click", ".filter", function() {
      var dis = $(this);
  
      function outFilter() {
        // out transition
        dis.removeClass("active");
  
        // make the filter visible and remove the element from above
        setTimeout(function() {
          // append same filter to list
          var filter = $("<li style='display:none'>" + dis.text() + "</li>");
          filters.append(filter);
  
          filter.slideToggle(200, function() {
            dis.remove();
          });
        }, 300);
      }
      
      // change styling if there are filters again
      if ($(".filter-wrap").children().length == 0){
        $(".select").removeAttr('style');
        $(".arrow").fadeIn();
      }
  
      // fade in label if no filter is active and execute function
      if ($(".select").children(".filter").length == 1) {
        outFilter();
  
        setTimeout(function() {
          placeholder.removeAttr("style");
        }, 470);
      } else {
        outFilter();
      }
    });
  };
  
  $("select").selectify();
  