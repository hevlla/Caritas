$(function () {
  var $ref_select = $('.ref_select');
  /* cache option html */
  var optHtml = $ref_select.first().html();

  $ref_select.on('change', function () {
      /* make array of all selected values*/
      var selecteds=$ref_select.find('option:selected').map(function(){               
              return this.value                
      }).get();
      /* rebuild the other select elements*/
      $ref_select.not(this).each(function(){
          var selVal=this.value || '';
          /* create new set of options with filtered values*/ 
          var $opts=$(optHtml).filter(function(){
              return $.inArray(this.value,selecteds) ==-1 ||  this.value ==selVal
          });
          /* replace children*/
          $(this).html($opts).val(selVal);

      });
  });
});