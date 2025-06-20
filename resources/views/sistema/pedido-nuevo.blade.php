@extends("plantilla")
@section('titulo', $titulo)
@section('scripts')
<script>
      globalId = '<?php echo isset($pedido->idpedido) && $pedido->idpedido > 0 ? $pedido->idpedido : 0; ?>';
      <?php $globalId = isset($pedido->idpedido) ? $pedido->idpedido : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
      <li class="breadcrumb-item"><a href="/admin/pedidos">Productos</a></li>
      <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
      <li class="btn-item"><a title="Nuevo" href="/admin/pedido/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
      <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
      </li>
      @if($globalId > 0)
      <li class="btn-item"><a title="Guardar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
      @endif
      <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
      function fsalir() {
            location.href = "/admin/pedidos";
      }
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
      echo '<div id = "msg"></div>';
      echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id = "msg"></div>
<div class="panel-body">
      <form id="form1" method="POST">
            <div class="row">
                  <div class="form-group col-lg-6">
                        <label>Seleccione cliente: *</label>
                        @if(isset($pedido) && isset($pedido->idpedido) && $pedido->idpedido > 0)
                              {{-- Edición: solo mostrar el nombre y enviar el id oculto --}}
                              @php
                                    $clienteNombre = '';
                                    foreach($aClientes as $cliente) {
                                          if($cliente->idcliente == $pedido->fk_idcliente) {
                                                $clienteNombre = $cliente->nombre;
                                                break;
                                          }
                                    }
                              @endphp
                              <input type="text" class="form-control" value="{{ $clienteNombre }}" readonly>
                              <input type="hidden" name="lstCliente" value="{{ $pedido->fk_idcliente }}">
                        @else
                              {{-- Alta: seleccionar cliente --}}
                              <select class="form-control" id="lstCliente" name="lstCliente" required>
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach($aClientes as $cliente)
                                          <option value="{{ $cliente->idcliente }}" {{ (isset($pedido) && $pedido->fk_idcliente == $cliente->idcliente) ? 'selected' : '' }}>
                                                {{ $cliente->nombre }}
                                          </option>
                                    @endforeach
                              </select>
                        @endif
                  </div>
                  <div class="form-group col-lg-6">
                        <label>Seleccione sucursal: *</label>
                        <select class="form-control" id="lstSucursal" name="lstSucursal" required>
                              <option value="" disabled {{ !isset($pedido->fk_idsucursal) ? 'selected' : '' }}>Seleccionar</option>
                              @foreach($aSucursales as $sucursal)
                              <option value="{{ $sucursal->idsucursal }}"
                                  {{ (isset($pedido->fk_idsucursal) && $pedido->fk_idsucursal == $sucursal->idsucursal) ? 'selected' : '' }}>
                                  {{ $sucursal->nombre }}
                              </option>
                        @endforeach
                        </select>
                  </div>
                  <div class="form-group col-lg-6">
                        <label>Seleccione estado del pedido: *</label>
                        <select class="form-control" id="lstEstadoPedido" name="lstEstadoPedido" required>
                            <option value="" disabled>Seleccionar</option>
                            @foreach($aEstadoPedidos as $estado_pedido)
                                <option value="{{ $estado_pedido->idestadopedido }}"
                                    {{ (isset($pedido->fk_idestadopedido) && $pedido->fk_idestadopedido == $estado_pedido->idestadopedido) ? 'selected' : '' }}>
                                    {{ $estado_pedido->nombre }}
                                </option>
                            @endforeach
                        </select>
                  </div>
                  <div class="form-group col-lg-6">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                        <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                        <label>Fecha: *</label>
                        <input type="datetime-local" id="txtFecha" name="txtFecha" class="form-control" value="{{ old('txtFecha', $pedido->fecha ? date('Y-m-d\TH:i', strtotime($pedido->fecha)) : '') }}" required>
                  </div>
                  <div class="form-group col-lg-6">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                        <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                        <label>Total: *</label>
                        <input type="text" id="txtTotal" name="txtTotal" class="form-control" value="{{ $pedido->total }}" required>
                  </div>
            </div>
      </form>
      <script>
      function guardar() {
            $("#form1").validate();
            if ($("#form1").valid()) {
                  modificado = false;
                  form1.submit();
            } else {
                  $("#modalGuardar").modal('toggle');
                  msgShow("Corrija los errores e intente nuevamente.", "danger");
                  return false;
            }
      }
      </script>
      <script>
      function eliminar() {
            $('#mdlEliminar').modal('toggle');
            $.ajax({
                  type: "GET",
                  url: "{{ asset('admin/pedido/eliminar') }}",
                  data: {
                        id: globalId
                  },
                  async: true,
                  dataType: "json",
                  success: function(data) {
                              if (data.err = "0") {
                                    msgShow(data.mensaje, "success");
                                    $("#btnEnviar").hide();
                                    $("#btnEliminar").hide();
                                    $('#mdlEliminar').modal('toggle');
                              } else {
                                    msgShow(data.mensaje, "danger");
                                    $('#mdlEliminar').modal('toggle');
                              }
                  }
            });
      }
      </script>
@endsection