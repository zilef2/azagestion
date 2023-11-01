Validar(en produccion){

    ROLES
    -ID:1) asignadorr [verifica el trabajo del asesor]
    -ID:2) Asignador: subir datos, EN EXCEL
    -ID:3) Asesor: llena formulario con las horas de cada OC

    CLASIFICACION
    -asesoria
    -capacitacion

    ESTADOS DE LAS ORDENES DE COMPRA (OC)
    /*
        aprobado = 0 se acaba de subir via excel
        aprobado = 1 se diligenció
        aprobado = 2 se aprobo parcialmente
        aprobado = 3 rechazo por el asignadorr
        aprobado = 4 aprobado por completo
    */
}


-En la Base de datos, se tendrá otra tabla, con la informacion de las ordenes a modo de historico


-------------------------------------------AVISAR -------------------------------------------
//# Roles:
    -asignador: subir, aprobar OC y administrar usuarios
    -asesor: tramitar y corregir OC

//# USUARIOS 
Es inseguro que los usuarios se queden con la contraseña de su cédula y asterisco

//# Excel principal:
-no se necesita la columna: PROFESIONAL
-solo se necesitan las columnas:
    A numero de orden
    B fecha de aprobacion
    G empresa
    H tarea
    J clasificacion
    L prestador
    N CANTIDAD SIN PROGRAMAR
    U estado de la tarea


    -se valida:
        EJECUTADA
        ejecutada
        Ejecutada

        si se pone eJecutada o jecutada -> se tomara como NO ejecutada

//# ASESOR
-si es capacitacion, es obligatorio enviar un pdf

//# DISEÑO DEL CORREO 
    en azul y sin logo

//#-- pendientes sin respuesta
    //ASA seguros - maria isabel roldan
    Mandar correo al final del dia con lo que se le asignó
    //sin contexto
    Si es factura: facturada -> azul 

    // 1 solo correo:
    con que ordenes de compra tiene nuevas hoy (tintero)