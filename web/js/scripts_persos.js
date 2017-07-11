/**
 * Created by millt on 31/10/2016.
 */

jQuery(document).ready(function($) {

   if ($('ol#dates li').data('hourend')) {
      $('#formPlagesHoraires input[name="hourStart"]').val($('ol#dates li:last-child').data('hourend'));
      $('#formPlagesHoraires input[name="hourEnd"]').val($('ol#dates li:last-child').data('hourend'));
      $('#formPlagesHoraires input[name="hourEnd"]').attr('min', $('ol#dates li:last-child').data('hourend'));
   }
   else {
      $('#formPlagesHoraires input[name="hourStart"]').val('00:00');
      $('#formPlagesHoraires input[name="hourEnd"]').val('00:00');
   }


   $('form#formPlagesHoraires #addPlage').click(function addPlage() {
      if ($('#formPlagesHoraires input[name=hourStart]').val() != "" && $('#formPlagesHoraires input[name=hourEnd]').val() != "" && $('#formPlagesHoraires input[name=ratio]').val() != "") {

         var html =
            '<li data-hourStart="' +
            $('#formPlagesHoraires input[name=hourStart]').val() +
            '" data-hourEnd="' + $('#formPlagesHoraires input[name=hourEnd]').val() +
            '" data-ratio="' +
            $('#formPlagesHoraires input[name=ratio]').val() +
            '">';
         html += 'Heure start : ' + $('#formPlagesHoraires input[name=hourStart]').val() + ' / heure end : ' + $('#formPlagesHoraires input[name=hourEnd]').val() + ' / ratio : ' + $('#formPlagesHoraires input[name=ratio]').val();
         html += '</li>';

         $("#formPlagesHoraires input").each(function(index, element) {
            this.value = "";
         });

         $('#dates').append(html);
         $('#formPlagesHoraires input[name="hourStart"]').val($('ol#dates li:last-child').data('hourend'));
         $('#formPlagesHoraires input[name="hourEnd"]').val($('ol#dates li:last-child').data('hourend'));
         $('#formPlagesHoraires input[name="hourEnd"]').attr('min', $('ol#dates li:last-child').data('hourend'));
      }
   });

   $("#formPlagesHoraires").submit(function(event) {

      // Stop form from submitting normally
      event.preventDefault();

      var allData = new Array;


      $('#dates li').each(function(index, element) {
         allData.push($(this).data());
      });

      console.log(JSON.stringify(allData));
      allData = JSON.stringify(allData);

      var $form = $(this);
      var url = $form.attr("action");

      $.post(url, 'data=' + allData, function(response) {
         alert(response);
      });
   });
});
