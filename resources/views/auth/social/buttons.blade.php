@if ($socialProviders)
    <?php $colSize = 12 / count($socialProviders); ?>

    <div class="row pb-1 pt-2">
        @if (in_array('facebook', $socialProviders))
            <div class="col-{{ $colSize }} d-flex align-items-center justify-content-center">
                <a href="{{ url('auth/facebook/login') }}" class="btn-facebook" title="Access with Facebook">
                    <i class="fab fa-facebook fa-3x"></i>
                </a>
            </div>
        @endif

        @if (in_array('twitter', $socialProviders))
            <div class="col-{{ $colSize }} d-flex align-items-center justify-content-center">
                <a href="{{ url('auth/twitter/login') }}" class="btn-twitter" title="Access with Twitter">
                    <i class="fab fa-twitter fa-3x"></i>
                </a>
            </div>
        @endif

        @if (in_array('google', $socialProviders))
            <div class="col-{{ $colSize }} d-flex align-items-center justify-content-center">
                <a href="{{ url('auth/google/login') }}" class="btn-google" title="Access with Google+">
                    <i class="fab fa-google-plus-square fa-3x"></i>
                </a>
            </div>
        @endif
    </div>

@endif