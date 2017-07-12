/**
 * Created by millt on 31/10/2016.
 */

jQuery(document).ready(function ($) {
    function insertJsonIntoHiddenField(parent, elements, field){
            var allData = [];
    
            parent.find(elements).each(function () {
                allData.push($(this).data());
            });
    
            allData = JSON.stringify(allData);
            console.log(allData);
            field.val(allData);
    }
    
    function addRemoveButtonAfter(element){
        element.append('<button type="button" class="close remove" aria-label="Close"><span aria-hidden="true">×</span></button></li>');
    }
    

    
/* Start Form glucid/Insulin ratios */

    var form = $('#formPlagesHoraires');
    if ($('ol#dates li').length > 0){
        addRemoveButtonAfter($('ol#dates.with-form li:last-child'));
    }
    
    /* Setting up default values for time fields */
    if ($('ol#dates li').data('hourend')) {
        var lastChildData = $('ol#dates li:last-child');

        form.find('input[name="hourStart"]').val(lastChildData.data('hourend'));
        form.find('input[name="hourEnd"]').val(lastChildData.data('hourend'));
        form.find('input[name="hourEnd"]').attr('min', lastChildData.data('hourend'));
    }
    else {
        form.find('input[name="hourStart"]').val('00:00');
        form.find('input[name="hourEnd"]').val('00:00');
    }

    /* Handler for click on "addPlage" button */
    form.find('#addPlage').click(function addPlage() {
        if (form.find('input[name=hourStart]').val() !== "" && form.find('input[name=hourEnd]').val() !== "" && form.find('input[name=ratio]').val() !== "") {
            $('#errorRatio').addClass('hidden');
            var html =
                '<li data-hourStart="' +
                form.find('input[name=hourStart]').val() +
                '" data-hourEnd="' + form.find('input[name=hourEnd]').val() +
                '" data-ratio="' +
                form.find('input[name=ratio]').val() +
                '">';
            html += 'Heure start : ' + form.find('input[name=hourStart]').val() + ' / heure end : ' + form.find('input[name=hourEnd]').val() + ' / ratio : ' + $('#formPlagesHoraires input[name=ratio]').val();
            html += '<button type="button" class="close remove" aria-label="Close"><span aria-hidden="true">×</span></button></li>';

            form.find("input").each(function (index, element) {
                this.value = "";
            });

            $('#dates').append(html);
            refreshFormRatio(form);
            
            $('ol#dates li').find('.remove').remove();
            addRemoveButtonAfter($('ol#dates.with-form li:last-child'));
            
            insertJsonIntoHiddenField($('#dates'), 'li', $('#fos_user_profile_form_glucidInsulinRatio'));
        } else {
            $('#errorRatio').removeClass('hidden');
            
        }
    });
    
    function refreshFormRatio(form){
        var lastChildData = $('ol#dates li:last-child');
        if(lastChildData.length > 0){
            form.find('input[name="hourStart"]').val(lastChildData.data('hourend'));
            form.find('input[name="hourEnd"]').val(lastChildData.data('hourend'));
            form.find('input[name="hourEnd"]').attr('min', lastChildData.data('hourend'));
        } else {
            form.find('input[name="hourStart"]').val('00:00');
            form.find('input[name="hourEnd"]').val('00:00');
        }
    }
    
    $('body').delegate('#dates li .remove', 'click', function(){
        $(this).parent().remove();
        refreshFormRatio(form);
        insertJsonIntoHiddenField($('#dates'), 'li', $('#fos_user_profile_form_glucidInsulinRatio'));
    });
/* End Form glucid/Insulin ratios */
});
