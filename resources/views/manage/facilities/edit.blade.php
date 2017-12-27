@extends('layouts.manage')

@section('content')
<div class="flex-container">
	<div class="columns m-t-10">
		<div class="column">
			<h1 class="title">Edit {{$facility->display_name}}</h1>
		</div>
	</div>
	<hr class="m-t-0">
	<form action="{{route('facilities.update', $facility->id)}}" method="POST">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="columns">
			<div class="column">
				<div class="box">
					<article class="media">
						<div class="media-content">
							<div class="content">
								<h2 class="title">Facility Details:</h1>
									<div class="field">
										<p class="control">
											<label for="display_name" class="label">Name (Human Readable)</label>
											<input type="text" class="input" name="display_name" value="{{$facility->display_name}}" id="display_name">
										</p>
									</div>
									<div class="field">
										<p class="control">
											<label for="name" class="label">Slug (Can not be edited)</label>
											<input type="text" class="input" name="name" value="{{$facility->name}}" disabled id="name">
										</p>
									</div>
									<div class="field">
										<p class="control">
											<label for="description" class="label">Description</label>
											<input type="text" class="input" value="{{$facility->description}}" id="description" name="description">
										</p>
									</div>
									<div class="field">
										<label for="ip_address" class="label">IP Address:</label>
										<p class="control">
											<input type="text" class="input" name="ip_address" id="ip_address">
										</p>
									</div>
								</div>
							</div>
						</article>
					</div>
					<button class="button is-primary">Save Changes to this Facility</button>
				</div>
			</div>
		</form>
	</div>
	@endsection
