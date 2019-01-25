$(document).ready(function(){
    $('span.checkbox-image').on('click', function(){
        $(this).next('label').click();
    });
});
