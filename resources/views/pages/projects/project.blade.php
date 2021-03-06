@extends("app")

@section("page-title")
{{ $project->name ? $project->name : "Create Project" }} - 
@stop

@section("content")

<div class="section"><div class='section-container'>
	<h3>{{ $project->name ? "Project: ".$project->name : "Create Project" }}</h3>
	<div class="panel panel-default">
		<form method="post" action="{{ action('ProjectController@postProject', $project->id) }}" class="panel-body validate">
			{!! csrf_field() !!}
			<label for="name">Project Name</label>
			<input type="text" name="name" id="name" placeholder="Project Name" class="form-control" data-bvalidator="required" value="{{ $project->name }}">
			<br>
			<label for="description">Description</label>
			<textarea name="description" id="description" placeholder="Project Description" class="form-control" data-bvalidator="required" rows="4">{{ $project->description }}</textarea>
			<br>
			<input type="submit" value="{{ $project->name ? 'Save' : 'Create'}} Project" class="btn btn-primary">
		</form>
	</div>
	
	@if (count($members))
	<h3>Team Members</h3>
	<div class="panel panel-default">
		<table class="table table-bordered table-hover table-clickable panel-body sortableTable">
			<thead>
				<tr>
					<th>Member</th>
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($members as $member)
			    <tr>
			    	<td onclick="location.href='{{ $member->profileURL() }}';">{{ $member->name }}</td>
			    	<td><a href="{{ action('ProjectController@getMemberRemove', [$project->id, $member->id]) }}" class="btn btn-sm btn-danger pull-right">{{ $member->id==session()->get('member_id') ? "Leave" : "Remove" }}</a></td>
			    </tr>
			@endforeach
				<tr><td>
					<form method="post" action="{{ action('ProjectController@postMemberAdd', $project->id) }}">
						{!! csrf_field() !!}
						<div class="input-group">
							<span class="input-group-addon" id="memberTitle">Add Team Member: </span>
							<input type="text" id="memberEmail" name="member" class="form-control membersautocomplete" placeholder="(Name or Email)">
							<span class="input-group-btn">
								<input type="submit" class="btn btn-primary" value="Add">
							</span>
			    		</div>
					</form>
				</td>
				<td></td></tr>
			</tbody>
		</table>
	</div>
	@endif
	
	@if (count($members))
	<a href="{{ action('ProjectController@getDelete', $project->id) }}" class="pull-right"><button type="button" class="btn btn-danger btn-sm">Delete Project</button></a>
	@endif
</div></div>

@stop