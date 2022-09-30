var app = new Vue({
    el: "#app",
    data: {
        title: "Pedidos",
        datos: [],
        filtros: {
            fecha: null,
        },
        modal_data: {
            title: null,
            content: {
                disponibles: [],
                proveedores: [],
            },
        },
    },
    methods: {
        getIndex() {
            let url = "api/pedidos";
            axios
                .get(url, {
                    params: this.filtros,
                })
                .then((response) => {
                    this.datos = response.data;
                })
                .catch((e) => {
                    toastr.error(e.message, "Error");
                });
        },

        getModalData(datos) {
            this.modal_data.title = `Detalle pedido ${
                datos.cliente ? datos.cliente.nombre : "Sin Cliente Definido"
            } - ${datos.fecha}`;
            this.verificarDisponibilidad(datos.productos);
        },

        verificarDisponibilidad(productos) {
            this.modal_data.content.disponibles = [];
            this.modal_data.content.proveedores = [];
            productos.forEach((prod) => {
                let cant_disponible = 0;
                let proveedores = [];
                prod.inventario.forEach((inv) => {
                    cant_disponible += inv.pivot.cantidad;
                    proveedores.push(inv.nombre);
                });

                let cant_pedido = prod.pivot.cantidad;
                this.modal_data.content.disponibles.push({
                    id: prod.id,
                    producto: prod.nombre,
                    cant_pedido,
                    cant_disponible,
                });

                if (cant_pedido > cant_disponible) {
                    this.modal_data.content.proveedores.push({
                        producto: prod.nombre,
                        proveedores,
                        cant_pendiente: cant_pedido - cant_disponible,
                    });
                }
            });
        },
    },
    mounted() {
        this.getIndex();
    },
});
