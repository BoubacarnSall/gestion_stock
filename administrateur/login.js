$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();

        if (email === '' || password === '') {
            Swal.fire({
                title: 'Erreur',
                text: 'Veuillez remplir tous les champs.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }

        $.ajax({
            url: 'login.php',
            type: 'POST',
            data: { email: email, password: password },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    window.location.href = 'sidbar.php';
                } else {
                    Swal.fire({
                        title: 'Erreur',
                        text: 'L\'adresse mail ou le mot de passe incorect',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Erreur',
                    text: 'Erreur lors de la connexion.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
