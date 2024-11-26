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
                console.log('Réponse du serveur:', response);
                if (response.success) {
                    if (response.role === 'admin') {
                        window.location.href = '../administrateur/sidbar.php'; 
                    } else {
                        window.location.href = 'sidbarUt.php';
                    }
                } else {
                    Swal.fire({
                        title: 'Erreur',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('Erreur:', xhr, status, error);
                Swal.fire({
                    title: 'Erreur',
                    text: 'Une erreur est survenue: ' + error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
