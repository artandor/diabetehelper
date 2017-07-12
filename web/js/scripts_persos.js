/**
 * Created by millt on 31/10/2016.
 */

jQuery(document).ready(function ($) {

    var form = $('#formPlagesHoraires');
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
            html += '</li>';

            form.find("input").each(function (index, element) {
                this.value = "";
            });

            $('#dates').append(html);
            var lastChildData = $('ol#dates li:last-child');
            form.find('input[name="hourStart"]').val(lastChildData.data('hourend'));
            form.find('input[name="hourEnd"]').val(lastChildData.data('hourend'));
            form.find('input[name="hourEnd"]').attr('min', lastChildData.data('hourend'));
            
            var allData = [];
    
    
            $('#dates').find('li').each(function (index, element) {
                allData.push($(this).data());
            });
    
            allData = JSON.stringify(allData);
            console.log(allData);
            $('#fos_user_profile_form_glucidInsulinRatio').val(allData);
        } else {
            $('#errorRatio').removeClass('hidden');
            
        }
    });
});
