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
		      $("#reading-modal input[name='employees']").val(line.data("line-employee"));
		      $("#reading-modal input[name='reading']").val(line.data("line-reading"));
		      $("#reading-modal select[name='product_id']").val(line.data("product-id"));
		  	  $("#reading-modal select[name='notes']").filter(function() {
		  	  													return $(this).text() == line.data("line-notes");
		  	  												}).prop('selected', true);
		  	  
          $("#reading-modal")
            .data("line-id", 
                  line.data("line-id"));
          ;
        });

  $("#reading-modal")
    .on("click",
        ".btn-save:not(.disabled)",
        function() {
          var modal = $(this).closest(".modal");
          var line_id = modal.data("line-id");
          var buttons = modal.find(".modal-footer .btn");

          var product_id = modal.find(":input[name='product_id']").val();

          modal.find(".error").removeClass("error");
          if (!product_id) {
            modal.find(":input[name='product_id']").closest(".control-group").addClass("error");
            return;
          };
          
          $.post(BASE_URL + "/mobile/line/" + line_id + "/readings",
                 {
                   reading: modal.find(":input[name='reading']").val(),
                   employees: modal.find(":input[name='employees']").val(),
                   notes: modal.find(":input[name='notes']").val(),
                   product_id: product_id
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

  $(".icon-comment[data-toggle='popover']").popover();
});
