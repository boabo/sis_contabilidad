<?php
/**
 * @package pXP
 * @file RegFacturasXFuncionario.php
 * @author  breydi vasquez
 * @date 07-05-2020
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.RegFacturasXFuncionario = Ext.extend(Phx.gridInterfaz, {
        fheight: '80%',
        fwidth: '70%',
        tabEnter: true,
        tipoDoc: 'compra',
        regitrarDetalle: 'si',
        constructor: function (config) {
            this.initButtons = [this.cmbDepto,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', this.cmbGestion, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
            this.cmbPeriodo, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'];
            var me = this;

            this.Atributos = [
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_doc_compra_venta'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'tipo'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'porc_descuento_ley',
                        allowDecimals: true,
                        decimalPrecision: 10
                    },
                    type: 'NumberField',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'porc_iva_cf',
                        allowDecimals: true,
                        decimalPrecision: 10
                    },
                    type: 'NumberField',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'porc_iva_df',
                        allowDecimals: true,
                        decimalPrecision: 10
                    },
                    type: 'NumberField',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'porc_it',
                        allowDecimals: true,
                        decimalPrecision: 10
                    },
                    type: 'NumberField',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'porc_ice',
                        allowDecimals: true,
                        decimalPrecision: 10
                    },
                    type: 'NumberField',
                    form: true
                },
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_depto_conta'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'revisado',
                        fieldLabel: 'Revisado',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 80,
                        maxLength: 3,
                        renderer: function (value, p, record, rowIndex, colIndex) {
                            var checked = '',
                                state = 'disabled',
                                momento = 'no';
                            if (value == 'si') {
                                checked = 'checked';
                            }

                            if (record.data.tipo_reg != 'summary') {
                                return String.format('<div style="vertical-align:middle;text-align:center;"><input style="height:37px;width:37px;" type="checkbox"  {0} {1}></div>', checked, state);
                            }
                            else {
                                return '';
                            }
                        }
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.revisado', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'nit',
                        fieldLabel: 'NIT',
                        qtip: 'Número de indentificación del proveedor',
                        allowBlank: false,
                        emptyText: 'nit ...',
                        store: new Ext.data.JsonStore(
                            {
                                url: '../../sis_contabilidad/control/DocCompraVenta/listarNroNit',
                                id: 'nit',
                                root: 'datos',
                                sortInfo: {
                                    field: 'nit',
                                    direction: 'ASC'
                                },
                                totalProperty: 'total',
                                fields: ['nit', 'razon_social'],
                                remoteSort: true
                            }),
                        valueField: 'nit',
                        hiddenValue: 'nit',
                        displayField: 'nit',
                        gdisplayField: 'nit',
                        queryParam: 'nit',
                        listWidth: '280',
                        forceSelection: false,
                        autoSelect: false,
                        typeAhead: false,
                        typeAheadDelay: 75,
                        hideTrigger: true,
                        triggerAction: 'query',
                        lazyRender: false,
                        mode: 'remote',
                        pageSize: 20,
                        queryDelay: 500,
                        gwidth: 100,
                        minChars: 1
                    },
                    type: 'ComboBox',
                    filters: {pfiltro: 'dcv.nit', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    bottom_filter: true,
                    form: false
                },
                {
                    config: {
                        name: 'nro_documento',
                        fieldLabel: 'Nro Doc.',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.nro_documento', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    bottom_filter: true,
                    form: false
                },
                {
                    config: {
                        name: 'nro_autorizacion',
                        fieldLabel: 'Autorización',
                        allowBlank: false,
                        emptyText: 'autorización ...',
                        store: new Ext.data.JsonStore(
                            {
                                url: '../../sis_contabilidad/control/DocCompraVenta/listarNroAutorizacion',
                                id: 'nro_autorizacion',
                                root: 'datos',
                                sortInfo: {
                                    field: 'nro_autorizacion',
                                    direction: 'ASC'
                                },
                                totalProperty: 'total',
                                fields: ['nro_autorizacion', 'nit', 'razon_social'],
                                remoteSort: true
                            }),
                        valueField: 'nro_autorizacion',
                        hiddenValue: 'nro_autorizacion',
                        displayField: 'nro_autorizacion',
                        gdisplayField: 'nro_autorizacion',
                        queryParam: 'nro_autorizacion',
                        listWidth: '280',
                        forceSelection: false,
                        autoSelect: false,
                        hideTrigger: true,
                        typeAhead: false,
                        typeAheadDelay: 75,
                        //triggerAction: 'query',
                        lazyRender: false,
                        mode: 'remote',
                        pageSize: 20,
                        queryDelay: 500,
                        gwidth: 150,
                        minChars: 1
                    },
                    type: 'ComboBox',
                    filters: {pfiltro: 'dcv.nro_autorizacion', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    bottom_filter: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha',
                        fieldLabel: 'Fecha',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        readOnly: true,
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'dcv.fecha', type: 'date'},
                    id_grupo: 0,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_vencimiento',
                        fieldLabel: 'Fecha de Vencimiento de la Deuda',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        readOnly: true,
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'dcv.fecha_vencimiento', type: 'date'},
                    id_grupo: 0,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'razon_social',
                        fieldLabel: 'Razón Social',
                        allowBlank: false,
                        //maskRe: /[A-Za-z0-9 ]/,
                        //fieldStyle: 'text-transform:uppercase',
                        style: 'text-transform:uppercase;',
                        listeners: {
                            'change': function (field, newValue, oldValue) {
                                console.log('keyup ...  ')
                                field.suspendEvents(true);
                                field.setValue(newValue.toUpperCase());
                                field.resumeEvents(true);
                            }
                        },
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 180
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.razon_social', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    bottom_filter: true,
                    form: false
                },
                {
                    config: {
                        name: 'codigo_control',
                        fieldLabel: 'Código de Control',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 200
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.codigo_control', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_doc',
                        fieldLabel: 'Monto',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 80,
                        galign: 'right ',
                        maxLength: 1179650,
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                Ext.util.Format.usMoney
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_doc', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_excento',
                        fieldLabel: 'Exento',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_excento', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_descuento',
                        fieldLabel: 'Descuento',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_descuento', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_neto',
                        fieldLabel: 'Importe c/d',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        maxLength: 1179650,
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_doc', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_aux_neto',
                        fieldLabel: 'Neto',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        maxLength: 1179650,
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_iva',
                        fieldLabel: 'IVA',
                        allowBlank: true,
                        readOnly: true,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_iva', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_pago_liquido',
                        fieldLabel: 'Líquido Pagado',
                        allowBlank: true,
                        readOnly: true,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_pago_liquido', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_plantilla',
                        fieldLabel: 'Tipo Documento',
                        allowBlank: false,
                        emptyText: 'Elija una plantilla...',
                        store: new Ext.data.JsonStore(
                            {
                                url: '../../sis_parametros/control/Plantilla/listarPlantilla',
                                id: 'id_plantilla',
                                root: 'datos',
                                sortInfo: {
                                    field: 'desc_plantilla',
                                    direction: 'ASC'
                                },
                                totalProperty: 'total',
                                fields: ['id_plantilla', 'nro_linea', 'desc_plantilla', 'tipo',
                                    'sw_tesoro', 'sw_compro', 'sw_monto_excento', 'sw_descuento',
                                    'sw_autorizacion', 'sw_codigo_control', 'tipo_plantilla', 'sw_nro_dui', 'sw_ice'],
                                remoteSort: true,
                                baseParams: {par_filtro: 'plt.desc_plantilla', sw_compro: 'si', sw_tesoro: 'si'}
                            }),
                        tpl: '<tpl for="."><div class="x-combo-list-item"><p>{desc_plantilla}</p></div></tpl>',
                        valueField: 'id_plantilla',
                        hiddenValue: 'id_plantilla',
                        displayField: 'desc_plantilla',
                        gdisplayField: 'desc_plantilla',
                        listWidth: '280',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 20,
                        queryDelay: 500,
                        gwidth: 250,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            var color = 'black';
                            if (record.data.tabla_origen != 'ninguno') {
                                color = 'blue';
                            }
                            return String.format("<b><font color='{0}'>{1}</font></b>", color, record.data['desc_plantilla']);
                        }
                    },
                    type: 'ComboBox',
                    filters: {pfiltro: 'pla.desc_plantilla', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    bottom_filter: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_tipo_doc_compra_venta',
                        fieldLabel: (me.tipoDoc == 'compra') ? 'Tipo Compra' : 'Estado',
                        allowBlank: false,
                        emptyText: 'tipo...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_contabilidad/control/TipoDocCompraVenta/listarTipoDocCompraVenta',
                            id: 'id_tipo_doc_compra_venta',
                            root: 'datos',
                            sortInfo: {
                                field: 'id_tipo_doc_compra_venta',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_tipo_doc_compra_venta', 'codigo', 'nombre', 'obs', 'tipo'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'nombre', tipo: me.tipoDoc}
                        }),
                        tpl: '<tpl for="."><div class="x-combo-list-item"><p>{codigo} - {nombre}</p></div></tpl>',
                        valueField: 'id_tipo_doc_compra_venta',
                        hiddenName: 'id_tipo_doc_compra_venta',
                        editable: false,
                        displayField: 'nombre',
                        gdisplayField: 'desc_tipo_doc_compra_venta',
                        listWidth: '280',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 20,
                        queryDelay: 500,
                        gwidth: (me.tipoDoc == 'compra') ? 250 : 100,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['desc_tipo_doc_compra_venta']);
                        }
                    },
                    type: 'ComboBox',
                    filters: {pfiltro: 'tdcv.nombre', type: 'string'},
                    id_grupo: 1,
                    egrid: true,
                    grid: true,
                    bottom_filter: true,
                    form: false
                },
                {
                    config: {
                        name: 'desc_comprobante',
                        fieldLabel: 'Cbte',
                        allowBlank: false,
                        gwidth: 100
                    },
                    type: 'Field',
                    filters: {pfiltro: 'ic.id_int_comprobante#ic.nro_cbte', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'c31',
                        fieldLabel: 'C31-SIGEP',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    id_grupo: 0,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_int_comprobante',
                        fieldLabel: 'Id Int Comprobante',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    id_grupo: 0,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'nro_tramite',
                        fieldLabel: 'Nro Trámite',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'ic.nro_tramite', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    bottom_filter: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_moneda',
                        origen: 'MONEDA',
                        allowBlank: false,
                        fieldLabel: 'Moneda',
                        gdisplayField: 'desc_moneda',//mapea al store del grid
                        gwidth: 70,
                        width: 250,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['desc_moneda']);
                        }
                    },
                    type: 'ComboRec',
                    id_grupo: 0,
                    filters: {
                        pfiltro: 'incbte.desc_moneda',
                        type: 'string'
                    },
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'dia',
                        fieldLabel: 'Día',
                        allowBlank: true,
                        allowNEgative: false,
                        allowDecimal: false,
                        maxValue: 31,
                        minValue: 1,
                        width: 40,
                        gwidth: 100
                    },
                    type: 'NumberField',
                    id_grupo: 0,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'nro_dui',
                        fieldLabel: 'DUI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 16,
                        minLength: 9
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.nro_dui', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'obs',
                        fieldLabel: 'Observaciones',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 400
                    },
                    type: 'TextArea',
                    filters: {pfiltro: 'dcv.obs', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    bottom_filter: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_pendiente',
                        fieldLabel: 'Cuenta Pendiente',
                        qtip: 'Usualmente una cuenta pendiente de  cobrar o  pagar (dependiendo si es compra o venta), posterior a la emisión del documento',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_pendiente', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_anticipo',
                        fieldLabel: 'Anticipo',
                        qtip: 'Importe pagado por anticipado al documento',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_anticipo', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_retgar',
                        fieldLabel: 'Ret. Garantía',
                        qtip: 'Importe retenido por garantia',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_retgar', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_descuento_ley',
                        fieldLabel: 'Descuentos de Ley',
                        allowBlank: true,
                        readOnly: true,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_descuento_ley', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_ice',
                        fieldLabel: 'ICE',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_ice', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'importe_it',
                        fieldLabel: 'IT',
                        allowBlank: true,
                        anchor: '80%',
                        readOnly: true,
                        gwidth: 100,
                        galign: 'right ',
                        renderer: function (value, p, record) {
                            if (record.data.tipo_reg != 'summary') {
                                return String.format('{0}', Ext.util.Format.number(value, '0,000.00'));
                            }
                            else {
                                return String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value, '0,000.00'));
                            }
                        }
                    },
                    type: 'NumberField',
                    filters: {pfiltro: 'dcv.importe_it', type: 'numeric'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'estado',
                        fieldLabel: 'Estado',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 30
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.estado', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'sw_contabilizar',
                        fieldLabel: 'Contabilizar',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 3
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.sw_contabilizar', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'nombre_auxiliar',
                        fieldLabel: 'Cuenta Corriente',
                        allowBlank: false,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 180,
                        renderer: function (value, p, record) {
                            if (value) {
                                return String.format('({0}) - {1}', record.data.codigo_auxiliar, record.data.nombre_auxiliar);
                            }
                        }
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'aux.codigo_auxiliar#aux.nombre_auxiliar', type: 'string'},
                    id_grupo: 0,
                    grid: true,
                    bottom_filter: true,
                    form: false
                },
                {
                    config: {
                        name: 'estacion',
                        fieldLabel: 'Estación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 16,
                        minLength: 16
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.estacion', type: 'string'},
                    id_grupo: 0,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'nombre',
                        fieldLabel: 'IATA/No IATA',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 200,
                        maxLength: 16,
                        minLength: 16
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'ob.nombre', type: 'string'},
                    id_grupo: 0,
                    bottom_filter: true,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'codigo_noiata',
                        fieldLabel: 'Cod NO IATA',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 16,
                        minLength: 16
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'age.codigo_noiata', type: 'string'},
                    id_grupo: 0,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'codigo_int',
                        fieldLabel: 'OficceId',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 16,
                        minLength: 16
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'ob.codigo_int', type: 'string'},
                    id_grupo: 0,
                    bottom_filter: true,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu1.cuenta', type: 'string'},
                    id_grupo: 1,
                    bottom_filter: true,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'dcv.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: '',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'dcv.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu2.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'dcv.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 300
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'dcv.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],

            //llama al constructor de la clase padre
            Phx.vista.RegFacturasXFuncionario.superclass.constructor.call(this, config);

            this.bloquearOrdenamientoGrid();

            this.cmbGestion.on('select', function (combo, record, index) {
                this.tmpGestion = record.data.gestion;
                this.cmbPeriodo.enable();
                this.cmbPeriodo.reset();
                this.store.removeAll();
                this.cmbPeriodo.store.baseParams = Ext.apply(this.cmbPeriodo.store.baseParams, {id_gestion: this.cmbGestion.getValue()});
                this.cmbPeriodo.modificado = true;
            }, this);

            this.cmbPeriodo.on('select', function (combo, record, index) {
                this.tmpPeriodo = record.data.periodo;
                this.capturaFiltros();
            }, this);

            this.cmbDepto.on('select', function (combo, record, index) {
                this.capturaFiltros();
            }, this);

            // botones
            this.addButton('btnFacturasAdju', {
                text: 'Adjuntar Archivo',
                iconCls: 'bfolder',
                disabled: false,
                handler: this.onSeeFacture,
                tooltip: '<b>Adjuntar Archivo</b><br><b>Nos permite adjuntar documentos de un funcionario.</b>'
            });

            this.init();
            this.obtenerVariableGlobal();
            console.log('datos de inicio',this);
            // this.tbar.items.items[2].setValue(19);
            // this.tbar.items.items[2].setRawValue('2020');

        },

        onSeeFacture: function () {

            var rec = this.getSelectedData();
            rec.datos_extras_id = rec.id_doc_compra_venta;

            Phx.CP.loadWindows('../../../sis_contabilidad/vista/doc_compra_venta/ArchivoFactura.php',
                'Archivo',
                {
                    width: '60%',
                    height: '70%',
                    modal:true,
                }, rec, this.idContenedor, 'ArchivoFactura');

        },

        obtenerVariableGlobal: function () {
            //Verifica que la fecha y la moneda hayan sido elegidos
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_seguridad/control/Subsistema/obtenerVariableGlobal',
                params: {
                    codigo: 'conta_libro_compras_detallado'
                },
                success: function (resp) {
                    Phx.CP.loadingHide();
                    var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
                    if (reg.ROOT.error) {
                        Ext.Msg.alert('Error', 'Error a recuperar la variable global')
                    } else {
                        if (reg.ROOT.datos.valor == 'no') {
                            this.regitrarDetalle = 'no';
                        }
                    }
                },
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        capturaFiltros: function (combo, record, index) {
            this.desbloquearOrdenamientoGrid();
            if (this.validarFiltros()) {
                this.store.baseParams.id_gestion = this.cmbGestion.getValue();
                this.store.baseParams.id_periodo = this.cmbPeriodo.getValue();
                this.store.baseParams.id_depto = this.cmbDepto.getValue();
                this.load();
            }
        },
        validarFiltros: function () {
            if (this.cmbDepto.getValue() && this.cmbGestion.validate() && this.cmbPeriodo.validate()) {
                this.desbloquearOrdenamientoGrid();
                return true;
            }
            else {
                this.bloquearOrdenamientoGrid();
                return false;
            }
        },
        onButtonAct: function () {
            if (!this.validarFiltros()) {
                alert('Especifique los filtros antes')
            }
        },
        cmbDepto: new Ext.form.ComboBox({
            name: 'id_depto',
            fieldLabel: 'Depto',
            blankText: 'Depto',
            typeAhead: false,
            forceSelection: true,
            allowBlank: false,
            disableSearchButton: true,
            emptyText: 'Depto Contable',
            store: new Ext.data.JsonStore({
                url: '../../sis_contabilidad/control/DocCompraVenta/listarDeptoFiltradoDeptoUsuarioConta',
                id: 'id_depto',
                root: 'datos',
                sortInfo: {
                    field: 'deppto.nombre',
                    direction: 'ASC'
                },
                totalProperty: 'total',
                fields: ['id_depto', 'nombre', 'codigo'],
                // turn on remote sorting
                remoteSort: true,
                baseParams: {
                    par_filtro: 'deppto.nombre#deppto.codigo',
                    estado: 'activo',
                    codigo_subsistema: 'CONTA',
                    //_adicionar: 'no'
                }
            }),
            valueField: 'id_depto',
            displayField: 'nombre',
            hiddenName: 'id_depto',
            enableMultiSelect: true,
            triggerAction: 'all',
            lazyRender: true,
            mode: 'remote',
            pageSize: 20,
            queryDelay: 200,
            anchor: '80%',
            listWidth: '280',
            resizable: true,
            minChars: 2
        }),
        cmbGestion: new Ext.form.ComboBox({
            fieldLabel: 'Gestion',
            allowBlank: false,
            emptyText: 'Gestion...',
            blankText: 'Año',
            store: new Ext.data.JsonStore(
                {
                    url: '../../sis_parametros/control/Gestion/listarGestion',
                    id: 'id_gestion',
                    root: 'datos',
                    sortInfo: {
                        field: 'gestion',
                        direction: 'DESC'
                    },
                    totalProperty: 'total',
                    fields: ['id_gestion', 'gestion'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams: {par_filtro: 'gestion'}
                }),
            valueField: 'id_gestion',
            triggerAction: 'all',
            displayField: 'gestion',
            hiddenName: 'id_gestion',
            mode: 'remote',
            pageSize: 3,
            queryDelay: 500,
            resizable:true,
            listWidth: '250',
            width: 80
        }),
        cmbPeriodo: new Ext.form.ComboBox({
            fieldLabel: 'Periodo',
            allowBlank: false,
            blankText: 'Mes',
            emptyText: 'Periodo...',
            store: new Ext.data.JsonStore(
                {
                    url: '../../sis_parametros/control/Periodo/listarPeriodo',
                    id: 'id_periodo',
                    root: 'datos',
                    sortInfo: {
                        field: 'periodo',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_periodo', 'periodo', 'id_gestion', 'literal'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams: {par_filtro: 'gestion'}
                }),
            valueField: 'id_periodo',
            triggerAction: 'all',
            displayField: 'literal',
            hiddenName: 'id_periodo',
            mode: 'remote',
            pageSize: 50,
            disabled: true,
            queryDelay: 500,
            listWidth: '280',
            width: 80
        }),
        tam_pag: 50,
        title: 'Registro de Facturas',
        ActDel: '../../sis_contabilidad/control/DocCompraVenta/eliminarDocCompraVenta',
        ActList: '../../sis_contabilidad/control/DocCompraVenta/listarFacturasXFuncionario',
        id_store: 'id_doc_compra_venta',
        fields: [
            {name: 'id_doc_compra_venta', type: 'string'},
            {name: 'revisado', type: 'string'},
            {name: 'movil', type: 'string'},
            {name: 'tipo', type: 'string'},
            {name: 'importe_excento', type: 'numeric'},
            {name: 'id_plantilla', type: 'numeric'},
            {name: 'fecha', type: 'date', dateFormat: 'Y-m-d'},
            {name: 'nro_documento', type: 'string'},
            {name: 'nit', type: 'string'},
            {name: 'importe_ice', type: 'numeric'},
            {name: 'nro_autorizacion', type: 'string'},
            {name: 'importe_iva', type: 'numeric'},
            {name: 'importe_descuento', type: 'numeric'},
            {name: 'importe_doc', type: 'numeric'},
            {name: 'sw_contabilizar', type: 'string'},
            {name: 'tabla_origen', type: 'string'},
            {name: 'estado', type: 'string'},
            {name: 'id_depto_conta', type: 'numeric'},
            {name: 'id_origen', type: 'numeric'},
            {name: 'obs', type: 'string'},
            {name: 'estado_reg', type: 'string'},
            {name: 'codigo_control', type: 'string'},
            {name: 'importe_it', type: 'numeric'},
            {name: 'razon_social', type: 'string'},
            {name: 'id_usuario_ai', type: 'numeric'},
            {name: 'id_usuario_reg', type: 'numeric'},
            {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
            {name: 'usuario_ai', type: 'string'},
            {name: 'id_usuario_mod', type: 'numeric'},
            {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
            {name: 'usr_reg', type: 'string'},
            {name: 'usr_mod', type: 'string'},
            {name: 'importe_pendiente', type: 'numeric'},
            {name: 'importe_anticipo', type: 'numeric'},
            {name: 'importe_retgar', type: 'numeric'},
            {name: 'importe_neto', type: 'numeric'},
            'desc_depto', 'desc_plantilla',
            'importe_descuento_ley', 'importe_aux_neto',
            'importe_pago_liquido', 'nro_dui', 'id_moneda', 'desc_moneda',
            'desc_tipo_doc_compra_venta', 'id_tipo_doc_compra_venta', 'nro_tramite',
            'desc_comprobante', 'id_int_comprobante', 'id_auxiliar', 'codigo_auxiliar', 'nombre_auxiliar', 'tipo_reg',
            'estacion', 'id_punto_venta', 'nombre', 'id_agencia', 'codigo_noiata', 'codigo_int', 'c31',
            {name: 'fecha_vencimiento', type: 'date', dateFormat: 'Y-m-d'}, 'tipo_cambio'
        ],

        sortInfo: {
            field: 'id_doc_compra_venta',
            direction: 'ASC'
        },

        arrayDefaultColumHidden: ['codigo_noiata'],
        bdel: true,
        bsave: false,
        btest: false,

        onButtonAct: function () {
            if (!this.validarFiltros()) {
                alert('Especifique el año y el mes antes')
            }
            else {
                this.store.baseParams.id_gestion = this.cmbGestion.getValue();
                this.store.baseParams.id_periodo = this.cmbPeriodo.getValue();
                this.store.baseParams.id_depto = this.cmbDepto.getValue();
                Phx.vista.RegFacturasXFuncionario.superclass.onButtonAct.call(this);
            }
        },

        formTitulo: '<span style="font-size:12pt;">Registro Facturas</span>',
        abrirFormulario: function (tipo, record) {
            var me = this;
            
            me.objSolForm = Phx.CP.loadWindows('../../../sis_contabilidad/vista/doc_compra_venta/FormCompraVentaFuncionario.php',
                me.formTitulo,
                {
                    modal: true,
                    width: '80%',
                    height: (me.regitrarDetalle == 'si') ? '100%' : '60%',
                }, {
                    data: {
                        objPadre: me,
                        tipoDoc: me.tipoDoc,
                        id_gestion: me.cmbGestion.getValue(),
                        id_periodo: me.cmbPeriodo.getValue(),
                        id_depto: me.cmbDepto.getValue(),
                        tmpPeriodo: me.tmpPeriodo,
                        tmpGestion: me.tmpGestion,
                        tipo_form: tipo,
                        datosOriginales: record
                    },
                    regitrarDetalle: me.regitrarDetalle
                },
                this.idContenedor,
                'FormCompraVentaFuncionario',
                {
                    config: [{
                        event: 'successsave',
                        delegate: this.onSaveForm,
                    }],
                    scope: this
                });
        },

        onButtonNew: function () {
            //abrir formulario de solicitud
            if (!this.validarFiltros()) {
                alert('Especifique el año y el mes antes')
            }
            else {
                this.abrirFormulario('new')
            }
        },

        onButtonEdit: function () {
            if (!this.validarFiltros()) {
                alert('Especifique el año y el mes antes')
            }
            else {
                this.abrirFormulario('edit', this.sm.getSelected())
            }
        },

        preparaMenu: function (tb) {
            Phx.vista.RegFacturasXFuncionario.superclass.preparaMenu.call(this, tb)
            var data = this.getSelectedData();

            if (data['revisado'] == 'si' || data.tipo_reg == 'summary') {
                this.getBoton('edit').disable();
                this.getBoton('del').disable();
            }
            else {
                this.getBoton('edit').enable();
                this.getBoton('del').enable();
            }
        },

        successExport: function (resp) {
            Phx.CP.loadingHide();
            var objRes = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            var nomRep = objRes.ROOT.detalle.archivo_generado;
            if (Phx.CP.config_ini.x == 1) {
                nomRep = Phx.CP.CRIPT.Encriptar(nomRep);
            }
            window.open('../../../reportes_generados/' + nomRep + '?t=' + new Date().toLocaleTimeString())
        },

    })
</script>