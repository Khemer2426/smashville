class Repeater {
    init() {
        $(document).on('click', '.repeater .btn-add', function() {
            if ($(this).parents('.repeater').find('.repeater-item-wrapper .repeater-item:last-child').hasClass('d-none')
                && $(this).hasClass('btn-customer_specific')) 
            {
                $(this).parents('.repeater').find('.repeater-item-wrapper .repeater-item:last-child').removeClass('d-none');
                $(this).parents('.repeater').find('.repeater-item-wrapper .repeater-item .documentation-table').removeClass('draft');
                $(this).parents('.repeater').find('.repeater-item-wrapper .repeater-item .repeater-actions .btn-remove.documentation-repeater').removeClass('invisible');
                return false;
            }

            var nextItem = $(this).parents('.repeater').find('.repeater-item-wrapper .repeater-item').length;
            var cloned = $(this).parents('.repeater').find('.repeater-item-wrapper .repeater-item:last-child').clone();
            var parent = $(this).parents('.repeater').find('.repeater-item-wrapper');
            
            Repeater.cloneItem(cloned, nextItem,parent);

            $(this).parents('.repeater-actions').find('.btn-remove:not(.draft)').removeClass('invisible');
            $(this).parents('.repeater').find('.repeater-item-wrapper .repeater-item .repeater-actions .btn-remove:not(.draft)').removeClass('invisible');
        });
        
        $(document).on('click', '.repeater .btn-remove', function(e) {
            e.preventDefault();
            if ($(this).hasClass('documentation-repeater') && $(this).parents('.repeater').find('.repeater-item-wrapper .repeater-item').length == 1) {
                $(this).closest('.repeater-item').addClass('d-none');
                $(this).parents('.repeater').find('.repeater-item-wrapper .repeater-item .documentation-table').addClass('draft');
                return false;
            }
            var is_documentation = $(this).hasClass('documentation-repeater');
            var repeater = $(this).parents('.repeater');
            
            $(this).parents('.repeater-item').remove();

            var nextItem = 0;
            var item_length =  repeater.find('.repeater-item').length;
            repeater.find('.repeater-item').each(function () {
                var cloned = $(this);
                var parent = $(this).parents('.repeater-item-wrapper');

                Repeater.cloneItem(cloned, nextItem, parent, false, item_length, is_documentation);

                nextItem += 1;
            });
        });
    }

    static cloneItem(cloned, nextItem, parent, reset = true, item_length = 0, is_documentation = false)
    {
        var optional = false;
        if ($(cloned).hasClass('optional-group')) {
            optional = true;
        }
        if (reset) {
            $(cloned).find('.form-control:not([type=radio])').val('');
            $(cloned).find('.service-fields').addClass('d-none');
            $(cloned).find('.service-experience').addClass('d-none');
            $(cloned).find('.position-select').html('<option value="">Select an option</option>');
            $(cloned).find('.item-default-preview').remove();
            $(cloned).find('.item-preview').removeClass('d-none');
            $(cloned).find('.form-check-input').prop('checked', false);
            $(cloned).find('.total-hours').html('0');
            
            if ($(cloned).find('.repeater').length) {
                $(cloned).find('.repeater-item:not(:first-child)').remove();
                $(cloned).find('.btn-remove').addClass('invisible');
            }
        }
        $(cloned).find('.invalid-feedback').remove();
        $(cloned).find('label.error').remove();
        $(cloned).find('.js-flatpickr').removeClass('js-flatpickr-enabled');
        if (nextItem > 0) {
            $(cloned).find('.btn-remove').removeClass('invisible');
        } 
        
        if (item_length > 1) {
            $(cloned).find('.btn-remove').removeClass('invisible');
        } else if (item_length !== 0 && !is_documentation) {
            $(cloned).find('.btn-remove').addClass('invisible');
        }
        
        var fields = $(cloned).find('.form-control, .form-check-input, .btn-knowledgebase');
        fields.map((key, value) => {
            var name = $(value).attr('name');
            var id = $(value).attr('id');
            var data_id = $(value).data('id');
            var errors = $(value).data('errors');
            $(value).prop('readonly', false);
            $(value).prop('disabled', false);
           
            if(name) {
                $(value).attr('name', updateIndex(name, nextItem));
            }
            if(id) {
                $(value).attr('id', updateIndex(id, nextItem));
                
                if($(value).hasClass('increment-placeholder')) {
                    var text = $(cloned).find('[for="' + name + '"]').text();
                    $(cloned).find('[for="' + name + '"]').text(updateIndex(text, nextItem + 1))
                }

                if ($(value).next('label').length) {
                    $(value).next('label').attr('for', updateIndex(id, nextItem));
                }
                $(cloned).find('[for="' + name + '"]').attr('for', updateIndex(id, nextItem));

                if ($(value).next('.custom-file-label').length) {
                    $(value).next('.custom-file-label').find('.custom-file-icon').attr('for', updateIndex(id, nextItem));
                }
                if ($(value).hasClass('on-duty-check') || $(value).hasClass('off-duty-check')) {
                    $(value).prop('required', true);
                }
            }
            if(data_id) {
                $(value).attr('data-id', updateIndex(data_id, nextItem));
            }
            if (errors) {
                $(errors).attr('id', updateIndex(errors, nextItem));
                $(value).data('errors', updateIndex(errors, nextItem))
            }
            if (optional) {
                $(value).prop('required', false);
            }
            if (reset && $(value).hasClass('fetching-data')) {
                $(value).addClass('rounded-bottom-end-1');
                $(value).closest('.command-group').find('.command').addClass('d-none');
            }
        });

        if($(cloned).find('.year-index').length) {
            $(cloned).find('.year-index').html(nextItem + 1);
        }

        $(cloned).find('.js-flatpickr:not(.js-flatpickr-enabled)').each(function(){
            $(this).addClass('js-flatpickr-enabled');
            flatpickr($(this));
        });

        $(cloned).find('.js-ckeditor').each(function() {
            var el = $(this);
            $(this).show();
            $(this).siblings('.ck-editor').remove();
            ClassicEditor.create( this, {
                toolbar: [ 'bold', 'italic', 'link' ],
            } ).then (editor => {
                if(!el.hasClass('ckeditor-optional')) {
                    $.validator.addMethod("ckeditor", function () {
                        var content_length = editor.getData().trim().length;
                        return content_length > 0;
                    }, "This field is required.");
                }
            }).catch( error => {
                console.log( error );
            });
        });

        if (reset) {
            console.log(cloned);
            $(parent).append(cloned);
        }

        function updateIndex(text, index) {
            if (/^\w+\[[^\]]*\]\[\d+\]\[[^\]]*\]$/.test(text)) {
                var regex = /^(\w+\[)([^\]]*)(\])(\[)(\d+)(\])(\[)(\w+)(\])$/;
                return text.replace(regex, function(match, p1, p2, p3, p4, p5, p6, p7, p8, p9) {
                    return p1 + p2 + p3 + p4 + index + p6 + p7 + p8 + p9;
                });
            }

            return text.replace(/\d+/, index)
        }
    }
  
}

export default new Repeater;