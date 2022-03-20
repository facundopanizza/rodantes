<table class="table table-striped table-hover" style="width: 100%" id="table">
  {{ $slot }}
</table>

@section("scripts")
<script>
  $(document).ready(function() {
    $(document).ready(function () {
      $('#table').DataTable({
        scrollX: true,
        dom: "Blfrtip",
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
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
            text: "Copiar",
            exportOptions: {
              columns: ':not(.notexport)'
            }
          }
        ],
        language: {
          lengthMenu: "Mostrar _MENU_ resultados por pagina",
          zeroRecords: "No se encontraron resultados",
          info: "Mostrando pagina _PAGE_ de _PAGES_",
          infoEmpty: "No se encontraron resultados",
          infoFiltered: "(resultado filtrado de un total de _MAX_ resultados)",
          search: "Buscar",
          paginate: {
            next: "Siguiente",
            previous: "Atras"
          }
        },
      });
    })

    $(document).ready(function () {
      $("div.dataTables_filter input").focus();
    })
  })
</script>
@endsection