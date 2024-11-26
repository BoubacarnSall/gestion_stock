$(document).ready(function() {
    $('#materiels').DataTable();
    // chargerMateriels();
});
function ajouterMateriel() {
    var form = $('#formAjoutMateriel');
    var nom = $('#nom').val();
    var descriptions = $('#descriptions').val();
    var quantite = $('#quantite').val();

    if (nom === '' || descriptions === '' || quantite === '') {
        Swal.fire('Erreur', 'Veuillez remplir tous les champs.', 'error');
        return;
    }

    console.log('Données du formulaire:', form.serialize());
    $.ajax({
        url: 'materiels.php',
        type: 'POST',
        data: form.serialize() + '&action=ajouter',
        success: function(response) {
            console.log('Réponse AJAX:', response);
            location.reload();
            if (response.success) {
                $('#ajouter').modal('hide');
                form.trigger('reset');
                // location.reload();
                Swal.fire('Succès', response.message, 'success');
                // chargerMateriels();
                
            } else {
                Swal.fire('Erreur', response.error, 'error');
            }
        },
        error: function() {
            Swal.fire('Erreur', 'Une erreur est survenue lors de l\'ajout du matériel.', 'error');
        }
    });
}
function modifierMaterielModal(event, id) {
    event.preventDefault();
    console.log('Modification du matériel ID:', id);
    $.ajax({
        url: 'materiels.php',
        type: 'GET',
        data: { action: 'recuperer', id: id },
        success: function(response) {
            console.log('Réponse récupération:', response);
    
            if (response.success) {
                var materiel = response.data;
                $('#modifierId').val(materiel.id);
                $('#modifierNom').val(materiel.nom);
                $('#modifierDescription').val(materiel.descriptions);
                $('#modifierQuantite').val(materiel.quantite);
                $('#modifier').modal('show');
                
            } else {
                Swal.fire('Erreur', response.error, 'error');
            }
        },
        error: function() {
            Swal.fire('Erreur', 'Une erreur est survenue lors de la récupération des informations du matériel.', 'error');
        }
    });
}

function modifierMateriel() {
    var form = $('#formModifierMateriel');
    console.log('Données du formulaire de modification:', form.serialize());
    $.ajax({
        url: 'materiels.php',
        type: 'POST',
        data: form.serialize() + '&action=modifier',
        success: function(response) {
            console.log('Réponse modification:', response);
            if (response.success) {
                $('#modifier').modal('hide');
                form.trigger('reset');
                Swal.fire('Succès', response.message, 'success');
                location.reload();
                chargerMateriels();
            } else {
                Swal.fire('Erreur', response.error, 'error');
            }
        },
        error: function() {
            Swal.fire('Erreur', 'Une erreur est survenue lors de la modification du matériel.', 'error');
        }
    });
}
function supprimerMateriel(event, id) {
    event.preventDefault();
    console.log('Suppression du matériel ID:', id);
    
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Cette action est irréversible!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, supprimer!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: 'materiels.php',
                type: 'POST',
                data: { action: 'supprimer', id: id },
                dataType: 'json',
                success: function(response) {
                    console.log('Réponse suppression:', response);
                    if (response.success) {
                    
                        Swal.fire('Supprimé!', response.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Erreur', response.error, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Erreur', 'Une erreur est survenue lors de la suppression du matériel.', 'error');
                }
            });
        }
    });
}
function voirInfo(event, id) {
    event.preventDefault();
    console.log('Visualisation des informations pour le matériel ID:', id);
    $.ajax({
        url: 'materiels.php',
        type: 'GET',
        data: { action: 'recuperer', id: id },
        success: function(response) {
            console.log('Réponse récupération info:', response);
            if (response.success) {
                var materiel = response.data;
                $('#infoNom').text(materiel.nom);
                $('#infoDescription').text(materiel.descriptions);
                $('#infoQuantite').text(materiel.quantite);
                $('#infoDateAjout').text(materiel.date_arrive);
                $('#voirInfoModal').modal('show');
            } else {
                Swal.fire('Erreur', response.error, 'error');
            }
        },
        error: function() {
            Swal.fire('Erreur', 'Une erreur est survenue lors de la récupération des informations du matériel.', 'error');
        }
    });
}
