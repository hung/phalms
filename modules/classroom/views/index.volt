<div class="col-md-12 col-sm-12">
    <div class="box">
        <header class="bg-alizarin text-white">
            <h4>Manage Classroom</h4>
            <!-- begin box-tools -->
            <div class="box-tools">
                <a class="fa fa-fw fa-minus" href="#" data-box="collapse"></a>
                <a class="fa fa-fw fa-square-o" href="#" data-fullscreen="box"></a>
                <a class="fa fa-fw fa-refresh" href="#" data-box="refresh"></a>
                <a class="fa fa-fw fa-times" href="#" data-box="close"></a>
            </div>
            <!-- END: box-tools -->
        </header>
        <div class="box-body collapse in">
            {{ content() }}
        <table id="grid-classroom" class="table table-condensed table-hover table-striped">
            <thead>
            <tr>
                <th data-column-id="no" data-type="numeric" data-width="5%" data-sortable="false">no</th>
                <th data-column-id="school_id" data-sortable="false">School_id</th>
            	<th data-column-id="subject_id" data-sortable="false">Subject_id</th>
            	<th data-column-id="major_id" data-sortable="false">Major_id</th>
            	<th data-column-id="teacher_id" data-sortable="false">Teacher_id</th>
            	<th data-column-id="grade" data-sortable="false">Grade</th>
            	<th data-column-id="description" data-sortable="false">Description</th>
	
                <th data-column-id="commands" data-formatter="commands" data-sortable="false">Action</th>
            </tr>
            </thead>
        </table>
        </div>
    </div>
</div>

<div id="myclassroom" class="modal fade modal-wide" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Classroom</h4>
            </div>
            <div class="modal-body">
                <form id="myForm" method="post" enctype="multipart/form-data">
                    <div class="form-group" >
                    <input type="hidden" class="form-control" name="hidden_id" id="hidden_id" >
                    </div>
                    <div class="form-group" >
	<label>School_id</label>
	<input type="text" class="form-control" name="school_id" id="school_id" >
	</div>
	<div class="form-group" >
	<label>Subject_id</label>
	<input type="text" class="form-control" name="subject_id" id="subject_id" >
	</div>
	<div class="form-group" >
	<label>Major_id</label>
	<input type="text" class="form-control" name="major_id" id="major_id" >
	</div>
	<div class="form-group" >
	<label>Teacher_id</label>
	<input type="text" class="form-control" name="teacher_id" id="teacher_id" >
	</div>
	<div class="form-group" >
	<label>Grade</label>
	<input type="text" class="form-control" name="grade" id="grade" >
	</div>
	<div class="form-group" >
	<label>Description</label>
	<textarea class="form-control" name="description" id="description" >
	</textarea>
	</div>
	
                    <div class="form-group" >
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i>  close</button>
                                <button type="submit" name="save" class="btn btn-primary" id="save"><i class="fa fa-save"></i>  Save </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>