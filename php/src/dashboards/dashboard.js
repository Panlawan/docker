$(document).ready(function() {
    // Make visualizations draggable
    $(".visualization").draggable();
  
    // Make visualizations resizable
    $(".visualization").resizable();
  
    // Handle lock/unlock click event
    $(".lock-icon").on("click", function() {
      var visualization = $(this).closest(".visualization");
      visualization.toggleClass("locked");
    });
  });
  