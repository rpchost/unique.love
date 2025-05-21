<div class="card mb-4">
    <div class="card-header">
        <h5>Search Users</h5>
    </div>
    <div class="card-body">
        <form action="/users/search" method="GET">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ request('email') }}">
                </div>
                <div class="col-md-2">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="">All</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="age_min" class="form-label">Min Age</label>
                    <input type="number" class="form-control" id="age_min" name="age_min" value="{{ request('age_min') }}">
                </div>
                <div class="col-md-2">
                    <label for="age_max" class="form-label">Max Age</label>
                    <input type="number" class="form-control" id="age_max" name="age_max" value="{{ request('age_max') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>
</div>