<table class="table table-striped table-hover" style="width: 100%" id="table">
  {{ $slot }}
</table>

@section("scripts")
<script>
  $(document).ready(function () {
    $('#table').DataTable({
      scrollX: true,
      dom: "Blfrtip",
      buttons: [
        { 
          extend: "excel", 
          exportOptions: {
            columns: ':not(.notexport)'
          }
        },
        {
          extend: "pdf",
          exportOptions: {
            columns: ':not(.notexport)'
          }
        },
        {
          extend: "copy",
          exportOptions: {
            columns: ':not(.notexport)'
          }
        }
      ],
      language: {
        lengthMenu: "Mostrar _MENU_ items por pagina",
        zeroRecords: "No se encontraron resultados",
        info: "Mostrando pagina _PAGE_ of _PAGES_",
        infoEmpty: "No se encontraron resultados",
        infoFiltered: "(resultado filtrado de un total de _MAX_ resultados)",
        search: "Buscar"
      },
    });
  })
</script>
@endsection