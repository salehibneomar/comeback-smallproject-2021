
<script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

<script>

    $(document).ready(function() {
        $('#server-side-dt').DataTable({
            "processing": true,
			"language": {
                "processing": "Loading..."
            },
            "serverSide": true,
            "ajax": "data_tables/get-all-todo.php",
            "pageLength": 5,
            "lengthMenu": [5, 10, 15]
        });

        $('#sort-by').on('change', function (){
            this.submit();
        });
    });

</script>

</body>
</html>

<?php
    ob_end_flush();
?>