$(document).on('click', 'input:checkbox', getCheckedBox);

getCheckedBox();

function getCheckedBox() {
  
  var checkedBox = $.map($('input:checkbox:checked'), 
                         function(val, i) {
                            return val.value;
                         });
  console.clear();
  console.log(checkedBox);
}