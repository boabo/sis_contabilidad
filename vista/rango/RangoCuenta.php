<?php
/**
*@package pXP
*@file gen-Rango.php    
*@author  (admin)
*@date 22-06-2017 21:30:05
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.RangoCuenta=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.RangoCuenta.superclass.constructor.call(this,config);
		this.init();
		//this.grid.addListener('celldblclick', this.oncelldblclick, this);
        this.grid.addListener('cellclick', this.oncellclick,this);
       
		
		console.log('this.idContenedorPadre',this.idContenedorPadre)
		
		var padre = Phx.CP.getPagina(this.idContenedorPadre);
		
		console.log('datos maestro', this.maestro)
		this.store.baseParams = { id_tipo_cc: this.maestro.id_tipo_cc, 
								  fecha_ini :this.maestro.fecha_ini.dateFormat('d/m/Y') , 
								  fecha_fin: this.maestro.fecha_fin.dateFormat('d/m/Y')}
								  
		this.load({ params: { start: 0, limit: 100}});
        
        
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_cuenta'
			},
			type:'Field',
			form:false 
		},
		{
			config:{
				name: 'detalle',
				fieldLabel: '',
				gwidth: 25, 
				renderer:function (value,p,record){  
					if(record.data.tipo_reg != 'summary'){
					    return  String.format("<div style='text-align:center'><img title='Revisar detalle' src = '../../../lib/imagenes/connect.png' align='center'/></div>",record.data.periodo,record.data.gestion);
				     }
				}
			},
			type:'Field',
			grid:true
		},
		
		{
			config:{
				name: 'descripcion_cuenta',
				fieldLabel: 'Cuenta',
				gwidth: 300, 
				renderer:function (value,p,record){  
					if(record.data.tipo_reg != 'summary'){
						if(record.data.tipo_cuenta == 'gasto'){						
							return  String.format("<font color='orange'>{0} -  {1}</font>",record.data.codigo_cuenta,record.data.descripcion_cuenta);
						}
					    else if(record.data.tipo_cuenta == 'activo'){
								return  String.format("<font color='blue'>{0} -  {1}</font>",record.data.codigo_cuenta,record.data.descripcion_cuenta);
						
						}else if(record.data.tipo_cuenta == 'ingreso'){
								return  String.format("<font color='green'>{0} -  {1}</font>",record.data.codigo_cuenta,record.data.descripcion_cuenta);
						
						}else{
								return  String.format("<font color='red'>{0} -  {1}</font>",record.data.codigo_cuenta,record.data.descripcion_cuenta);
						
						}
					}
					
				}
			},
			type:'TextField',
			filters:{pfiltro:'codigo_cuenta#descripcion_cuenta#tipo_cuenta',type:'string'},
			id_grupo:1,
			grid:true,
			form:false
		},
		{
			config:{
				name: 'importe_debe_mb',
				fieldLabel: 'Debe MB',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				renderer:function (value,p,record){
						if(record.data.tipo_reg != 'summary'){
							return  String.format('{0}', Ext.util.Format.number(value,'0,000.00'));
						}
						else{
							return  String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value,'0,000.00'));
						}
					}
			},
				type:'NumberField',
				filters:{pfiltro:'ran.debe_mb',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'importe_haber_mb',
				fieldLabel: 'Haber MB',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				renderer:function (value,p,record){
						if(record.data.tipo_reg != 'summary'){
							return  String.format('{0}', Ext.util.Format.number(value,'0,000.00'));
						}
						else{
							return  String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value,'0,000.00'));
						}
					}
			},
				type:'NumberField',
				filters:{pfiltro:'ran.haber_mb',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
			config:{
				name: 'importe_debe_mt',
				fieldLabel: 'Debe MT',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				renderer:function (value,p,record){
						if(record.data.tipo_reg != 'summary'){
							return  String.format('{0}', Ext.util.Format.number(value,'0,000.00'));
						}
						else{
							return  String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value,'0,000.00'));
						}
					}
			},
				type:'NumberField',
				filters:{pfiltro:'ran.debe_mt',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'importe_haber_mt',
				fieldLabel: 'Haber MT',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				renderer:function (value,p,record){
						if(record.data.tipo_reg != 'summary'){
							return  String.format('{0}', Ext.util.Format.number(value,'0,000.00'));
						}
						else{
							return  String.format('<b><font size=2 >{0}</font><b>', Ext.util.Format.number(value,'0,000.00'));
						}
					}
			},
				type:'NumberField',
				filters:{pfiltro:'ran.haber_mt',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Rangos de Costo',
	ActList:'../../sis_contabilidad/control/IntTransaccion/listarIntTransaccionCuenta',
	id_store:'id_rango',
	fields: [
		'importe_debe_mb',
        'importe_haber_mb',
        'importe_debe_mt',
        'importe_haber_mt',
        'id_cuenta',
        'codigo_cuenta',
        'descripcion_cuenta','tipo_reg','tipo_cuenta'
		
	],
	sortInfo:{
		field: 'codigo_cuenta',
		direction: 'ASC'
	},
	bdel:false,
	bnew:false,
	bedit:false,
	bsave:false,
	
	oncellclick : function(grid, rowIndex, columnIndex, e) {
		
	    var record = this.store.getAt(rowIndex),
	        fieldName = grid.getColumnModel().getDataIndex(columnIndex); // Get field name

	    if (fieldName == 'detalle') {
	    	Phx.CP.loadWindows('../../../sis_contabilidad/vista/int_transaccion/FormFiltro.php',
                    'Mayor',
                    {
                        width:'100%',
                        height:'100%',
                    },
                    { maestro:record.data,
                      detalle: {
                      	        'tipo_filtro': 'gestion',
                      	        'desde': this.maestro.fecha_ini,
                      	        'hasta': this.maestro.fecha_fin,
                      	        'id_cuenta': record.data.id_cuenta,
                      	        'desc_cuenta': record.data.descripcion_cuenta,
                      	         'id_tipo_cc': this.maestro.id_tipo_cc,
                      	        'desc_tipo_cc': this.maestro.desc_tipo_cc,
                      	        'id_gestion':this.maestro.id_gestion,
                      	        'desc_gestion':this.maestro.gestion
                      	      }
                      
                     },
                    this.idContenedor,
                    'FormFiltro'
           );
	    	
	    }
		
	}
	
	
})
</script>	