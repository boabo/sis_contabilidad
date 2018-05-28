CREATE OR REPLACE FUNCTION conta.ft_libro_compras_ventas_iva_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/************************************************************************** SISTEMA:        Sistema de Contabilidad
 FUNCION:         conta.ft_libro_compras_ventas_iva_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'conta.tbanca_compra_venta'
 AUTOR:          (admin)
 FECHA:            11-09-2015 14:36:46
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:
 AUTOR:
 FECHA:
***************************************************************************/

DECLARE

  v_consulta varchar;
  v_parametros record;
  v_nombre_funcion text;
  v_resp varchar;

  v_record record;
  v_host varchar;

BEGIN

  v_nombre_funcion = 'conta.ft_libro_compras_ventas_iva_sel';
  v_parametros = pxp.f_get_record(p_tabla);

  v_host:='dbname=dbendesis host=192.168.100.30 user=ende_pxp password=ende_pxp'
    ;

  /*********************************
     #TRANSACCION:  'CONTA_BANCA_SEL'
     #DESCRIPCION:    Consulta de datos
     #AUTOR:        admin
     #FECHA:        11-09-2015 14:36:46
    ***********************************/

  if(p_transaccion='CONTA_BANCA2_SEL')then

    begin

      --creacion de tabla temporal del endesis
      v_consulta:='WITH tabla_temporal_documentos AS (
          SELECT * FROM dblink('''||v_host||''',
      ''SELECT id_documento,razon_social FROM sci.tct_documento''
               ) AS d (id_documento integer,razon_social varchar(255))
          )';

      --Sentencia de la consulta
      v_consulta:=v_consulta||' select
						banca.id_banca_compra_venta,
						banca.num_cuenta_pago,
						banca.tipo_documento_pago,
						banca.num_documento,
						banca.monto_acumulado,
						banca.estado_reg,
						banca.nit_ci,
						banca.importe_documento,
						banca.fecha_documento,
						banca.modalidad_transaccion,
						banca.tipo_transaccion,
						banca.autorizacion,
						banca.monto_pagado,
						banca.fecha_de_pago,
						banca.razon,
						banca.tipo,
						banca.num_documento_pago,
						banca.num_contrato,
						banca.nit_entidad,
						banca.fecha_reg,
						banca.usuario_ai,
						banca.id_usuario_reg,
						banca.id_usuario_ai,
						banca.id_usuario_mod,
						banca.fecha_mod,
                        banca.id_periodo,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        confmo.descripcion as desc_modalidad_transaccion,
                        conftt.descripcion as desc_tipo_transaccion,
                        conftd.descripcion as desc_tipo_documento_pago,
                        banca.revisado,
                        banca.id_contrato,
                        banca.id_proveedor,
                        provee.desc_proveedor as desc_proveedor2,
                        contra.objeto as desc_contrato,
                        banca.id_cuenta_bancaria,
                        cuenta.denominacion as desc_cuenta_bancaria,
                        banca.id_documento,
                        doc.razon_social as desc_documento,
                        param.f_literal_periodo(banca.id_periodo) as periodo
						from conta.tbanca_compra_venta banca
						inner join segu.tusuario usu1 on usu1.id_usuario = banca.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = banca.id_usuario_mod
                        left join conta.tconfig_banca confmo on confmo.digito = banca.modalidad_transaccion
                        left join conta.tconfig_banca conftt on conftt.digito = banca.tipo_transaccion
                        left join conta.tconfig_banca conftd on conftd.digito = banca.tipo_documento_pago
                        left join param.vproveedor provee on provee.id_proveedor = banca.id_proveedor
                        left join leg.tcontrato contra on contra.id_contrato = banca.id_contrato
                        left join tes.tcuenta_bancaria cuenta on cuenta.id_cuenta_bancaria = banca.id_cuenta_bancaria
                        left join tabla_temporal_documentos doc on doc.id_documento = banca.id_documento
                        where ';

      --Definicion de la respuesta
      v_consulta:=v_consulta||v_parametros.filtro;

      v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' ||
        v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad ||
        ' offset ' || v_parametros.puntero;



      --Devuelve la respuesta
      return v_consulta;

    end;

    /*********************************
     #TRANSACCION:  'CONTA_BANCA_CONT'
     #DESCRIPCION:    Conteo de registros
     #AUTOR:        admin
     #FECHA:        11-09-2015 14:36:46
    ***********************************/

    elsif(p_transaccion='CONTA_BANCA2_CONT')then

    begin
      --Sentencia de la consulta de conteo de registros
      v_consulta:='select count(id_banca_compra_venta)
					    from conta.tbanca_compra_venta banca
					    inner join segu.tusuario usu1 on usu1.id_usuario = banca.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = banca.id_usuario_mod
                        inner join conta.tconfig_banca confmo on confmo.digito = banca.modalidad_transaccion
                        inner join conta.tconfig_banca conftt on conftt.digito = banca.tipo_transaccion
                        inner join conta.tconfig_banca conftd on conftd.digito = banca.tipo_documento_pago

					    where ';

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