@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>@{{ title }}</h5>
                            </div>
                            <div class="col-md-4">
                                <label>Buscar en fecha</label>
                                <input 
                                    type="date" 
                                    class="form-control form-control-sm"
                                    v-model="filtros.fecha"
                                    v-on:input="getIndex"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table v-if="datos.length > 0" class="table table-sm text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Cant. Productos</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="dato in datos">
                                    <td class="text-center">@{{ dato.id }}</td>
                                    <td class="text-center">@{{ dato.fecha }}</td>
                                    <td>@{{ dato.cliente ? dato.cliente.nombre : "" }}</td>
                                    <td class="text-center">@{{ dato.productos.length }}</td>
                                    <td>
                                        <button 
                                            type="button" 
                                            class="btn btn-primary btn-sm" 
                                            data-toggle="modal"
                                            data-target="#modal-detalle" 
                                            v-on:click="getModalData(dato)"
                                        >Ver</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-else class="alert alert-warning" role="alert">
                            No hay pedidos para entregar.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-detalle" tabindex="-1" aria-labelledby="modal-detalleLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header p-2">
                        <h5 class="modal-title" id="modal-detalleLabel">@{{ modal_data.title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="row">
                            <div class="col-md-6 table-responsive">
                                <h5>Pedido</h5>
                                <table v-if="modal_data.content.disponibles.length > 0" class="table table-bordered table-sm text-nowrap">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Pedido</th>
                                            <th scope="col">Disponible</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="producto in modal_data.content.disponibles">
                                        <tr :class="producto.cant_pedido > producto.cant_disponible ? 'table-danger' : ''">
                                            <td>@{{ producto.producto }}</td>
                                            <td class="text-center">@{{ producto.cant_pedido }}</td>
                                            <td class="text-center">@{{ producto.cant_disponible }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="alert alert-warning" role="alert">
                                    No hay productos para este pedido.
                                </div>
                            </div>
                            <div class="col-md-6 table-responsive">
                                <h5>Proveedores</h5>
                                <table v-if="modal_data.content.proveedores.length > 0" class="table table-bordered table-sm text-nowrap">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th scope="col">Producto</th>
                                            <th scope="col">Cantidad Pendiente</th>
                                            <th scope="col">Proveedores</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="proveedor in modal_data.content.proveedores">
                                        <tr>
                                            <td>@{{ proveedor.producto }}</td>
                                            <td class="text-center">@{{ proveedor.cant_pendiente }}</td>
                                            <td class="text-center">
                                                <div v-for="prov in proveedor.proveedores">
                                                    @{{ prov }}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-else class="alert alert-info" role="alert">
                                    No es necesario contactar a los proveedores.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
