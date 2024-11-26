function ajouterUtilisateur() {
    var nom = $("#nom").val();
    var prenom = $("#prenom").val();
    var email = $("#email").val();
    var motDePasse = $("#motDePasse").val();

    if (nom && prenom && email && motDePasse) {
        console.log("Utilisateur ajouté : ", nom, prenom, email);
        $("#ajouterModal").modal('hide');
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Veuillez remplir tous les champs.'
        });
    }
}
$(document).ready(function() {
    $('#ordertable').DataTable();
});