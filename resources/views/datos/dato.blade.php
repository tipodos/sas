@extends('layouts.template')
@section('title', 'Datos de la Empresa')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm overflow-hidden mb-4">
                    <div class="card-header bg-primary py-4 text-center">
                        <div class="position-relative d-inline-block shadow-sm p-2 bg-white rounded-circle">
                            @if ($datos->logo)
                                <img src="{{ asset('storage/' . $datos->logo) }}" id="preview" class="rounded-circle"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div id="no-logo-placeholder"
                                    class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 120px; height: 120px;">
                                    <i class="fas fa-store fa-3x text-muted"></i>
                                </div>
                                <img src="" id="preview" class="rounded-circle d-none"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold mb-1 text-dark">{{ $datos->nombre_empresa }}</h4>
                            <span class="badge bg-light text-secondary border">RUC: {{ $datos->ruc_empresa }}</span>
                        </div>

                        <div class="list-group list-group-flush small">
                            <div class="list-group-item px-0 border-0 d-flex align-items-center">
                                <div class="bg-light-primary text-primary rounded-3 p-2 me-3">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Teléfono</small>
                                    <span class="fw-bold">{{ $datos->telefono ?? 'No registrado' }}</span>
                                </div>
                            </div>

                            <div class="list-group-item px-0 border-0 d-flex align-items-center">
                                <div class="bg-light-primary text-primary rounded-3 p-2 me-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Dirección</small>
                                    <span class="fw-bold">{{ $datos->direccion_empresa ?? 'No registrado' }}</span>
                                </div>
                            </div>

                            <div class="list-group-item px-0 border-0 d-flex align-items-center">
                                <div class="bg-light-primary text-primary rounded-3 p-2 me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Correo Electrónico</small>
                                    <span class="fw-bold text-truncate"
                                        style="max-width: 200px;">{{ $datos->correo ?? 'No registrado' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-light rounded-3 border-start border-primary border-4">
                            <small class="text-muted d-block fw-bold mb-1" style="font-size: 10px;">
                                <i class="fas fa-receipt me-1"></i> MENSAJE FINAL DEL TICKET:
                            </small>
                            <p class="fst-italic small mb-0 text-dark">
                                "{{ $datos->mensaje_ticket ?? 'Gracias por su compra' }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                /* Un toque de color suave para los fondos de los iconos */
                .bg-light-primary {
                    background-color: rgba(13, 110, 253, 0.1);
                    width: 35px;
                    height: 35px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .border-dashed {
                    border-style: dashed !important;
                }
            </style>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-cog me-2"></i>Configuración General</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('datos.update', $datos->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $datos->id }}">

                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label class="form-label fw-bold small text-primary">CAMBIAR LOGO</label>
                                    <input type="file" name="logo" id="logoInput" class="form-control"
                                        accept="image/*">
                                    <div class="form-text">Formatos permitidos: PNG, JPG. Máximo 2MB.</div>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold small">Nombre de la Empresa</label>
                                    <input type="text" name="nombre_empresa" class="form-control"
                                        value="{{ $datos->nombre_empresa }}" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold small">RUC</label>
                                    <input type="text" name="ruc_empresa" class="form-control"
                                        value="{{ $datos->ruc_empresa }}" maxlength="11" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold small">Dirección Fiscal</label>
                                    <input type="text" name="direccion_empresa" class="form-control"
                                        value="{{ $datos->direccion_empresa }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Teléfono / WhatsApp</label>
                                    <input type="text" name="telefono" class="form-control"
                                        value="{{ $datos->telefono }}" maxlength="9">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Correo Electrónico</label>
                                    <input type="email" name="correo" class="form-control" value="{{ $datos->correo }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold small">Mensaje al final del Ticket</label>
                                    <textarea name="mensaje_ticket" class="form-control" rows="2">{{ $datos->mensaje_ticket }}</textarea>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold small">Moneda</label>
                                    <input type="text" name="moneda" class="form-control"
                                        value="{{ $datos->moneda }}">
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                                    <i class="fas fa-save me-1"></i> Guardar Configuración
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script para previsualizar el logo antes de subirlo
        document.getElementById('logoInput').onchange = function(evt) {
            const [file] = this.files
            if (file) {
                const preview = document.getElementById('preview');
                const placeholder = document.getElementById('no-logo-placeholder');

                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            }
        }
    </script>
@endsection
