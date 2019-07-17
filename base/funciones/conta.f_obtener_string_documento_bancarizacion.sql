CREATE OR REPLACE FUNCTION conta.f_obtener_string_documento_bancarizacion (
p_gestion INTEGER
)
  RETURNS varchar AS
$body$
/**************************************************************************
 FUNCION: 		conta.f_obtener_string_documento_bancarizacion
 DESCRIPCION:   devuelve una candena para concatenar dependiendo si es pxp o endesis
 AUTOR: 	    favio figueroa (ffp)
 FECHA:	        09/01/2017
 COMENTARIOS:
***************************************************************************
 HISTORIA DE MODIFICACIONES:

 DESCRIPCION:
 AUTOR:
 FECHA:
 ***************************************************************************/


DECLARE
  v_nombre_funcion   	text;
  v_resp              varchar;
  v_respuesta         boolean;
  v_host                VARCHAR;

BEGIN

  v_nombre_funcion:='conta.f_obtener_string_documento_bancarizacion';
  v_respuesta=false;

  v_host:='dbname=dbendesis host=192.168.100.30 user=ende_pxp password=ende_pxp';

   --verificamos la configuracion para ver de donde sacamos los documentos
  --todas los años menor  o igual al 2016 iran a sacar los documentos desde el endesis
  IF p_gestion <= 2016
    THEN

      v_resp:= ' WITH tabla_temporal_documentos AS (
              SELECT * FROM dblink(''' || v_host || ''',
          ''select tctcomp.id_int_comprobante,
          tctdoc.razon_social,
          tctdoc.id_documento,
          docval.importe_total,
          docval.id_moneda,
          tctdoc.nro_documento,
          tctdoc.nro_autorizacion,
          tctdoc.fecha_documento,
          tctdoc.nro_nit,
          traval.importe_debe,
          traval.importe_gasto
          from sci.tct_comprobante tctcomp
          inner join sci.tct_transaccion tcttra on tcttra.id_comprobante = tctcomp.id_comprobante
          inner JOIN sci.tct_transac_valor traval on traval.id_transaccion = tcttra.id_transaccion
          inner join sci.tct_documento tctdoc on tctdoc.id_transaccion = tcttra.id_transaccion
          inner join sci.tct_documento_valor docval on docval.id_documento = tctdoc.id_documento
          where   docval.id_moneda = 1 and traval.id_moneda=1
           ''
                   ) AS d (id_int_comprobante integer,
                   razon_social varchar(500),
                    id_documento integer,
                    importe_total numeric(10,2),
                    id_moneda INTEGER,
                    nro_documento bigint,
                    nro_autorizacion VARCHAR(20),
                    fecha_documento date,
                    nro_nit varchar(30),
                     importe_debe numeric(10,2),
                     importe_gasto numeric(10,2))
              )';

      v_resp := v_resp || ',tabla_temporal_sigma AS (
              SELECT * FROM dblink(''' || v_host || ''',
          ''select tctcomp.id_int_comprobante,
          tctcomp.id_comprobante,
          entre.comprobante_c31,
            traval.importe_haber,
  traval.importe_recurso,
          entre.fecha_entrega

          from sci.tct_comprobante tctcomp
             inner join sci.tct_transaccion tcttra on tcttra.id_comprobante = tctcomp.id_comprobante
            inner join sci.tct_cuenta cta on cta.id_cuenta=tcttra.id_cuenta and cta.tipo_cuenta=1
            inner join sci.tct_transac_valor traval on traval.id_transaccion = tcttra.id_transaccion and traval.id_moneda = 1
          inner join sci.tct_entrega_comprobante entrecom on entrecom.id_comprobante = tctcomp.id_comprobante
          inner join sci.tct_entrega entre on entre.id_entrega = entrecom.id_entrega

           ''
                   ) AS d (
                   id_int_comprobante integer,

                    id_comprobante integer,

                    comprobante_c31 VARCHAR(20),
                     importe_haber numeric(10,2),
                   importe_recurso numeric(10,2),
                    fecha_entrega date )
              )';


  ELSE
    --los documentos mayor o igual a 2017 se buscara todo en el pxp
      --RAISE EXCEPTION 'es pxps';


    v_resp := 'WITH tabla_temporal_documentos AS (
        select
          doc.id_int_comprobante,
          doc.razon_social,
          doc.id_doc_compra_venta as id_documento,
          doc.importe_neto as importe_total,
          doc.id_moneda,
          doc.nro_documento,
          doc.nro_autorizacion,
          doc.fecha as fecha_documento,
          doc.nit as nro_nit,
          0 as importe_debe,
          0 as importe_gasto
        FROM conta.tdoc_compra_venta doc
          INNER JOIN conta.tint_comprobante comp on comp.id_int_comprobante = doc.id_int_comprobante

    ) ,tabla_temporal_sigma AS (

        select
          comp.id_int_comprobante,
          comp.nro_comprobante as comprobante_c31,
          0 as importe_haber,
          0 as importe_recurso,
          comp.fecha_pago as fecha_entrega

        FROM tes.tts_libro_bancos comp
    )';





      END IF;







  return v_resp;


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