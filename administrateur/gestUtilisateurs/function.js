$(document).ready(function() {
    $('#utilisateursTable').DataTable({
        "ajax": {
            "url": "utilisateurs.php?action=afficher",
            "dataSrc": function(json) {
                if (json.success) {
                    return json.data;
                } else {
                    Swal.fire({
                        title: 'Erreur',
                        text: json.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    return [];
                }
            },
            "error": function(xhr, error, code) {
                console.log("XHR: " + xhr);
                console.log("Error: " + error);
                console.log("Code: " + code);
                Swal.fire({
                    title: 'Erreur',
                    text: 'Erreur lors du chargement des données. Veuillez vérifier votre connexion ou contacter l\'administrateur.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "nom" },
            { "data": "prenom" },
            { "data": "email"},
            { "data": "date_arrive" },
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<a href="#" class="text-info mr-2" title="Voir info" onclick="voirInfo(event, ' + data.id + ')"><i class="fas fa-info-circle"></i></a>' +
                           '<a href="#" class="text-warning mr-2" title="Modifier" onclick="modifierUtilisateurModal(event, ' + data.id + ')"><i class="fas fa-edit"></i></a>' +
                           '<a href="#" class="text-danger" title="Supprimer" onclick="supprimerUtilisateur(event, ' + data.id + ')"><i class="fas fa-trash-alt"></i></a>';
                }
            }
        ]
    });
    $('#formAjoutUtilisateur').submit(function(event) {
        var nom = $('#nom').val();
        var prenom = $('#prenom').val();
        var email = $('#email').val();
        var mot_de_passe = $('#mot_de_passe').val();
    
        if (nom === '' || prenom === '' || email === '' || mot_de_passe === '') {
            Swal.fire('Erreur', 'Veuillez remplir tous les champs.', 'error');
            return;
        }
    
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'utilisateurs.php?action=ajouter',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Succès',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Erreur',
                        text: response.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then(function(){
                        location.reload();
                    })
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Erreur',
                    text: 'Erreur lors de l\'ajout de l\'utilisateur.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
    
    
        $('#formModifierUtilisateur').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'utilisateurs.php?action=modifier',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Succès',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Erreur',
                        text: response.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then(function(){
                        location.reload();
                    })
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Erreur',
                    text: 'Erreur lors de la modification de l\'utilisateur.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});

    function modifierUtilisateurModal(event, id) {
        event.preventDefault();
        $.ajax({
            url: 'utilisateurs.php?action=recuperer&id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var utilisateur = response.data;
                    $('#modifierId').val(utilisateur.id);
                    $('#modifierNom').val(utilisateur.nom);
                    $('#modifierPrenom').val(utilisateur.prenom);
                    $('#modifierEmail').val(utilisateur.email);
                    $('#modifierMotDePasse').val(utilisateur.mot_de_passe);
                    $('#modifierModal').modal('show');
                } else {
                    afficherErreur(response.error);
                    // location.reload()
                }
            },
            error: function() {
                afficherErreur('Erreur lors de la récupération des informations de l\'utilisateur.');
            }
        });
    }

    function supprimerUtilisateur(event, id) {
        event.preventDefault();
        console.log('Suppression de l\'utilisateur ID:', id);
        
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
                    url: 'utilisateurs.php?action=supprimer&id=' + id,
                    type: 'POST',
                    data: { action: 'supprimer', id: id },
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
                        Swal.fire('Erreur', 'Une erreur est survenue lors de la suppression.', 'error');
                    }
                });
            }
        });
    }
    
    function voirInfo(event, id) {
        event.preventDefault();
        $.ajax({
            url: 'utilisateurs.php?action=recuperer&id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var utilisateur = response.data;
                    $('#infoNom').text(utilisateur.nom);
                    $('#infoPrenom').text(utilisateur.prenom);
                    $('#infoEmail').text(utilisateur.email);
                    $('#infoDateAjout').text(utilisateur.date_arrive);
                    $('#infoModal').modal('show');
                } else {
                    afficherErreur(response.error);
                }
            },
            error: function() {
                afficherErreur('Erreur lors de la récupération des informations de l\'utilisateur.');
            }
        });
    }

    function afficherErreur(message) {
        $('#erreurMessage').text(message);
        $('#erreurModal').modal('show');
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("exporterBtn").addEventListener("click", function() {
            exporterUtilisateurs();
        });
    });
    
    function exporterUtilisateurs() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "exporter_utilisateurs.php", true);
        xhr.responseType = "blob";
        xhr.onload = function() {
            if (xhr.status === 200) {
                var blob = new Blob([xhr.response], { type: "application/vnd.openxmlformats-officedocument.wordprocessingml.document" });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "Liste_des_utilisateurs.docx";
                link.click();
            } else {
                Swal.fire({
                    title: 'Erreur',
                    text: 'Erreur lors de l\'exportation des utilisateurs.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        };
        xhr.onerror = function() {
            Swal.fire({
                title: 'Erreur',
                text: 'Erreur lors de l\'exportation des utilisateurs.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        };
        xhr.send();
    }
    