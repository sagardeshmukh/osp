$(document).ready(function() {
// Disable dummy fields and hide them
$("#product_job_contact").attr('disabled', 'disabled');
$("#product_job_url").attr('disabled', 'disabled');

if($("#product_job_contact").val() != "") {
$("#product_job_contact").attr('disabled', '');

$("#radiobutton-email").click();
}

if($("#product_job_url").val() != "") {
$("#product_job_url").attr('disabled', '');

$("#radiobutton-externalurl").click();
}

$("#radiobutton-externalurl").click(function() {
$("#product_job_contact").val("");
$("#product_job_contact").attr('disabled', 'disabled');

$("#product_job_url").attr('disabled', '');
});

$("#radiobutton-email").click(function() {
$("#product_job_url").val("");
$("#product_job_url").attr('disabled', 'disabled');

$("#product_job_contact").attr('disabled', '');
});
});