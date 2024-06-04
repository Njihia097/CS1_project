<x-admin-layout>

    @section('content')

    <div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Register an Editor</h4>
                    <p class="card-description"> Insert credentials of the desired editor here to register a new Editor </p>
                    
                    <form class="forms-sample" method="POST" action="{{route('admin.registor-editor')}}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Insert the editor's full name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <!-- <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputConfirmPassword1">Confirm Password</label>
                            <input type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
                        </div> -->
                        <div class="form-check form-check-flat form-check-primary">
                            <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="remeber" value="1"> Remember me </label>
                        </div>
                        <button type="submit" class="mr-2 btn btn-primary">Submit</button>
                        <button class="btn btn-dark">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection


</x-admin-layout>