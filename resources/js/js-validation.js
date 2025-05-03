class jsValidation {

    static init() {
        
        One.helpers("jq-validation");

        jQuery.validator.methods.required = function( value, element, param ) {
            if ( !this.depend( param, element ) ) {
                return "dependency-mismatch";
            }
            if ( element.nodeName.toLowerCase() === "select" ) {
                var val = $( element ).val();
                return val && val.length > 0;
            }
            if ( this.checkable( element ) ) {
                return this.getLength( value, element ) > 0;
            }
            return value !== undefined && value !== null && value.trim().length > 0;
        }

        jQuery('.js-validation').each(function() {
            $(this).validate({
                errorPlacement: function(error, element) {
                  var placement = $(element).data('error');
                  if (placement) {
                    $(placement).append(error)
                  } else {
                    error.insertAfter(element);
                  }
                },
                submitHandler: function (form) {
                  form.submit();
                }
            });
        });

        jQuery.validator.addMethod('input_year', function (value, element) {
            // 1950 - 2050
            return this.optional( element ) || /^(19[5-9]\d|20[0-4]\d|2050)$/.test(value);
        }, function (value, element) {
            return 'Invalid input year.';
        });
    }
  }
  
  // Initialize when page loads
  One.onLoad(() => jsValidation.init());