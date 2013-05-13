var BASE_URL = "";

$(function() {
  function formatErrorMessage(resp) {
    return resp.error.message + "\n\n" + _(resp.error.exception.errors).map(function(message, code) { return message; }).join("\n");
  }

  function processErrorResponse(r) {
    try {
      var jsonResponse = $.parseJSON(r.responseText);
      alert(formatErrorMessage(jsonResponse));
    } catch (x) {
      console.log(x);
      alert(__("Unhandled server error") + x);
    }
  }

  $.ajaxSetup({
    headers: {
      accept: "application/json"
    }
  });

  $(".line .btn-add")
    .on("click",
        function() {
          var line = $(this).closest(".line");
		  
		  $("#reading-modal #reading-modal-label").html("Add a new reading - Line " + line.data("line-name"));
		  
          $("#reading-modal")
            .data("line-id", 
                  line.data("line-id"))
            .find(":input[name='product_id']").val(line.data("product-id"));
          ;
        });

  $("#reading-modal")
    .on("click",
        " .btn-save:not(.disabled)",
        function() {
          var modal = $(this).closest(".modal");
          var line_id = modal.data("line-id");
          var buttons = modal.find(".modal-footer .btn");
          
          $.post(BASE_URL + "/mobile/line/" + line_id + "/readings",
                 {
                   reading: modal.find(":input[name='reading']").val(),
                   employees: modal.find(":input[name='employees']").val(),
                   notes: modal.find(":input[name='notes']").val(),
                   product_id: modal.find(":input[name='product_id']").val()
                 })
            .done(function() {
              document.location.reload();
            })
            .fail(function(r) {
              processErrorResponse(r);
            })
            .always(function() {
              buttons.removeClass("disabled");
            });
          ;

          buttons.addClass("disabled");
        });
});
