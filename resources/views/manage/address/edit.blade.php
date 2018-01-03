@extends('layouts.manage')

@section('content')
<div class="flex-container">
	<div class="columns m-t-10">
		<div class="column">
			<h1 class="title">Edit {{$ip->address}}</h1>
		</div>
	</div>
	<hr class="m-t-0">
	<form action="{{route('address.update', $ip->id)}}" method="POST">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="columns">
			<div class="column">
				<div class="box">
					<article class="media">
						<div class="media-content">
							<div class="content">									
									<div class="field">
										<label for="ip_address" class="label">IP Address:</label>
										<p class="control">
											<input type="text" class="input" name="ip_address" id="ip_address" value="{{$ip->address}}">
										</p>
									</div>
								</div>
							</div>
						</article>
					</div>
					<button class="button is-primary">Save Changes to this ip address</button>
				</div>
			</div>
		</form>
	</div>
	@endsection
