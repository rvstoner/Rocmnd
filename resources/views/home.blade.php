@extends('layouts.app')

@section('content')

<section class="section">
    <div class="container">
        <h1 class="title">Home</h1>
    </div>
</section>
<section class="section">
    <template>
        <section>
            <b-message title="Default">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id fermentum quam. Proin sagittis, nibh id hendrerit imperdiet, elit sapien laoreet elit
            </b-message>

            <b-message title="Danger" type="is-danger">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id fermentum quam. Proin sagittis, nibh id hendrerit imperdiet, elit sapien laoreet elit
            </b-message>

            <b-message title="Success" type="is-success">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id fermentum quam. Proin sagittis, nibh id hendrerit imperdiet, elit sapien laoreet elit
            </b-message>

            <b-message title="Info" type="is-info">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id fermentum quam. Proin sagittis, nibh id hendrerit imperdiet, elit sapien laoreet elit
            </b-message>

            <b-message title="Warning" type="is-warning">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id fermentum quam. Proin sagittis, nibh id hendrerit imperdiet, elit sapien laoreet elit
            </b-message>
        </section>
    </template>
</section>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
        });
    </script>
@endsection
