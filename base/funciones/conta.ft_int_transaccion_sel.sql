--------------- SQL ---------------

CREATE OR REPLACE FUNCTION conta.ft_int_transaccion_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Contabilidad
 FUNCION: 		conta.ft_int_transaccion_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'conta.tint_transaccion'
 AUTOR: 		 (admin)
 FECHA:	        01-09-2013 18:10:12
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
    v_cuentas			varchar;
    v_filtro_cuentas	varchar;
			    
BEGIN

	v_nombre_funcion = 'conta.ft_int_transaccion_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'CONTA_INTRANSA_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		01-09-2013 18:10:12
	***********************************/

	if(p_transaccion='CONTA_INTRANSA_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
                            transa.id_int_transaccion,
                            transa.id_partida,
                            transa.id_centro_costo,
                            transa.id_partida_ejecucion,
                            transa.estado_reg,
                            transa.id_int_transaccion_fk,
                            transa.id_cuenta,
                            transa.glosa,
                            transa.id_int_comprobante,
                            transa.id_auxiliar,
                            transa.id_usuario_reg,
                            transa.fecha_reg,
                            transa.id_usuario_mod,
                            transa.fecha_mod,
                            usu1.cuenta as usr_reg,
                            usu2.cuenta as usr_mod,
                            CASE par.sw_movimiento
                                WHEN ''flujo'' THEN
                                    ''(F) ''||par.codigo || '' - '' || par.nombre_partida 
                                ELSE
                                    par.codigo || '' - '' || par.nombre_partida 
                                END  as desc_partida,
                            
                            cc.codigo_cc as desc_centro_costo,
                            cue.nro_cuenta || '' - '' || cue.nombre_cuenta as desc_cuenta,
                            aux.codigo_auxiliar || '' - '' || aux.nombre_auxiliar as desc_auxiliar,
                            par.sw_movimiento as tipo_partida,
                            ot.id_orden_trabajo,
                            ot.desc_orden,
                            transa.importe_debe,	
                            transa.importe_haber,
                            transa.importe_gasto,
                            transa.importe_recurso,
                            transa.importe_debe_mb,	
                            transa.importe_haber_mb,
                            transa.importe_gasto_mb,
                            transa.importe_recurso_mb,
                            transa.banco,
                            transa.forma_pago,
                            transa.nombre_cheque_trans,
                            transa.nro_cuenta_bancaria_trans,
                            transa.nro_cheque,
                            transa.importe_debe_mt,	
                            transa.importe_haber_mt,
                            transa.importe_gasto_mt,
                            transa.importe_recurso_mt,
                            transa.id_moneda_tri,
                            transa.id_moneda,
                            transa.tipo_cambio,
                            transa.tipo_cambio_2,
                            transa.actualizacion,
                            transa.triangulacion,
                            suo.id_suborden,
                            (''(''||suo.codigo||'') ''||suo.nombre)::varchar as desc_suborden,
                            ot.codigo as codigo_ot
                        from conta.tint_transaccion transa
						inner join segu.tusuario usu1 on usu1.id_usuario = transa.id_usuario_reg
                        inner join conta.tcuenta cue on cue.id_cuenta = transa.id_cuenta
						left join segu.tusuario usu2 on usu2.id_usuario = transa.id_usuario_mod
						left join pre.tpartida par on par.id_partida = transa.id_partida
						left join pre.vpresupuesto_cc cc on cc.id_centro_costo = transa.id_centro_costo
						left join conta.tauxiliar aux on aux.id_auxiliar = transa.id_auxiliar
                        left join conta.torden_trabajo ot on ot.id_orden_trabajo =  transa.id_orden_trabajo
                        left join conta.tsuborden suo on suo.id_suborden =  transa.id_suborden 
                        
                        
				        where ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CONTA_INTRANSA_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		01-09-2013 18:10:12
	***********************************/

	elsif(p_transaccion='CONTA_INTRANSA_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select 
                          count(transa.id_int_transaccion) as total,
                          sum(transa.importe_debe) as total_debe,
                          sum(transa.importe_haber) as total_haber,
                          sum(transa.importe_debe_mb) as total_debe_mb,
                          sum(transa.importe_haber_mb) as total_haber_mb,
                          sum(transa.importe_debe_mt) as total_debe_mt,
                          sum(transa.importe_haber_mt) as total_haber_mt,
                          sum(transa.importe_gasto) as total_gasto,
                          sum(transa.importe_recurso) as total_recurso
					     from conta.tint_transaccion transa
						inner join segu.tusuario usu1 on usu1.id_usuario = transa.id_usuario_reg
                        inner join conta.tcuenta cue on cue.id_cuenta = transa.id_cuenta
						left join segu.tusuario usu2 on usu2.id_usuario = transa.id_usuario_mod
						left join pre.tpartida par on par.id_partida = transa.id_partida
						left join pre.vpresupuesto_cc cc on cc.id_centro_costo = transa.id_centro_costo
						left join conta.tauxiliar aux on aux.id_auxiliar = transa.id_auxiliar
                        left join conta.torden_trabajo ot on ot.id_orden_trabajo =  transa.id_orden_trabajo
                        left join conta.tsuborden suo on suo.id_suborden =  transa.id_suborden
                        where  ';
			
            
           
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;
 raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;

		end;
	/*********************************    
 	#TRANSACCION:  'CONTA_INTMAY_SEL'
 	#DESCRIPCION:	listado de transacicones para el mayor
 	#AUTOR:		admin	
 	#FECHA:		24-04-2015 18:10:12
	***********************************/

	elsif(p_transaccion='CONTA_INTMAY_SEL')then
     				
    	begin
        
            v_cuentas = '0';
            v_filtro_cuentas = '0=0';
    		
             IF  pxp.f_existe_parametro(p_tabla,'id_cuenta')  THEN
             
                  IF v_parametros.id_cuenta is not NULL THEN
                
                      WITH RECURSIVE cuenta_rec (id_cuenta, id_cuenta_padre) AS (
                        SELECT cue.id_cuenta, cue.id_cuenta_padre
                        FROM conta.tcuenta cue
                        WHERE cue.id_cuenta = v_parametros.id_cuenta and cue.estado_reg = 'activo'
                      UNION ALL
                        SELECT cue2.id_cuenta, cue2.id_cuenta_padre
                        FROM cuenta_rec lrec 
                        INNER JOIN conta.tcuenta cue2 ON lrec.id_cuenta = cue2.id_cuenta_padre
                        where cue2.estado_reg = 'activo'
                      )
                    SELECT  pxp.list(id_cuenta::varchar) 
                      into 
                        v_cuentas
                    FROM cuenta_rec;
                    
                    
                    
                    v_filtro_cuentas = ' transa.id_cuenta in ('||v_cuentas||') ';
                END IF;
                
            END IF;
           
            
            --Sentencia de la consulta
			v_consulta:='select
						transa.id_int_transaccion,
						transa.id_partida,
						transa.id_centro_costo,
						transa.id_partida_ejecucion,
						transa.estado_reg,
						transa.id_int_transaccion_fk,
						transa.id_cuenta,
						transa.glosa,
						transa.id_int_comprobante,
						transa.id_auxiliar,
						transa.id_usuario_reg,
						transa.fecha_reg,
						transa.id_usuario_mod,
						transa.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        COALESCE(transa.importe_debe_mb,0) as importe_debe_mb,
                        COALESCE(transa.importe_haber_mb,0) as importe_haber_mb, 
                       	COALESCE(transa.importe_gasto_mb,0),
						COALESCE(transa.importe_recurso_mb,0),
						
                        CASE par.sw_movimiento
                        	WHEN ''flujo'' THEN
								''(F) ''||par.codigo || '' - '' || par.nombre_partida 
                            ELSE
                            	par.codigo || '' - '' || par.nombre_partida 
                        	END  as desc_partida,
                        
						cc.codigo_cc as desc_centro_costo,
						cue.nro_cuenta || '' - '' || cue.nombre_cuenta as desc_cuenta,
						aux.codigo_auxiliar || '' - '' || aux.nombre_auxiliar as desc_auxiliar,
                        par.sw_movimiento as tipo_partida,
                        ot.id_orden_trabajo,
                        ot.desc_orden,
                        icbte.nro_cbte,
                        icbte.nro_tramite,
                        dep.nombre_corto,
                        icbte.fecha,
                        icbte.glosa1,
                        icbte.id_proceso_wf,
                        icbte.id_estado_wf
                        
						from conta.tint_transaccion transa
                        inner join conta.tint_comprobante icbte on icbte.id_int_comprobante = transa.id_int_comprobante
                        inner join param.tdepto dep on dep.id_depto = icbte.id_depto
                        inner join param.tperiodo per on per.id_periodo = icbte.id_periodo
						inner join segu.tusuario usu1 on usu1.id_usuario = transa.id_usuario_reg
                       
                        inner join conta.tcuenta cue on cue.id_cuenta = transa.id_cuenta
						left join segu.tusuario usu2 on usu2.id_usuario = transa.id_usuario_mod
						left join pre.tpartida par on par.id_partida = transa.id_partida
						left join param.vcentro_costo cc on cc.id_centro_costo = transa.id_centro_costo
						left join conta.tauxiliar aux on aux.id_auxiliar = transa.id_auxiliar
                        left join conta.torden_trabajo ot on ot.id_orden_trabajo =  transa.id_orden_trabajo
				        where icbte.estado_reg = ''validado'' and ' || v_filtro_cuentas||' and ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
            raise notice '%', v_consulta;
			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'CONTA_INTMAY_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		01-09-2013 18:10:12
	***********************************/

	elsif(p_transaccion='CONTA_INTMAY_CONT')then

		begin
             v_cuentas = '0';
             v_filtro_cuentas = '0=0';
    		
             IF  pxp.f_existe_parametro(p_tabla,'id_cuenta')  THEN
             
                  IF v_parametros.id_cuenta is not NULL THEN
                
                      WITH RECURSIVE cuenta_rec (id_cuenta, id_cuenta_padre) AS (
                        SELECT cue.id_cuenta, cue.id_cuenta_padre
                        FROM conta.tcuenta cue
                        WHERE cue.id_cuenta = v_parametros.id_cuenta and cue.estado_reg = 'activo'
                      UNION ALL
                        SELECT cue2.id_cuenta, cue2.id_cuenta_padre
                        FROM cuenta_rec lrec 
                        INNER JOIN conta.tcuenta cue2 ON lrec.id_cuenta = cue2.id_cuenta_padre
                        where cue2.estado_reg = 'activo'
                      )
                    SELECT  pxp.list(id_cuenta::varchar) 
                      into 
                        v_cuentas
                    FROM cuenta_rec;
                    
                    
                    
                    v_filtro_cuentas = ' transa.id_cuenta in ('||v_cuentas||') ';
                END IF;
                
            END IF;
        
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select 
                        count(transa.id_int_transaccion) as total,
                        sum(CASE cue.valor_incremento 
                        	WHEN ''negativo'' THEN
								COALESCE(transa.importe_debe_mb*-1,0)
                            ELSE
                            	COALESCE(transa.importe_debe_mb,0)
                        	END)  as total_debe, 
                        
                        sum(COALESCE(transa.importe_haber_mb,0)) as total_haber
                        
					    from conta.tint_transaccion transa
                        inner join conta.tint_comprobante icbte on icbte.id_int_comprobante = transa.id_int_comprobante
                        inner join param.tdepto dep on dep.id_depto = icbte.id_depto
                        inner join param.tperiodo per on per.id_periodo = icbte.id_periodo
						inner join segu.tusuario usu1 on usu1.id_usuario = transa.id_usuario_reg
                        
                        inner join conta.tcuenta cue on cue.id_cuenta = transa.id_cuenta               
						left join segu.tusuario usu2 on usu2.id_usuario = transa.id_usuario_mod
						left join pre.tpartida par on par.id_partida = transa.id_partida
						left join param.vcentro_costo cc on cc.id_centro_costo = transa.id_centro_costo
						left join conta.tauxiliar aux on aux.id_auxiliar = transa.id_auxiliar
                        left join conta.torden_trabajo ot on ot.id_orden_trabajo =  transa.id_orden_trabajo
				        where icbte.estado_reg = ''validado'' and ' || v_filtro_cuentas||' and ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;				
	else
					     
		raise exception 'Transaccion inexistente';
					         
	end if;
					
EXCEPTION
					
	WHEN OTHERS THEN
			v_resp='';
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
			v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
			v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
			raise exception '%',v_resp;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;