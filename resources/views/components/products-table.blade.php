<table class="table table-striped table-hover" style="width: 100%" id="table">
    {{ $slot }}
</table>

@section('scripts')
    <script>
        const meta = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        const deleteProduct = (id) => {
            fetch('/products/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(() => {
                window.location.reload();
            });
        }
        const role = "{{ Auth::user()->role }}";

        const columns = [{
                data: null,
                "defaultContent": "",
                "orderable": false,
                "render": function(data, type, row) {
                    // This is where you'll define the button or buttons to include
                    let content = '<div class="d-flex">';
                    content += `<a href="/products/${row.id}" class="btn btn-sm btn-info mx-1">Ver</a>` + `<a href="/products/${row.id}/addToCaravan" class="btn btn-sm text-nowrap btn-success">Agregar a Caravana</a>`;

                    if (row.userRole === 'admin' || row.userRole === 'moderator') {
                        content += `<a href="/products/${row.id}/edit" class="btn btn-sm btn-outline-success mx-1">Editar</a>`
                        content += `<button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDelete${row.id}">Borrar</button>`;
                        content += `<div class="modal" id="confirmDelete${row.id}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Esta seguro que desea borrar este producto?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button onclick="deleteProduct(${row.id})" class="btn btn-outline-danger">Si, borrar</button>
            </div>
        </div>
    </div>
</div>`;
                    }

                    content += '</div>';
                    return content;
                }
            }, {
                data: "id"
            },
            {
                data: "name"
            },
            {
                data: "description"
            },
            {
                data: "supplier.name",
                defaultContent: ""
            },
            {
                data: "stock"
            },
        ]

        if (role !== 'employee') {
            columns.push({
                data: "price"
            });
        }

        $(document).ready(function() {
            $(document).ready(function() {
                $('#table').DataTable({
                    "ajax": {
                        "url": "/products/search", // Replace with your API endpoint
                        "type": "GET", // or POST, depending on your API
                        "dataSrc": "",
                    },
                    "columns": columns,
                    scrollX: true,
                    dom: "Blfrtip",
                    buttons: [{
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

            $(document).ready(function() {
                $("div.dataTables_filter input").focus();
            })
        })
    </script>
@endsection
