


<div class="card card-default mb-4">
    <div class="card-header">
        Authorization Request
    </div>
    <div class="card-body">
        <!-- Introduction -->
        <p class="mb-3"><strong>{{ $client->name }}</strong> is requesting permission to access your account.</p>
        <span>It will redirect you to a page</span>

        <!-- Scope List -->
        @if (count($scopes) > 0)
            <div class="scopes">
                <p><strong>This application will be able to:</strong></p>

                <ul>
                    @foreach ($scopes as $scope)
                        <li>{{ $scope->description }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <!-- Authorize Button -->
            <form method="post" action="{{ route('passport.authorizations.approve') }}" class="d-inline">
                @csrf

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <button  class="v-btn mx-1 v-btn--elevated bg-green-darken-3 pa-2">Authorize</button>
            </form>

            <!-- Cancel Button -->
            <form method="post" action="{{ route('passport.authorizations.deny') }}" class="d-inline">
                @csrf
                @method('DELETE')

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <button  class="v-btn mx-1 v-btn--elevated bg-red-darken-3 pa-2">Cancel</button>
            </form>
        </div>
    </div>
</div>
