<script src="{{ asset('admin/assets/js/jquery-3.2.1.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('admin/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('admin/assets/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/chart.morris.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('admin/assets/js/script.js') }}"></script>

<script src="{{ asset('assets/js/form-validation.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Inclure DataTables jQuery après jQuery -->
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<!-- Inclure les bibliothèques DataTables Buttons et autres -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#user, #commandes, #personnel, #client, #role, #departement, #service, #motifs, #statuts, #absences')
            .DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
        $('#filtre').on('click', function() {
            var userCheckValue = $('#userCheck').val();

            $('#commandes tbody tr').each(function() {
                var userCmdValue = $(this).find('#userCmd').val();

                if (userCmdValue === userCheckValue || userCheckValue === '') {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        const button = document.getElementById("generate_pdf");
        const filename = document.getElementById("infoFacture").value;
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;
        const filenames = filename + '-' + formattedDate

        function generatePDF() {
            // Choisissez l'élément où votre contenu sera rendu.
            const element = document.querySelector(".invoice");

            // Choisissez l'élément, définissez le nom de fichier et sauvegardez le PDF pour votre utilisateur.
            html2pdf().from(element).set({
                filename: filenames
            }).save();
        }

        button.addEventListener("click", generatePDF);
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.cancel-absence-button', function() {
            var absenceId = $(this).data('absence-id');

            $.ajax({
                type: "PUT",
                url: "{{ route('cancelAbsence', ':id') }}".replace(':id', absenceId),
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success('Votre demande d\'absence a été annulée avec succès !');
                    setTimeout(function() {
                        window.location.reload();
                    }, 3000);
                },
                error: function(error) {
                    toastr.error('L\'annulation n\'a pas pu être effectuée.');
                    console.log(error);
                }
            });
        });
    });
</script>
<script>
    $(document).on('click', '#contactMark', function(e) {
        e.preventDefault();
        var notificationId = $(this).data('id');
        var absenceId = $(this).data('absence-id');
        var markAsReadUrl = "{{ route('mark-as-read', ':id') }}";
        var redirectToUrl = $(this).attr('href');

        // Perform an AJAX request to mark the notification as read
        $.ajax({
            url: markAsReadUrl.replace(':id', notificationId),
            type: 'GET',
            success: function() {
                // After marking as read, redirect to the destination URL
                window.location.href = redirectToUrl;
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Handle the error if necessary
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Récupérez l'ID de l'absence à partir de l'URL de la route
        var urlParams = new URLSearchParams(window.location.search);
        var absenceId = urlParams.get('absence_id');

        // Affichez l'ID dans la console (facultatif)
        console.log('ID de l\'absence depuis l\'URL : ' + absenceId);

        var boutonSelector = '#bouton';

        // Gestionnaire d'événement pour le clic sur le bouton
        $(boutonSelector).on('click', function(e) {
            e.preventDefault(); // Empêche la redirection par défaut du lien

            // Récupérez l'ID de l'absence à partir de l'URL de la route
            var urlParams = new URLSearchParams(window.location.search);
            var absenceId = urlParams.get('absence_id');

            if (absenceId) {
                // L'ID de l'absence a été récupéré avec succès
                // Sélecteur du modal correspondant
                var modalSelector = '#edit_absence_details_' + absenceId;
                console.log(modalSelector);

                // Utilisez jQuery pour montrer le modal
                $(modalSelector).modal('show');
            } else {
                console.error("ID de l'absence non trouvé dans l'URL");
            }
        });
    });
</script>
