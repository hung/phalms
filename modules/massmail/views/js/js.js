$(document).ready(function(){
    var url_path = "http://phalms.dev/massmail/";
    var massmail_grid = $("#grid-massmail").bootgrid({
        ajax: true,
        url: url_path+"list",
        selection: true,
        multiSelect: true,
        templates: {
            header:"<div id=\"{{ctx.id}}\" class=\"{{css.header}}\"><div class=\"row\"><div class=\"col-sm-6 actionBar\"><div class=\"{{css.search}}\"></div></div><div class=\"col-sm-6\"><div class=\"{{css.actions}}\"></div> <div class='btn btn-primary' id='create' class='command-add'> <span class=\"fa fa-plus-square-o\"></span> New Massmail</div></div></div></div>",
        },
        formatters: {
            "file" : function (column, row) {
                return "<img src='"+row.file+"' height='75px'>";
            },
            "published": function(column, row)
            {
                if(row.publish == 1){
                    return "Yes";
                }else{
                    return "No";
                }
            },
            "commands": function(column, row)
            {
                return "<button type=\"button\" class=\"btn btn-sm btn-primary command-edit\" data-row-title=\""+row.title+"\" data-row-category=\""+row.category+"\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\"></span></button> " +
                        "<button type=\"button\" class=\"btn btn-sm btn-primary command-delete\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-trash-o\"></span></button>";
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
    {
        $(this).find(".command-edit").off();
        $(this).find(".command-delete").off();
        $(this).find(".command-add").off();

        $(this).find(".command-edit").on("click", function(e)
        {
            myForm('edit',$(this));
            $("#myForm").ajaxForm({
                url: url_path+'edit',
                type: 'post',
                success: function(data) {
                    myAlert(data);
                    $("#grid-massmail").bootgrid("reload");
                    setTimeout(function(){
                        $('#myModal').modal('hide')
                    }, 10000);
                }
            });

        }).end().find(".command-delete").on("click", function(e)
        {
            $.get( url_path+"delete/"+ $(this).data("row-id"), function( data ) {
                //myAlert(data);
                toastr.success(data.msg, data.title);
                toastr.options.timeOut = 15;
                toastr.options.extendedTimeOut = 30;
                $("#grid-massmail").bootgrid("reload");
            });

        });

        $("#create").on("click",function(e)
        {
            myForm('create',e);
            $("#myForm").ajaxForm({
                url: url_path+'create',
                type: 'post',
                success: function(data) {
                    myAlert(data);
                    massmail_grid.bootgrid("reload");
                    setTimeout(function(){
                        $('#mymassmail').modal('hide');
                    }, 10000);
                }
            });
        });
    });


    function myForm(status,e) {
        $('#myForm')[0].reset();
        if(status == 'edit') {

            $('#mymassmail .modal-title').html('Edit massmail '+e.data("row-id"));
            $.getJSON(url_path+"get/?id=" + e.data("row-id"), function (data) {
                $('#hidden_id').val(data.id);
                 $('#email').val(data.email);
	 $('#content').val(data.content);
	
            });
        }else{
            $('#mymassmail .modal-title').html('Create New massmail ');
            
        }

        $('#mymassmail').modal('show');

    }

    function myAlert(e)
    {
        var mesg= [];
        mesg["alert"] = e.alert;
        mesg["title"] = e.msg;
        mesg["msg"] = "#massmail "+e._id+" "+e.msg;
        notif_show(mesg);
    }

});