/**
 * Created by ESTALIN on 12/11/2016.
 */
$(document).ready(function(){

    var consulta;

    //hacemos focus al campo de búsqueda
    $("#busqueda").focus();

    //comprobamos si se pulsa una tecla
    $("#busqueda").keyup(function(e){

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#busqueda").val();

        //hace la búsqueda

        $.ajax({
            type: "POST",
            url: "buscar.php",
            data: "b="+consulta,
            dataType: "html",
            beforeSend: function(){
                //imagen de carga
                $("#resultado").html("<p align='center'><img src='images/ajax-loader.gif' /></p>");
            },
            error: function(){
                alert("error petición ajax");
            },
            success: function(data){
                $("#resultado").empty();
                $("#resultado").append(data);
            }
        });


    });

});