$(document).ready(function () {
    $('#requestForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'backend/process_insert_requests.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#form-message').text(response.message).fadeIn().delay(3000).fadeOut();
                $('#requestForm')[0].reset();

                Swal.fire({
                    icon: 'success',
                    title: 'Submitted!',
                    text: 'Your request was submitted successfully.'
                });
            },
            error: function () {
                $('#form-message').text('An error occurred. Please try again.').css('color', 'red').fadeIn().delay(3000).fadeOut();
            }
        });
    });
});
